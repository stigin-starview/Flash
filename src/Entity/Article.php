<?php

namespace learnspace\flash\Entity;

class Article
{
public function __construct(private int $id, private string $title, private string $content)
{
}

    public function getContent(): string
    {
        return $this->content;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getId(): int
    {
        return $this->id;
    }
}