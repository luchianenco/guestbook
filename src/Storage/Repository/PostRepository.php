<?php

namespace App\Storage\Repository;

use App\Storage\AdapterInterface;
use App\Storage\Entity\Post;
use App\Storage\Entity\User;
use App\Storage\Factory\PostFactory;
use App\Storage\Helper\PostHelper;
use App\Storage\Query\PostQuery;
use App\Storage\Query\Query;

/**
 * Class PostRepository
 * @package App\Storage\Repository
 */
class PostRepository implements RepositoryInterface
{
    private const DATE_FORMAT = 'Y-m-d H:i:s';

    /** @var AdapterInterface */
    private $storage;
    /** @var PostFactory */
    private $factory;

    /**
     * PostRepository constructor.
     * @param AdapterInterface $adapter
     * @param PostFactory $factory
     */
    public function __construct(AdapterInterface $adapter, PostFactory $factory)
    {
        $this->storage = $adapter;
        $this->factory = $factory;
    }

    /**
     * @return Post[]|null
     */
    public function findAll(): ?array
    {
        $query = new PostQuery();
        $query
            ->setJoinTable(User::TABLE)
            ->setJoinField(User::JOIN_FIELD)
            ->setOrderBy([Post::TABLE.'.created_at' => 'DESC'])
        ;

        return $this->find($query);
    }

    /**
     * @return Post[]|null
     */
    public function findPublished(): ?array
    {
        $query = new PostQuery();
        $query
            ->setWhere(['status' => PostHelper::STATUS_PUBLISHED])
            ->setJoinTable(User::TABLE)
            ->setJoinField(User::JOIN_FIELD)
            ->setOrderBy([Post::TABLE.'.created_at' => 'DESC'])
        ;

        return $this->find($query);
    }

    /**
     * @param int $id
     * @return Post|null
     */
    public function findById(int $id): ?Post
    {
        $query = new PostQuery();
        $query
            ->setWhere([Post::TABLE.'.id' => $id])
            ->setJoinTable(User::TABLE)
            ->setJoinField(User::JOIN_FIELD)
        ;
        $result = $this->find($query);

        return $result[0] ?? null;
    }

    /**
     * @param Query $query
     * @return Post[]|null
     */
    public function find(Query $query): ?array
    {
        $query->setTable(Post::TABLE);

        $result = $this->storage->select($query);
        if (!$result) {
            return null;
        }

        return $this->factory->create($result);
    }

    /**
     * @param Post $post
     * @param string $message
     * @return bool
     */
    public function updatePostFromRequest(Post $post, string $message): bool
    {
        $this->factory->updatePostFromRequest($post, $message);

        return $this->save($post);
    }

    /**
     * @param User $user
     * @param string $message
     * @return bool
     */
    public function newPost(User $user, string $message): bool
    {
        $post = $this->factory->createNewPost($user, $message);

        return $this->save($post);
    }

    /**
     * @param Post $post
     * @return bool
     */
    public function save(Post $post): bool
    {
        $insertValues = $this->preparePost($post);
        $query = new Query();
        $query
            ->setTable(Post::TABLE)
            ->setInsert($insertValues)
        ;

        return $this->storage->upsert($query);
    }

    /**
     * @param Post $post
     * @return array
     */
    public function preparePost(Post $post): array
    {
        $result = [
            Post::TABLE.'.message' => $post->getMessage(),
            Post::TABLE.'.is_image' => $post->isImage() ? 1 : 0,
            Post::TABLE.'.status' => $post->getStatus(),
            Post::TABLE.'.user_id' => $post->getUser()->getId(),
            Post::TABLE.'.created_at' => $post->getCreatedAt()->format(self::DATE_FORMAT),
            Post::TABLE.'.updated_at' => $post->getUpdatedAt()->format(self::DATE_FORMAT)
        ];

        if ($post->getId()) {
            $result[Post::TABLE.'.id'] = $post->getId();
        }

        return $result;
    }
}
