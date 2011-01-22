<?php

define('NL', PHP_EOL);
define('DS', DIRECTORY_SEPARATOR);
define('WDS', '/');
define('Root', dirname(dirname(__FILE__))   . DS);

define('Models',      Root  . 'Models'      . DS);
define('Views',       Root  . 'Views'       . DS);
define('Controllers', Root  . 'Controllers' . DS);
define('Temp',        Root  . 'Temp'        . DS);
define('Library',     Root  . 'Library'     . DS);
define('Content',     Root  . 'Content'     . DS);
define('Config',      Root  . 'Config'      . DS);

define('SharedViews', Views . 'Shared'      . DS);

require_once Library . 'Bootstrap.php';

define('Request', isset($_GET['Request']) ? $_GET['Request'] : '');

Router::Initialize();