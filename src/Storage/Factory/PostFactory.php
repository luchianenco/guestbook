<?php

namespace App\Storage\Factory;

use App\Exception\InvalidArgumentException;
use App\Http\Message\RequestInterface;
use App\Storage\Entity\Post;
use App\Storage\Entity\User;
use App\Storage\Helper\PostHelper;

/**
 * Class PostFactory
 * @package App\Storage\Factory
 */
class PostFactory
{
    /** @var UserFactory */
    private $userFactory;

    /**
     * PostFactory constructor.
     * @param UserFactory $userFactory
     */
    public function __construct(UserFactory $userFactory)
    {
        $this->userFactory = $userFactory;
    }

    /**
     * @param \Generator $generator
     * @return array
     */
    public function create(\Generator $generator): array
    {
        $posts = [];
        foreach ($generator as $row) {
            $posts[] = $this->createPostFromArray($row);
        }

        return $posts;
    }

    /**
     * @param array $row
     * @return Post
     */
    private function createPostFromArray(array $row): Post
    {
        $user = $this->userFactory->createFromArray([
            'username' => $row['user_username'],
            'id' => $row['user_id']
        ]);

        $isImage = $row['is_image'] ? true : false;
        $createdAt = $this->createDateFromString($row['created_at']);
        $post = new Post($row['message'], $isImage, $row['status'], $user, $createdAt);
        $post->setId($row['id']);

        return $post;
    }

    /**
     * @param User $user
     * @param string $message
     * @return Post
     */
    public function createNewPost(User $user, string $message): Post
    {
        $post = new Post($message, $this->isImage($message), PostHelper::STATUS_DRAFT, $user);

        return $post;
    }

    /**
     * @param Post $post
     * @param string $message
     * @return Post
     */
    public function updatePostFromRequest(Post $post, string $message): Post
    {
        $post->setMessage($message);
        $post->setUpdatedAt(new \DateTime());

        return $post;
    }

    /**
     * @param string $message
     * @return bool
     */
    private function isImage(string $message): bool
    {
        $imgExtensions = array('gif', 'jpg', 'jpeg', 'png');
        $urlExtension = pathinfo($message, PATHINFO_EXTENSION);
        if (\in_array($urlExtension, $imgExtensions, true)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $value
     * @return \DateTime|null
     */
    private function createDateFromString(string $value): ?\DateTime
    {
        if (null === $value) {
            return null;
        }

        $date = \DateTime::createFromFormat('Y-m-d H:i:s', $value);

        return $date ?: null;
    }
}
