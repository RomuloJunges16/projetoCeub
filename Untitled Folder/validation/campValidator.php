<?php

class CampValidator{

	public function isNameValid($name){
		if(empty($name))
			return false;
		return true;
	}
}