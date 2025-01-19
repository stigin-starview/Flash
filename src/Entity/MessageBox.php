<?php

declare(strict_types=1);

/**
 * This entity represents the table
 */
namespace learnspace\flash\Entity;

class MessageBox
{
    public $id;
    public $content;
    public $created_at;

    public function __construct($data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->content = $data['content'] ?? '';
        $this->created_at = $data['created_at'] ?? null;
    }
}