<?php
App::uses('FacebookApi', 'Facebook.Model');
App::uses('Hash', 'Utility');
class FacebookPage extends FacebookApi {

	protected $_request = array(
		'method' => 'GET',
	);

	/**
	 * http://developers.facebook.com/docs/reference/api/page/#lifeevents
	 **/
	public function milestones($pageId, $options = array()) {
		$request = array();
		$limit = 15;
		if ($options) {
			$request['uri']['query'] = $options;
		}
		if (isset($options['limit'])) {
			$limit = $options['limit'];
		}
		$trace = debug_backtrace();
		$data = $this->_request(sprintf('/%s/%s', $pageId, $trace[0]['function']), $request);
		$results = array();
		$count = 0;
		foreach ($data['data'] as $k => $val) {
			$results['data'][$k] = $val;
			$photos = $this->milestonePhotos($val['id']);
			$results['data'][$k]['photos'] = Hash::extract($photos['data'], '{n}.source');
			$count++;
			if ($count == $limit) {
				break;
			}
		}
		return $results;
	}

	/**
	 * http://developers.facebook.com/docs/reference/api/page/#statuses
	 **/
	public function statuses($pageId, $options = array()) {
		$request = array();
		$limit = 15;
		if ($options) {
			$request['uri']['query'] = $options;
		}
		if (isset($options['limit'])) {
			$limit = $options['limit'];
		}
		$trace = debug_backtrace();
		$data = $this->_request(sprintf('/%s/%s', $pageId, $trace[0]['function']), $request);
		$results = array();
		$count = 0;
		foreach ($data['data'] as $k => $val) {
			$results['data'][$k] = $val;
			$count++;
			if ($count == $limit) {
				break;
			}
		}
		return $results;
	}

	/**
	 * getting photos for milestone
	 **/
	public function milestonePhotos($milestoneId) {
		return $this->_request(sprintf('/%s/photos', $milestoneId));
	}
}
