<?php

namespace Alkali\Post;

use Alkali\Post\Exception\ModelPostTypeMismatchException;
use stdClass;
use WP_Post;

abstract class Model{
    public $object;

    const string POST_TYPE = '';
    const string OBJECT_TYPE = '';
    const string ID_PROPERTY = 'ID';

    public function __construct($post = [])
    {
        $attributes =  is_array($post) ? $post : [];
        if (! $post instanceof WP_Post) {
            $post = new WP_Post(new stdClass);
            $post->post_type = static::postTypeId();
        } elseif ($post->post_type !== static::postTypeId()) {
            throw new ModelPostTypeMismatchException(static::class, $post);
        }

        $this->setObject($post);

    }

    public static function postTypeId(): string
    {
        return static::POST_TYPE;
    }

    public function setObject(mixed $post): self
    {
        $this->object = $post;
        return $this;
    }
    public function url()
    {
        return get_permalink($this->object->ID);
    }

    public static function fromID($id)
    {
        $post = WP_Post::get_instance($id);

        if (false === $post) {
            throw new \Exception("No post found with ID {$id}");
        }

        return new static($post);
    }

    public static function find(int $id): null|static
    {
        try {
            return static::fromID($id);
        }catch (\Exception $e){
            return null;
        }
    }
    public function trash(): Model
    {
        if (wp_trash_post($this->object->ID)) {
            $this->refresh();
        }
        return $this;
    }

    public function untrash(): Model
    {
        if (wp_untrash_post($this->object->ID)) {
            $this->refresh();
        }
        return $this;
    }
    public function delete()
    {
        if (wp_delete_post($this->object->ID, true) ) {
            $this->refresh();
        }
    }
    public function refresh(){
        $this->setObject(WP_Post::get_instance($this->object->ID));
        return $this;
    }
}
