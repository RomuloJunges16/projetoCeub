<?php

require_once ("model/request.php");
require_once ("validation/requestValidator.php");
require_once ("controller/campeonatoController.php");


class RequestTreater{

	private $controller = Array("camp" => "CampeonatoController");

	public function start(){
		try{
		$request = new Request(	$_SERVER['REQUEST_METHOD'],
						   		$_SERVER['SERVER_PROTOCOL'], 
						   		$_SERVER['HTTP_HOST'], 
						   		$_SERVER['REQUEST_URI'], 
						   		$_SERVER['QUERY_STRING'],
						   		file_get_contents('php://input'));

		$controller = new $this->controller[$request->getResource()]($request);
		return $controller->routeOperation();
		
		}catch(RequestException $e){
		return $e->toJson();
		}

	}

}