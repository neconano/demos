<?php
ini_set('display_errors',true);
error_reporting(7);
define ('APP_NAME','App');
define ('APP_PATH','App/');
require APP_PATH."/Conf/app_debug.php";
//add by gaopeng begin
define('MODE_NAME','mycore');
//end
require 'Base/ThinkPHP.php';