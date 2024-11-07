<?php

// Plugin Name: Alkali

use Alkali\Event\Hook;
use Alkali\Post\Model;
use Alkali\Post\ClassNameAsPostType;

require_once 'vendor/autoload.php';

class Page extends Model{
    use ClassNameAsPostType;
}


Hook::on('plugins_loaded')->setCallback(function () {
    if (! is_admin()){
        $post = Page::find(2);
        print_r($post->untrash());
        wp_die();
    }

})->listen();
