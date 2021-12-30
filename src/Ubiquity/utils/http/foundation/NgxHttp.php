<?php
namespace Ubiquity\utils\http\foundation;

/**
 * Http instance for ngx.
 * Ubiquity\utils\http\foundation$NgxHttp
 * This class is part of Ubiquity
 *
 * @author jcheron <myaddressmail@gmail.com>
 * @version 1.0.1
 */
class NgxHttp extends AbstractHttp {

	public function getAllHeaders() {
		return \ngx_request_headers();
	}

	public function header($key, $value, bool $replace = true, int $http_response_code = 0) {
		\ngx_header_set($key, $value);
		if ($http_response_code != null) {
			$this->setResponseCode($http_response_code);
		}
	}

	/**
	 *
	 * @return int
	 */
	public function getResponseCode() {
		return \ngx_status();
	}

	/**
	 *
	 * @param int $responseCode
	 */
	public function setResponseCode($responseCode) {
		if ($responseCode != null) {
			\ngx_status($responseCode);
			return $responseCode;
		}
		return false;
	}

	public function headersSent(string &$file = null, int &$line = null) {
		return \headers_sent($file, $line);
	}

	public function getInput() {
		return \ngx_query_args() + \ngx_post_args();
	}

	public function setRequest() {
		$_SERVER = [];
		$_SERVER['REQUEST_URI'] = \ngx_request_uri();
		$_SERVER['QUERY_STRING'] = \ngx_request_query_string();
		$_SERVER['REQUEST_METHOD'] = \ngx_request_method();
		$_SERVER['REMOTE_ADDR'] = \ngx_request_remote_addr();

		$headers = \ngx_request_headers();
		foreach ($headers as $k => $v) {
			$_SERVER['HTTP_' . \strtoupper($k)] = $v;
		}

		$_GET = \ngx_query_args() ?? [];
		$_POST = \ngx_post_args() ?? [];
		foreach ($_GET as $k => $v) {
			$_GET[\urldecode($k)] = \urldecode($v);
			if ($k != \urldecode($k)) {
				unset($_GET[$k]);
			}
		}
		$_REQUEST = $_GET + $_POST;
		$_COOKIE = \ngx_cookie_get_all();
	}
}

