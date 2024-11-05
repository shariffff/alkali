<?php

// Plugin Name: Alkali

use Alkali\Event\Hook;

require_once 'vendor/autoload.php';


Hook::on('init')->setCallback('login_errors')->remove();
