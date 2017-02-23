<?php
#Show Error
define('APP_SHOW_ERROR', true);

@ini_set('display_errors', (APP_SHOW_ERROR) ? 'On' : 'Off');
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
if(defined('E_DEPRECATED')) {
error_reporting(error_reporting() & ~E_DEPRECATED);
}
define('SHOW_SQL_ERROR', APP_SHOW_ERROR);

define('APP_VERSION', '2.7.1.1');
define('APP_INSTALL_HASH', '88bb8fdbdbd9c5660d017a53b9936308c08aa606');

define('APP_ROOT', dirname(__FILE__));
define('APP_DOMAIN_PATH', 'localhost/mert/wp-content/plugins/iwp/');

define('EXECUTE_FILE', 'execute.php');
define('DEFAULT_MAX_CLIENT_REQUEST_TIMEOUT', 180);//Request to client wp

$config = array();
$config['SQL_DATABASE'] = 'mert';
$config['SQL_HOST'] = 'localhost';
$config['SQL_USERNAME'] = 'root';
$config['SQL_PASSWORD'] = '';
$config['SQL_PORT'] = '3306';
$config['SQL_TABLE_NAME_PREFIX'] = 'iwp_';
