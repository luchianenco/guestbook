<?php

namespace App\Service;

use App\Exception\InvalidArgumentException;
use App\Exception\LogicException;
use App\Http\Message\RequestInterface;
use App\Storage\Entity\Post;
use App\Storage\Entity\User;
use App\Storage\Factory\PostFactory;
use App\Storage\Repository\PostRepository;

/**
 * Class EntryService
 * @package App\Service
 */
class PostService
{
    /** @var PostRepository */
    private $repository;

    /**
     * EntryService constructor.
     * @param PostRepository $repository
     */
    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get Posts Based on User Role
     * @param User $user
     * @return Post|Post[]|null
     */
    public function getPostsForUser(User $user = null)
    {
        // If Admin Get All Posts
        if ($user instanceof User && $user->isAdmin()) {
            return $this->getAll();
        }

        // The user is Not Admin, get all Published Posts
        return $this->getPublished();
    }

    /**
     * Get All Posts
     * @return Post[]|Post|null
     */
    public function getAll()
    {
        return $this->repository->findAll();
    }

    /**
     * Get All Posts with Status Published
     * @return Post|Post[]|null
     */
    public function getPublished()
    {
        return $this->repository->findPublished();
    }

    /**
     * Get Post By Id
     * @param int $id
     * @return Post|null
     */
    public function get(int $id): ?Post
    {
        return $this->repository->findById($id);
    }

    /**
     * @param RequestInterface $request
     * @return bool
     */
    public function updatePost(RequestInterface $request): bool
    {
        $id = $request->get('id');
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            throw new InvalidArgumentException('Post ID should be an integer');
        }

        $post = $this->repository->findById($id);
        if (!$post instanceof Post) {
            throw new LogicException(sprintf('The Post with id %s does not exists', $id));
        }

        return $this->repository->updatePostFromRequest($post, $request->get('message'));
    }

    /**
     * Create New Post
     * @param User $user
     * @param RequestInterface $request
     * @return bool
     */
    public function newPost(User $user, RequestInterface $request): bool
    {
        if (!$request->get('message')) {
            throw new InvalidArgumentException('Post Message cannot be empty');
        }

        $message = $request->get('message');

        return $this->repository->newPost($user, $message);
    }

    /**
     * Change Post Status
     * @param RequestInterface $request
     * @return bool
     */
    public function changeStatus(RequestInterface $request): bool
    {
        $postId = $request->get('post_id');
        $post = $this->repository->findById($postId);

        if (null === $post) {
            return null;
        }
        $newStatus = $request->get('status');
        $post->setStatus($newStatus);

        return $this->repository->save($post);
    }
}
