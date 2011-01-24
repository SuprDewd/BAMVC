<?php

define('NL', PHP_EOL);
define('DS', DIRECTORY_SEPARATOR);
define('WDS', '/');
define('Root', dirname(dirname(__FILE__))  . DS);

define('Models',      Root . 'Models'      . DS);
define('Views',       Root . 'Views'       . DS);
define('Controllers', Root . 'Controllers' . DS);
define('Temp',        Root . 'Temp'        . DS);
define('Library',     Root . 'Library'     . DS);
define('Content',     Root . 'Content'     . DS);
define('Config',      Root . 'Config'      . DS);

define('Components',  Controllers . 'Components' . DS);

define('Helpers',     Views . 'Helpers'  . DS);
define('Elements',    Views . 'Elements' . DS);
define('SharedViews', Views . 'Shared'   . DS);

define('Logs',  Temp . 'Logs'  . DS);
define('Cache', Temp . 'Cache' . DS);

define('DefaultViews',       Library . 'Views'       . DS);
define('DefaultControllers', Library . 'Controllers' . DS);
define('DefaultConfig',      Library . 'Config'      . DS);

define('DefaultHelpers',     DefaultViews . 'Helpers'  . DS);
define('DefaultElements',    DefaultViews . 'Elements' . DS);
define('DefaultSharedViews', DefaultViews . 'Shared'   . DS);

define('DefaultComponents',  DefaultControllers . 'Components' . DS);

require_once Library . 'Bootstrap.php';

define('Request', isset($_GET['Request']) ? $_GET['Request'] : '');
define('WebRoot', rtrim(substr($_SERVER['PHP_SELF'], 0, strpos($_SERVER['PHP_SELF'], WDS . 'Content' . WDS .'index.php')), WDS) . WDS);

if (Config::Read('TryCompressOutput')) ob_start('ob_gzhandler');

Router::Initialize();
Debug::Dump(Config::Read('Debug.Log'));
