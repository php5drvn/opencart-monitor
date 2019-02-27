<?php


define('DIR_APP', str_replace('\\', '/', realpath(dirname(__FILE__))) . '/');
define('DIR_SYSTEM', DIR_APP.'system/');

$config = array(
  'login' => '..email..',
  'password' => '..opencart password..',
  'pin' => '..ping..',
  'title' => 'Filter 1',
  'description' => 'Filter 1 Filter 1 Filter 1 Filter 1',
  'category_id' => '20',
  'tag' => 'tags',
  'cookie' => DIR_APP.'cookie.txt'
);