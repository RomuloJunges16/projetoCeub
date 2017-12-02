<?php

class DBHandler {

	const DB_NAME = "dbCamp";

	public function getConnection() {
		try {

		    $mng = new MongoDB\Driver\Manager("mongodb://127.0.0.1:27017");
		    																		
		    return $mng;

		} catch (MongoDB\Driver\Exception\Exception $e) {
		    
		    return json_encode(
		    			 	Array(
		    			 		"msg"  => $e->getMessage(), 
		    			 		"file" => $e->getFile(), 
		    			 		"line" => $e->getLine()
		    			 	));       
		}
	}

	public function insert($document, $collection) {
		$conn = $this->getConnection();
		$bulk = new MongoDB\Driver\BulkWrite;
		$bulk->insert($document);
		echo "agora ta aqui";
		$result = $conn->executeBulkWrite("dbCamp.".$collection, $bulk);
		return $result;
	}


	public function search($parameters, $collection) {
		//var_dump($parameters);
		$conn = $this->getConnection();
		$query = new MongoDB\Driver\Query($parameters, []);
		//var_dump($query);
		$rows = $conn->executeQuery("dbCamp.".$collection, $query);
		$result = Array();
		foreach ($rows as $row) {
    		
        	array_push($result, $row);
    	}
    	json_encode($result, JSON_PRETTY_PRINT);
		return $result;
	}

	public function showRodada($parameters, $collection){
		//var_dump($parameters);
		$conn = $this->getConnection();
		$query = new MongoDB\Driver\Query($parameters, []);
		//var_dump($query);
		$rows = $conn->executeQuery("dbCamp.".$collection, $query);
		$result = Array();
		foreach ($rows as $row) {
    		
        	array_push($result, $row);
    	}

    	$times = $result["0"]->teams;

    	while(!empty($times)) {
			$rand_teams = array_rand($times, 2);

				if($times[$rand_teams[0]] != $times[$rand_teams[1]]){
					echo $times[$rand_teams[0]] . " x " . $times[$rand_teams[1]] . "<br>";
				}

			unset($times[$rand_teams[0]]);
			unset($times[$rand_teams[1]]);
    	
		}
		/*for($i = 0; $i < count($result["0"]->teams); $i++){
			$rand_teams = array_rand($times, 2);
				if($times[$rand_teams[0]] != $times[$rand_teams[1]]){
					echo $times[$rand_teams[0]] . " x " . $times[$rand_teams[1]] . "<br>";
				}

			unset($times[$rand_teams[0]]);
			unset($times[$rand_teams[1]]);

		}	*/
	}

		//return $campArray;

	public function update($oldObj, $newObj, $collection) // pode ser passado um OBJ ou um ARRAY(estou usando array)
	{
		//echo "Entrou no update";
		$conn = $this->getConnection();
		$bulk = new MongoDB\Driver\BulkWrite;    
		$bulk->update($oldObj, $newObj);
		$result = $conn->executeBulkWrite("dbCamp.".$collection, $bulk);
		//echo "saiu do update";
		return  $result;
	}

	public function delete($deleteObj, $collection) // pode ser passado um OBJ ou um ARRAY(estou usando array)
	{
		//echo "Entrou no delete";
		$conn = $this->getConnection();
		$bulk = new MongoDB\Driver\BulkWrite;    
		$bulk->delete($deleteObj);
		$result = $conn->executeBulkWrite("dbCamp.".$collection, $bulk);
		//echo "saiu do delete";
		return  $result;
	}



}

