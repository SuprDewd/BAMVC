<?php

Config::Write('Router.CustomRoutes', array(
	'/^Animals(\/.*)?$/' => 'Home$1',
	'/^Login$/i' => 'User/Login',
	'/^Logout$/i' => 'User/Logout',
	'/^Register$/i' => 'User/Register'
));