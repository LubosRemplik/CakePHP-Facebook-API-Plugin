<?php
App::uses('AppModel', 'Model');
App::uses('CakeSession', 'Model/Datasource');
App::uses('Hash', 'Utility');
App::uses('HttpSocket', 'Network/Http');
App::uses('Set', 'Utility');
class FacebookApi extends AppModel {

	public $useTable = false;
	
	protected $_config = array();

	protected $_strategy = 'Facebook';

	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		if (!CakeSession::check($this->_strategy)) {
			$config = ClassRegistry::init('Opauth.OpauthSetting')
				->findByName($this->_strategy);
			if (!empty($config['OpauthSetting'])) {
				CakeSession::write($this->_strategy, $config['OpauthSetting']);
			}
		}
		$this->_config = CakeSession::read($this->_strategy);
	}

	protected function _generateCacheKey() {
		$backtrace = debug_backtrace();
		$cacheKey = array();
		$cacheKey[] = $this->alias;
		if (!empty($backtrace[2]['function'])) {
			$cacheKey[] = $backtrace[2]['function'];
		}
		if ($backtrace[2]['args']) {
			$cacheKey[] = md5(serialize($backtrace[2]['args']));	
		}
		return implode('_', $cacheKey);
	}

	protected function _parseResponse($response) {
		$results = json_decode($response->body);
		if (is_object($results)) {
			$results = Set::reverse($results);
		}
		return $results;
	}

	protected function _request($path, $request = array()) {
		// preparing request
		$defaultRequest = array(
			'method' => 'GET',
			'uri' => array(
				'scheme' => 'https',
				'host' => 'graph.facebook.com',
				'path' => '',
			)
		);
		$request = Hash::merge($defaultRequest, $this->_request);
		$request['uri']['path'] .= $path;
		if (!empty($this->_config['token'])) {
			$request['uri']['query']['access_token'] = $this->_config['token'];
		}
		// Read cached GET results
		if ($request['method'] == 'GET') {
			$cacheKey = $this->_generateCacheKey();
			$results = Cache::read($cacheKey);
			if ($results !== false) {
				return $results;
			}
		}

		// createding http socket object for later use
		$HttpSocket = new HttpSocket();

		// issuing request
		$response = $HttpSocket->request($request);

		// olny valid response is going to be parsed
		if (substr($response->code, 0, 1) != 2) {
			if (Configure::read('debugApis')) {
				debug($request);
				debug($response->body);
			}
			return false;
		}

		// parsing response
		$results = $this->_parseResponse($response);

		// cache and return results
		if ($request['method'] == 'GET') {
			Cache::write($cacheKey, $results);
		}
		return $results;
	}
}
