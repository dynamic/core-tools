<?php
/**
 * Bootstrapping for the core-tools unit tests
 *
 * @package core-tools
 * @author  Dynamic <dev@dynamicagency.com>
 */

define('CORE_TOOLS_BASE_DIR', realpath(__DIR__ . '/..'));
require '../vendor/autoload.php';

global $_FILE_TO_URL_MAPPING;
$_FILE_TO_URL_MAPPING[CORE_TOOLS_BASE_DIR] = 'http://localhost';

global $databaseConfig;
$databaseConfig = [
  'type'     => 'MySQLDatabase',
  'server'   => '127.0.0.1',
  'username' => 'root',
  'password' => '',
  'database' => 'core-tools-tests'
];