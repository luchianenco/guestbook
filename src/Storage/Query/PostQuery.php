<?php

namespace App\Storage\Query;

use App\Storage\Entity\Post;
use App\Storage\Entity\User;

/**
 * Class PostQuery
 * @package App\Storage\Query
 */
class PostQuery extends Query
{
    /**
     * PostQuery constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->select = $this->defaultSelect();
    }

    /**
     * @return array
     */
    private function defaultSelect(): array
    {
        return [
            Post::TABLE.'.id as id',
            Post::TABLE.'.message as message',
            Post::TABLE.'.is_image as is_image',
            Post::TABLE.'.status as status',
            Post::TABLE.'.created_at as created_at',
            User::TABLE.'.id as user_id',
            User::TABLE.'.username as user_username',
            User::TABLE.'.is_admin as user_is_admin'
        ];
    }
}
