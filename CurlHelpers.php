<?php
/**
 * @描述 Curl类库，对curl进行封装，便于调用
 * @参考 https://github.com/aizuyan/curl
 * @时间 2015年8月20日 09:44:27
 * @作者 燕睿涛(luluyrt@163.com)
 *
 * @使用
 * $config = [
 *	'headers' => [
 *		'Content-Type' => 'application/x-protobuf',
 *	],
 * 	'options' => [
 *		CURLOPT_TIMEOUT => 10,
 *	],
 * 	'userAgent' => 'PHP v5.36XXXX',
 *	'referer' => 'http://www.jd.com',
 * ];
 *
 * $curl = new CurlHelpers($config);
 * $ret = $curl->post($url, $data);
 */
namespace component\helpers;

use yii\base\object;

class CurlHelpers extends Object
{

	private $_ch = null;

	public $options = [];

	public $headers = [];

	private $_error = "";

	public $userAgent = "";

	public $referer = "";

	private $_httpcode = "200";

	public function get($url, $params = [])
	{
		return $this->request($url, 'GET', $params);
	}

	public function post()
	{
		return $this->request($url, 'POST', $params);
	}

	public function request($url, $method, $params = [])
	{
		$flag = false;
		$this->_error = "";
		$this->_ch = curl_init();
		if(is_array($params)) {
			$params = http_build_query($params, '', '&');
		}

		do {
			if(!$this->_setMethod($method)) {
				$this->_error = "the method is not support !!";
				$flag = false;
				break;
			}

			$this->_setOption($url, $params);

			$this->_setHeaders();
			$ret = curl_exec($this->_ch);

			if($ret === false) {
				$this->_error = "exec curl error, error info : [".curl_errno($this->_ch)."] => ".curl_error($this->_ch);
				$flag = false;
				break;
			}

			$this->_httpcode = curl_getinfo($this->_ch, CURLINFO_HTTP_CODE);
			$this->_error = "info : [".curl_errno($this->_ch)."] => ".curl_error($this->_ch);

			$flag = true;
		} while(0);

		curl_close($this->_ch);
		return ($flag && $this->_httpcode == "200") ? $ret : false;
	}

	public function getHttpcode()
	{
		return $this->_httpcode;
	}

	public function getError()
	{
		return $this->_error;
	}

	private function _setMethod($method)
	{
		$flag = false;
		switch (strtoupper($method)) {
			case 'GET':
				$flag = true;
				curl_setopt($this->_ch, CURLOPT_HTTPGET, true);
				break;
			case 'POST':
				$flag = true;
				curl_setopt($this->_ch, CURLOPT_POST, true);
				break;			
			default:
				break;
		}
		return $flag ? true : false;
	}

	private function _setOption($url, $params = "")
	{
		curl_setopt($this->_ch, CURLOPT_URL, $url);
		if(!empty($params)) {
			curl_setopt($this->_ch, CURLOPT_POSTFIELDS, $params);
		}
        # Set some default CURL options
        curl_setopt($this->_ch, CURLOPT_HEADER, false);
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
        if($this->userAgent) {
       		curl_setopt($this->_ch, CURLOPT_USERAGENT, $this->userAgent);
        }
        if($this->referer) {
        	curl_setopt($this->_ch, CURLOPT_REFERER, $this->referer);
        }

        curl_setopt_array($this->_ch, $this->options);
	}

	private function _setHeaders()
	{
		$headers = [];
		foreach ($this->headers as $key => $value) {
			array_push($headers, "{$key}: {$value}");
		}
		curl_setopt($this->_ch, CURLOPT_HTTPHEADER, $headers);
	}
}
