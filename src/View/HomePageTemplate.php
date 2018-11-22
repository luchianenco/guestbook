<?php

namespace App\View;

use App\View\Post\PostTemplate;

/**
 * Class HomePageTemplate
 * @package App\View
 */
class HomePageTemplate extends BaseTemplate
{
    /**
     * @param array $vars
     * @return string
     */
    protected function getBody(array $vars): string
    {
        return <<<BODY
        <div class="container">
            <div class="columns">
                <div class="column col-3 bg-gray">
                    <h4>GuestBook</h4>
                    <div>{$this->showUserBlock($vars['user'])}</div>   
                </ul>
            </div>
            <div class="column col-9">
                {$this->buildPosts($vars)}
            </div>
          </div>
        </div>
BODY;
    }

    /**
     * @param array $vars
     * @return string
     */
    private function buildPosts(array $vars): string
    {
        $postTemplate = new PostTemplate();

        return $postTemplate->getView($vars);
    }
}
