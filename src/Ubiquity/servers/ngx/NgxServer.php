<?php
namespace Ubiquity\servers\ngx;

use Ubiquity\utils\http\foundation\NgxHttp;

/**
 * Ubiquity\servers\workerman$NgxServer
 * This class is part of Ubiquity
 *
 * @author jcheron <myaddressmail@gmail.com>
 * @version 1.0.0
 */
class NgxServer {

	private static $httpInstance;

	public static function init(&$config, $onStart = null) {
		\Ubiquity\controllers\Startup::init($config);
		self::$httpInstance = new NgxHttp();
		\Ubiquity\controllers\Startup::setHttpInstance(self::$httpInstance);
		if (\is_callable($onStart)) {
			$onStart();
		}
	}

	public static function handleRequest() {
		self::$httpInstance->setRequest();
		$_GET['c'] = \ltrim(\urldecode(\parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)), '/');
		//\Ubiquity\controllers\StartupAsync::forward($_GET['c']);
		echo "bla";
		error_log($_GET['c'],7);
	}
}

