<?php

require_once ("model/campeonato.php");
require_once ("database/database.php");
require_once ("exception/requestException.php");

class CampeonatoController{

	private $allowedOperations = Array('registerCamp', 'infoCamp', 'updateCamp', 'getRodada');
	private $request;

	public function __construct($request){
		$this->request = $request;
	}

	public function routeOperation(){
		$campBody = json_decode($this->request->getBody(), true);

		switch($this->request->getOperation()) {
			

			case 'registerCamp':
				if($this->request->getMethod() == "POST")
						return $this->create($campBody);
					return (new RequestException(400, "Bad request"))->toJson();

			case 'infoCamp':
				if($this->request->getMethod() == "GET")
						return $this->search($this->request->getQueryString());
					return (new RequestException(400, "Bad request"))->toJson();

			case 'updateCamp':
				if($this->request->getMethod() == "PUT")
						return $this->update($campBody);
					return (new RequestException(400, "Bad request"))->toJson();

			case 'getRodada':
				if($this->request->getMethod() == "GET")
						return $this->showRodada($this->request->getQueryString());
					return (new RequestException(400, "Bad request"))->toJson();

			default:
				return (new RequestException(400, "Bad Request"))->toJson();
		}
	}


	private function create($campBody){
		
			try{
				new Campeonato($campBody["name"], $campBody["teams"]);
				return (new DBHandler())->insert($campBody, 'colCampeonatos');
			}catch(RequestException $ue){
				return $ue->toJson();
			}
	}

	private function update($campBody){ 	
		//echo "ENTROU NO PUT";
		try{ 	
		 	new Campeonato($campBody["oldCamp"]["name"], $campBody["oldCamp"]["teams"]);
		 	new Campeonato($campBody["newCamp"]["name"], $campBody["newCamp"]["teams"]);
		 	return (new DBHandler())->update($campBody["oldCamp"],$campBody["newCamp"], 'colCampeonatos'); 
		 }catch(RequestException $ue) {
		 	 return $ue->toJson();
		 }	
	}

	private function search($queryString){
		return (new DBHandler())->search($queryString, 'colCampeonatos');
	}

	private function showRodada($queryString){
		return (new DBHandler())->showRodada($queryString, 'colCampeonatos');
	}

}