<?php
 namespace MailPoetVendor\Doctrine\ORM\Cache\Persister\Entity; if (!defined('ABSPATH')) exit; use MailPoetVendor\Doctrine\ORM\Cache\CacheException; use MailPoetVendor\Doctrine\Common\Util\ClassUtils; class ReadOnlyCachedEntityPersister extends \MailPoetVendor\Doctrine\ORM\Cache\Persister\Entity\NonStrictReadWriteCachedEntityPersister { public function update($entity) { throw \MailPoetVendor\Doctrine\ORM\Cache\CacheException::updateReadOnlyEntity(\MailPoetVendor\Doctrine\Common\Util\ClassUtils::getClass($entity)); } } 