<?php

require_once("validation/campValidator.php");
require_once("exception/requestException.php");

class Campeonato{

	private $name;
	private $teams;

	private $cv;

	public function __construct($name, $teams){
		$this->cv = new CampValidator();

		$this->setName($name);
		$this->setTeams($teams);
	}

	public function setName($name){
		if(!$this->cv->isNameValid($name)){
			throw new RequestException(400, "Nome invalido");
		}
		$this->name = $name;
	}

	public function setTeams($teams){
		$this->teams = $teams;
	}
}