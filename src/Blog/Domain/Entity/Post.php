<?php
namespace Blog\Domain\Entity;

class Post
{
    private $id;
    private $title;
    private $content;
    private $excerpt;

    public function __construct($title, $content, $excerpt = '', $id = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        if (empty($excerpt)) {
            $this->excerpt = $this->excerptFromContent($content);
        } else {
            $this->excerpt = $excerpt;
        }
    }

    public function hasId()
    {
        return !is_null($this->id);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getExcerpt()
    {
        return $this->excerpt;
    }

    public function getContent()
    {
        return $this->content;
    }

    protected function excerptFromContent($content)
    {
        if (strlen($content) > 140) {
            return substr($content, 0, 137) . '...';
        } else {
            return $content;
        }
    }
}
