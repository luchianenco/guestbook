<?php

namespace App\Storage\Entity;

use App\Exception\InvalidArgumentException;
use App\Storage\Helper\PostHelper;

/**
 * Class Post
 * @package App\Storage\Entity
 */
class Post
{
    public const TABLE = 'posts';
    public const JOIN_FIELD = 'post_id';

    /** @var int */
    private $id;
    /** @var string */
    private $message;
    /** @var bool */
    private $isImage;
    /** @var string */
    private $status;
    /** @var User */
    private $user;
    /** @var \DateTime */
    private $createdAt;
    /** @var \DateTime */
    private $updatedAt;

    /**
     * Post constructor.
     * @param string $message
     * @param bool $isImage
     * @param string $status
     * @param User $user
     * @param \DateTime|null $createdAt
     */
    public function __construct(string $message, bool $isImage, string $status, User $user, \DateTime $createdAt = null)
    {
        $this->message = $message;
        $this->isImage = $isImage;
        $this->status = $status;
        $this->user = $user;
        $this->createdAt = $createdAt ?? new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Post
     */
    public function setId(int $id): Post
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Post
     */
    public function setMessage(string $message): Post
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return bool
     */
    public function isImage(): bool
    {
        return $this->isImage;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return Post
     */
    public function setStatus(string $status): Post
    {
        if (!\in_array($status, PostHelper::STATUS, true)) {
            throw new InvalidArgumentException(sprintf('Status cannot be set to %s', $status));
        }
        $this->status = $status;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return Post
     */
    public function setUpdatedAt(\DateTime $updatedAt): Post
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
