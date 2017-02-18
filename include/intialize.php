<?php
defined('DS')?NULL: define('DS',DIRECTORY_SEPARATOR);
defined('SITE_ROOT')?NULL:define('SITE_ROOT', DS.'opt'.DS.'lampp'.DS.'htdocs'.DS.'blog');
defined('LIB_PATH')?NULL:define('LIB_PATH',SITE_ROOT.DS.'include');

require_once(LIB_PATH.DS.'db_config.php');
require_once(LIB_PATH.DS.'functions.php');
require_once(LIB_PATH.DS.'user.php');
require_once(LIB_PATH.DS.'session.php');
require_once(LIB_PATH.DS.'form_validation.php');
require_once(LIB_PATH.DS.'subject.php');
require_once(LIB_PATH.DS.'dbobject.php');
require_once(LIB_PATH.DS.'photo.php');
require_once(LIB_PATH.DS.'photo_user.php');
require_once(LIB_PATH.DS.'posts.php');
require_once(LIB_PATH.DS.'post_photo.php');
require_once(LIB_PATH.DS.'comment.php');