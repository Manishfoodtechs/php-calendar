<?php
/*
 * Copyright 2012 Sean Proctor
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * The following variables are intended to be modified to fit your
 * setup.
 */

if (!defined('IN_PHPC'))
	define('IN_PHPC', true);

/*
 * If you want different scripts with different default calendars, you can
 * copy this script and modify $default_calendar_id to contain the CID of
 * the calendar you want to be the default
 */
$default_calendar_id = 1;

/*
 * $phpc_root_path gives the location of the base calendar install.
 * if you move this file to a new location, modify $phpc_root_path to point
 * to the location where the support files for the callendar are located.
 */
$phpc_includes_path = dirname(__FILE__);
$phpc_root_path = dirname($phpc_includes_path);
$phpc_config_file = "$phpc_root_path/config.php";
$phpc_locale_path = "$phpc_root_path/locale";
require_once "$phpc_includes_path/util.php";
$phpc_script = phpc_html_escape($_SERVER['PHP_SELF']);

$phpc_server = $_SERVER['SERVER_NAME'];
if(!empty($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != 80)
	$phpc_server .= ":{$_SERVER["SERVER_PORT"]}";

// Protcol ex. http or https
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off'
		|| $_SERVER['SERVER_PORT'] == 443
		|| isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
		|| isset($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
    $phpc_proto = "https";
} else {
    $phpc_proto = "http";
}

$phpc_home_url="$phpc_proto://$phpc_server$phpc_script";
$phpc_url = $phpc_home_url
		. (empty($_SERVER['QUERY_STRING']) ? ''
		   : '?' . $_SERVER['QUERY_STRING']);

// Remove this line if you must
ini_set('arg_separator.output', '&amp;');

// Buffer the output until the script ends. Remove this if you must, but it may
//   break things in unexpected ways.
ob_start();


require_once("$phpc_includes_path/setup.php");

