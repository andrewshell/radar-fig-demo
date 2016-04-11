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
        $this->excerpt = $excerpt;
    }

    public function withId($id)
    {
        return new PostEntity(
            $this->title,
            $this->content,
            $this->excerpt,
            $id
        );
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
        if (empty($this->excerpt)) {
            return $this->excerptFromContent($this->content);
        }
        return $this->excerpt;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function sameIdAs(Post $post)
    {
        return 0 === strcmp($this->id, $post->id);
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
