<?php
namespace Ubiquity\utils\http\foundation;

/**
 * Http instance for Swoole.
 * Ubiquity\utils\http\foundation$NgxHttp
 * This class is part of Ubiquity
 *
 * @author jcheron <myaddressmail@gmail.com>
 * @version 1.0.0
 */
class NgxHttp extends AbstractHttp {

	private $headers = [];

	private $responseCode = 200;

	private $datas;

	public function getAllHeaders() {
		return \ngx_request_headers();
	}

	public function setDatas($datas) {
		return $this->datas;
	}

	public function header($key, $value, bool $replace = true, int $http_response_code = null) {
		\ngx_header_set($key, $value);
		if ($http_response_code != null) {
			$this->responseCode = $http_response_code;
		}
	}

	/**
	 *
	 * @return int
	 */
	public function getResponseCode() {
		return $this->responseCode;
	}

	/**
	 *
	 * @param int $responseCode
	 */
	public function setResponseCode($responseCode) {
		if ($responseCode != null) {
			$this->responseCode = $responseCode;
			if (\PHP_SAPI != 'cli') {
				return \http_response_code($responseCode);
			}
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
}

