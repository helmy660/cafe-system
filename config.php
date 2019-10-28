<?php

// setting the output buffer
ob_start();

//error handling
ini_set('display_errors' , 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);

//turn off register globals
ini_set('register_globals' , 0);

//define app constants

//Shortcuts
define('DS' , DIRECTORY_SEPARATOR);
define('PS' , PATH_SEPARATOR);
//domaine related constants
define( 'HOST_NAME' , 'http://' .  $_SERVER['HTTP_HOST'] . '/');
//paths
define('APP_PATH' , realpath(dirname(__FILE__)) . DS );
define( 'TEMPLATE_PATH' , APP_PATH . 'templates' . DS);
define( "LIB_PATH" , APP_PATH . 'lib' . DS);
define( "MODELS_PATH" , APP_PATH . 'models' . DS);
define( "VIEWS_PATH" , APP_PATH . 'views' . DS);
//DB credentials
// define('DB_HOST' , 'sql2.freesqldatabase.com');
// define('DB_NAME' , 'sql2283442');
// define('DB_USER' , 'sql2283442');
// define('DB_PASS' , 'kM3%iN7%');

define('DB_HOST' , '127.0.0.1');
define('DB_NAME' , 'cafeteria_system');
define('DB_USER' , 'Gom3a');
define('DB_PASS' , '123456');

//setting new path
$path =  get_include_path() . PS . LIB_PATH . PS . MODELS_PATH;
set_include_path($path);

//adding autoloading
// require_once('./lib/dbConnection.php');
function __autoload($class){
    require_once($class . '.php');
}

$dbh = DBConnection::getInstance();



//end buffer and send output
ob_flush();
?>