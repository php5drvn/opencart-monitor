<?php
define('DIR_ROOT', str_replace('\\', '/', realpath(dirname(__FILE__))) . '/');
define('DIR_APP', DIR_ROOT.'app/');
define('DIR_SYSTEM', DIR_ROOT.'system/');
define('DIR_STORAGE', DIR_SYSTEM.'storage/');

$config = array(
  'login' => 'php5.drvn@gmail.com',
  'password' => 'dream5lin',
  'pin' => '2001',
  'title' => 'Filter 1',
  'description' => 'Filter 1 Filter 1 Filter 1 Filter 1',
  'category_id' => '20',
  'tag' => 'tags',
  'cookie' => DIR_STORAGE.'cookie/cookie.txt'
);