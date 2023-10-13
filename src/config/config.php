<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');
define('BASE_PATH', dirname(dirname(__FILE__)));
define('CURRENT_PAGE', basename($_SERVER['REQUEST_URI']));

require_once BASE_PATH . '/helpers/helpers.php';

define('CURRENT_FOLDER', base_url());
define('OAUTH_SERVER', getenv("OAUTH_SERVER"));