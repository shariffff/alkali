<?php

namespace Alkali\Post\Exception;

use WP_Post;


class ModelPostTypeMismatchException extends \RuntimeException
{
    const MESSAGE_FORMAT = '{modelClass} instantiated with post of type "{givenPostType}", but requires a post of type "{modelPostType}".';

    public function __construct(protected $modelClass, protected WP_Post $post)
    {
        $this->message = str_replace([
            '{modelClass}',
            '{givenPostType}',
            '{modelPostType}'
        ], [
            $modelClass,
            $post->post_type,
            call_user_func([$modelClass, 'postTypeId'])
        ], static::MESSAGE_FORMAT);
    }
}
