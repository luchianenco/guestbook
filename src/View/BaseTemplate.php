<?php

namespace App\View;

use App\Storage\Entity\User;

/**
 * Class Base
 * @package App\View
 */
abstract class BaseTemplate implements TemplateInterface
{
    /**
     * @param array $vars
     * @return string
     */
    public function getView(array $vars): string
    {
        return $this->getHeader() . $this->getBody($vars) . $this->getFooter();
    }

    /**
     * @param array $vars
     * @return string
     */
    abstract protected function getBody(array $vars): string;

    /**
     * @return string
     */
    protected function getHeader(): string
    {
        return <<<'EOT'
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <title>GuestBook</title>
                <meta charset="utf-8">
                <meta name="robots" content="index, follow">
                <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
                <meta http-equiv="x-ua-compatible" content="ie=edge">
                <meta name="description" content="Artifact Game">
                <meta name="author" content="Serghei Luchianenco">
                <link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre.min.css">
                <link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre-exp.min.css">
                <link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre-icons.min.css">
            </head>
            <body>
EOT;
    }

    /**
     * @param User|null $user
     * @return string
     */
    protected function showUserBlock(User $user = null): string
    {
        if ($user) {
            return <<<USER
                <div>Hello {$user->getUsername()}!</div>
                <div class="pt-2">
                  <a href="javascript:" onclick="document.getElementById('new-post-modal').classList.add('active')">
                    Add new Post
                  </a>
                </div>
                <div class="pt-2">
                    <a href="/logout">Logout</a>
                </div>
                {$this->showNewPostModal()}
USER;
        }

        return <<<FORM
            <form name="login" method="post" action="/login">
                <div class="form-group">
                  <label class="form-label" for="username">Name</label>
                  <input name="username" class="form-input" type="text" id="username" placeholder="Username">
                </div>
                <div class="form-group">
                  <label class="form-label" for="password">Password</label>
                  <input name="password" class="form-input" type="text" id="password" placeholder="Password">
                </div>
                <button class="btn btn-primary">Submit</button>
            </form>
FORM;
    }

    protected function showNewPostModal(): string
    {
        return <<<NEWPOST
            <div class="modal modal-lg" id="new-post-modal">
              <a href="javascript:" onclick="document.getElementById('new-post-modal').classList.remove('active')" class="modal-overlay" aria-label="Close"></a>
              <div class="modal-container">
                <div class="modal-header">
                  <a href="javascript:" onclick="document.getElementById('new-post-modal').classList.remove('active')" class="btn btn-clear float-right" aria-label="Close"></a>
                  <div class="modal-title h5">New GuestBook Post</div>
                </div>
                <div class="modal-body">
                  <div class="content">
                    <form name="new-post-form" method="post" action="/post" id="new-post-form">
                      <div class="form-group">
                        <label class="form-label" for="message">Message Text</label>
                        <textarea name="message" class="form-input" id="message" placeholder="Message Text"></textarea>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-primary" onclick="document.getElementById('new-post-form').submit()">Submit</button>
                </div>
              </div>
            </div>
NEWPOST;
    }

    /**
     * @return string
     */
    protected function getFooter(): string
    {
        return <<<'EOT'
            </body>
            </html>
EOT;
    }
}
