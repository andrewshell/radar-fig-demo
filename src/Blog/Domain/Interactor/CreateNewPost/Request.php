<?php
namespace Blog\Domain\Interactor\CreateNewPost;

class Request
{
    protected $title;
    protected $content;
    protected $excerpt;

    public function __construct($title, $content, $excerpt)
    {
        $this->title = $title;
        $this->content = $content;
        $this->excerpt = $excerpt;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getExcerpt()
    {
        return $this->excerpt;
    }
}
