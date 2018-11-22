<?php

namespace App\Storage\Helper;

/**
 * Class PostHelper
 * @package App\Storage\Helper
 */
class PostHelper
{
    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_DELETED = 'deleted';

    public const STATUS = [self::STATUS_DRAFT, self::STATUS_PUBLISHED, self::STATUS_DELETED];
}
