<?php
 namespace MailPoetVendor\Doctrine\DBAL; if (!defined('ABSPATH')) exit; use function str_replace; use function strtolower; use function version_compare; class Version { public const VERSION = '2.9.3'; public static function compare($version) { $currentVersion = \str_replace(' ', '', \strtolower(self::VERSION)); $version = \str_replace(' ', '', $version); return \version_compare($version, $currentVersion); } } 