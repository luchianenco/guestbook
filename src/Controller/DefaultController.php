<?php

namespace App\Controller;

use App\Exception\NotFoundException;
use App\Exception\RouteNotFoundException;
use App\Http\Message\Redirect;
use App\Http\Message\RequestInterface;
use App\Http\Message\Response;
use App\Http\Message\ResponseInterface;
use App\Http\Session\SessionManagerInterface;
use App\Service\PostService;
use App\Storage\Entity\User;
use App\View\HomePageTemplate;
use App\View\Post\PostEditTemplate;

/**
 * Class DefaultController
 * @package App\Controller
 */
class DefaultController
{
    /** @var PostService */
    private $postService;
    /** @var SessionManagerInterface */
    private $sessionManager;

    /**
     * DefaultController constructor.
     * @param PostService $postService
     * @param SessionManagerInterface $sessionManager
     */
    public function __construct(PostService $postService, SessionManagerInterface $sessionManager)
    {
        $this->postService = $postService;
        $this->sessionManager = $sessionManager;
    }

    /**
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        $user = $this->getUserSession();
        $posts = $this->postService->getPostsForUser($user);
        $template = new HomePageTemplate();

        return new Response(
            Response::HTTP_OK,
            $template->getView(['posts' => $posts, 'user' => $user ?: null])
        );
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function newPost(RequestInterface $request): ResponseInterface
    {
        $user = $this->getUserSession();
        if (!$user) {
            throw new RouteNotFoundException('User is not authorized');
        }

        $this->postService->newPost($user, $request);

        return new Redirect('/');
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function editPost(RequestInterface $request): ResponseInterface
    {
        if (!$this->isUserAdmin()) {
            throw new RouteNotFoundException('User is not administrator');
        }

        $id = $request->get('id');
        $post = $this->postService->get($id);
        if (!$post) {
            throw new NotFoundException(sprintf('Post with ID %s is not found', $id));
        }
        $template = new PostEditTemplate();

        return new Response(200, $template->getView(['post' => $post]));
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function updatePost(RequestInterface $request): ResponseInterface
    {
        if (!$this->isUserAdmin()) {
            throw new RouteNotFoundException('User is not administrator');
        }
        // TODO process if post is not updated
        $this->postService->updatePost($request);

        return new Redirect('/');
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function changeStatus(RequestInterface $request): ResponseInterface
    {
        if (!$this->isUserAdmin()) {
            throw new RouteNotFoundException('User is not administrator');
        }

        // TODO process if post is not saved
        $this->postService->changeStatus($request);

        return new Redirect('/');
    }

    /**
     * @return bool
     */
    private function isUserAdmin(): bool
    {
        $user = $this->getUserSession();

        return $user instanceof User && $user->isAdmin();
    }

    /**
     * @return User|null
     */
    private function getUserSession(): ?User
    {
        return $this->sessionManager->get('user');
    }
}
