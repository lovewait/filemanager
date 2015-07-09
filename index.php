<?php
/**
 * Created by PhpStorm.
 * User: SNOVA
 * Date: 2015/7/9
 * Time: 13:51
 * 入口文件
 */
define('ROOT_PATH',dirname(str_replace('\\','/',__FILE__)));
define('APP_PATH','./FileSystem');//定义文件根目录
define('FILE_ROOT','C:\Users\SNOVA\Downloads');
require APP_PATH.'/Lib/Core.php';
Core::init();