<?php

namespace App\View\Post;

use App\Storage\Entity\Post;
use App\Storage\Entity\User;
use App\Storage\Helper\PostHelper;
use App\View\BaseTemplate;

/**
 * Class PostTemplate
 * @package App\View\Post
 */
class PostTemplate extends BaseTemplate
{
    /**
     * @param array $vars
     * @return string
     */
    protected function getBody(array $vars): string
    {
        $postTemplates = '';
        foreach ($vars['posts']as $post) {
            $postTemplates .= $this->postTemplate($post, $vars['user']);
        }

        return $postTemplates . $this->statusChangeForm();
    }

    /**
     * @param Post $post
     * @param User|null $user
     * @return string
     */
    private function postTemplate(Post $post, User $user = null): string
    {
        return <<<POST
        <div class="card">
          <div class="card-header">
            <div class="card-subtitle text-gray">
              {$post->getUser()->getUsername()} @ {$post->getCreatedAt()->format('d-m-Y H:i')}
            </div>
          </div>
          <div class="card-body">
            {$this->displayMessage($post)}
          </div>
          {$this->postFooterTemplate($post, $user)}
        </div>
POST;
    }

    /**
     * @param Post $post
     * @return string
     */
    private function displayMessage(Post $post): string
    {
        if ($post->isImage()) {
            return sprintf('<img src="%s" width="300">', $post->getMessage());
        }

        return $post->getMessage();
    }

    /**
     * @return string
     */
    private function statusChangeForm(): string
    {
        return <<<FORM
            <form name="status-change" method="post" action="/post/status" id="form-sc">
                <input type="hidden" name="post_id" value="" id="form-sc-post-id">
                <input type="hidden" name="status" value="" id="form-sc-status">
            </form>
            <script>
                function setStatusChangeForm(post_id, status) {
                    document.getElementById('form-sc-post-id').value = post_id;
                    document.getElementById('form-sc-status').value = status;
                    document.getElementById('form-sc').submit();
                } 
            </script>
FORM;
    }

    /**
     * @param Post $post
     * @param User|null $user
     * @return string
     */
    private function postFooterTemplate(Post $post, User $user = null): string
    {
        if (!$user instanceof User || !$user->isAdmin()) {
            return '';
        }

        $jsCallDeleted = 'setStatusChangeForm('.$post->getId().',\'deleted\')';
        $jsCallPublished = 'setStatusChangeForm('.$post->getId().',\'published\')';
        switch ($post->getStatus()) {
            case PostHelper::STATUS_DRAFT:
                $status = '<span class="text-warning">Draft</span>';
                $buttons = '<button class="btn m-2 btn-error" 
                        onclick="'.$jsCallDeleted.'">Delete</button>'
                    .'<button class="btn m-2 btn-success" 
                        onclick="'.$jsCallPublished.'">Publish</button>';
                break;
            case PostHelper::STATUS_PUBLISHED:
                $buttons = '<button class="btn btn-error" onclick="'.$jsCallDeleted.'">Delete</button>';
                $status = '<span class="text-success">Published</span>';
                break;
            default:
                $buttons = '<button class="btn m-2 btn-success" onclick="'.$jsCallPublished.'">Publish</button>';
                $status = '<span class="text-error">Deleted</span>';
        }

        $buttons .= '<button class="btn m-2 btn" onclick="window.location.href=\'/post/edit?id='.$post->getId().'\'">Edit</button>';

        return <<<FOOTER
            <div class="card-footer">
                <div class="container">
                    <div class="columns">
                        <div class="col-3 text-gray">Status: {$status}</div>
                        <div class="col-9">{$buttons}</div>
                    </div>
                </div>
            </div>
FOOTER;
    }
}
