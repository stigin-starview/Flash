<?php

declare(strict_types=1);

/**
 * This entity represents the table
 */
namespace learnspace\flash\Entity;

class MessageBoxEntity
{
    private $id;
    private $content;
    private $created_at;

    public function __construct($data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->content = $data['content'] ?? '';
        $this->created_at = $data['created_at'] ?? null;
    }

    // Add setters and getters

    public function getId(): string
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function setContent(string $content): void
    {
        if (empty($content)) {
            throw new \InvalidArgumentException("Message content cannot be empty.");
        }

        if (strlen($content) > 255) {
            throw new \InvalidArgumentException("Message content must not exceed 255 characters.");
        }

        $this->content = $content;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->created_at = $createdAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'created_at' => $this->created_at,
        ];
    }

}
