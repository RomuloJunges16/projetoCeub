<?php


class RequestValidator  
{
	private $allowedMethods = Array('GET', 'PUT', 'POST', 'DELETE');

	private $allowedUris = Array('camp'   => Array('registerCamp', 'infoCamp', 'updateCamp', 'getRodada'));

	public function isUriValid($uri) {
		$arrayUri = explode('/', $uri);
		//print_r($arrayUri);

		//verificar se arrayUri[2] é chave
		if(!in_array($arrayUri[2], $this->allowedUris[$arrayUri[1]]))
			return false;
		
		return true;		
	}

	public function isMethodValid($method) {

		if(!in_array($method, $this->allowedMethods)) 
			return false;

		return true;		
	}

	public function isProtocolValid($protocol) {
		
	}

	

	public function isQueryStringValid($qs) {
		
	}

	public function isBodyValid($body) {
		
	}
}