<?php
App::uses('FacebookApi', 'Facebook.Model');
class FacebookUser extends FacebookApi {

	protected $_request = array(
		'method' => 'GET',
	);

	/**
	 * http://developers.facebook.com/docs/reference/api/user/#feed
	 **/
	public function feed($username = 'me', $options = array()) {
		$request = array();
		if ($options) {
			$request['uri']['query'] = $options;
		}
		$trace = debug_backtrace();
		return $this->_request(sprintf('/%s/%s', $username, $trace[0]['function']), $request);
	}

	/**
	 * http://developers.facebook.com/docs/reference/api/user/#home
	 **/
	public function home($username = 'me', $options = array()) {
		$request = array();
		if ($options) {
			$request['uri']['query'] = $options;
		}
		$trace = debug_backtrace();
		return $this->_request(sprintf('/%s/%s', $username, $trace[0]['function']), $request);
	}

	/**
	 * http://developers.facebook.com/docs/reference/api/user/#statuses
	 **/
	public function statuses($username = 'me', $options = array()) {
		$request = array();
		if ($options) {
			$request['uri']['query'] = $options;
		}
		$trace = debug_backtrace();
		return $this->_request(sprintf('/%s/%s', $username, $trace[0]['function']), $request);
	}
}
