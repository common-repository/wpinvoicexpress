<?php

class InvoicexpressAPIClient {

	protected $settings = [];

	public function __construct($domain, $api_key) {

		$this->settings['domain'] = $domain;
		$this->settings['api_key'] = $api_key;

	}

	protected function getSetting($name) {

		return (isset($this->settings[ $name ])) ? $this->settings[ $name ] : null;

	}

	protected function buildURL($object, $params = []) {

		$params = array_merge([ 'api_key' => $this->getSetting('api_key') ], $params);

		return sprintf('https://%s.app.invoicexpress.com/%s.xml?%s', $this->getSetting('domain'), $object, http_build_query($params));

	}

	public function fetch($object, $params = []) {

		$url = $this->buildURL($object, $params);

		$qp = qp( $url );

		return $qp;

	}

}