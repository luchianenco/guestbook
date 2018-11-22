<?php

namespace App\View\Post;

use App\Storage\Entity\Post;
use App\View\BaseTemplate;

/**
 * Class PostEditTemplate
 * @package App\View\Post
 */
class PostEditTemplate extends BaseTemplate
{
    /**
     * @param array $vars
     * @return string
     */
    protected function getBody(array $vars): string
    {
        return $this->showModal($vars['post']);
    }

    private function showModal(Post $post): string
    {
        return <<<EDITPOST
            <div class="modal modal-lg active" id="edit-post-modal">
              <a href="javascript:" onclick="window.location.href='/';" class="modal-overlay" aria-label="Close"></a>
              <div class="modal-container">
                <div class="modal-header">
                  <a href="javascript:" onclick="window.location.href='/';" class="btn btn-clear float-right" aria-label="Close"></a>
                  <div class="modal-title h5">Edit GuestBook Post</div>
                </div>
                <div class="modal-body">
                  <div class="content">
                    <form name="edit-post-form" method="post" action="/post/update" id="edit-post-form">
                      <div class="form-group">
                        <label class="form-label" for="message">Message Text</label>
                        <textarea name="message" class="form-input" id="message" placeholder="Message Text">{$post->getMessage()}</textarea>
                        <input type="hidden" name="id" id="post_id" value="{$post->getId()}"/>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-primary" onclick="document.getElementById('edit-post-form').submit()">Submit</button>
                </div>
              </div>
            </div>
EDITPOST;
    }
}
