<?php 
// Item Model Object

// empty TaskException class so we can catch task errors
class ItemException extends Exception { }

class Item {
	// define private variables
	// define variable to store task id number
	private $_id;
	// define variable to store task title
	private $_partNumber;
	// define variable to store task title
	private $_upc;
	// define variable to store task description
	private $_description;
	// define variable to store task deadline date
	private $_mfg;
	// define variable to store task completed
	private $_list;
	// define variable to store task completed
	private $_cost;
	// define variable to store task completed
	private $_supersedesto;
	// define variable to store task completed
	private $_weight;
  
  
  // constructor to create the task object with the instance variables already set
	public function __construct($id, $partNumber, $upc, $description, $mfg, $list, $cost, $supersedesto, $weight) {
		$this->setID($id);
		$this->setPartNumber($partNumber);
		$this->setUpc($upc);
		$this->setDescription($description);
		$this->setMfg($mfg);
		$this->setList($list);
		$this->setCost($cost);
		$this->setSupersedesTo($supersedesto);
		$this->setWeight($weight);
	}
//--------------------------Get Items----------------------------------------//   
  // function to return part ID
	public function getID() {
		return $this->_id;
	}
  
  // function to return part Number
	public function getPartNumber() {
		return $this->_partNumber;
	}
  
  // function to return part upc
  public function getUpc() {
	return $this->_upc;
	}  
  // function to return task description
	public function getDescription() {
		return $this->_description;
	}  
	
  // function to return task completed
	public function getMfg() {
		return $this->_mfg;
	}
  
  // function to return task deadline
	public function getList() {
		return $this->_list;
	}
	  
  // function to return task completed
  public function getCost() {
	return $this->_cost;	
	}
  
  // function to return task completed
  public function getSupersedesTo() {
	return $this->_supersedesto;
	}
  
  // function to return task completed
  public function getWeight() {
	return $this->_weight;	
	}
//---------------------------------------------------------------------------// 
	// function to set the private task ID
	public function setID($id) {
		// if passed in task ID is not null or not numeric, is not between 0 and 9223372036854775807 (signed bigint max val - 64bit)
		// over nine quintillion rows
		if(($id !== null) && (!is_numeric($id) || $id <= 0 || $id > 9223372036854775807 || $this->_id !== null)) {
			throw new ItemException("Task ID error");
		}
		$this->_id = $id;
	}

  // function to set the private task title
	public function setPartNumber($partNumber) {
		// if passed in title is not between 1 and 16 characters
		if(strlen($partNumber) < 1 || strlen($partNumber) > 16) {
			throw new ItemException("Item Part Number error");
		}
		$this->_partNumber = $partNumber;
	}

  // function to set the private task title
  public function setUpc($upc) {
	// if passed in title is not between 1 and 16 characters
	if(strlen($upc) < 1 || strlen($upc) > 40) {
		throw new ItemException("Item UPC error");
	}
	$this->_upc = $upc;
}

  // function to set the private task description
	public function setDescription($description) {
		// if passed in description is not null and is either 0 chars or is greater than 16777215 characters (mysql mediumtext size), can be null but not empty
		if(strlen($description) > 255) {
			throw new ItemException("Task description error");
		}
		$this->_description = $description;
	}

	public function setMfg($mfg) {
		if(($mfg !== null) && (!is_numeric($mfg) || $mfg <= 0 || $mfg > 9223372036854775807 || $this->_mfg !== null)) {
			//throw new ItemException("Task ID error");
			$this->_mfg = 0;
		}
		$this->_mfg = $mfg;
	}
	
	public function setList($list) {
		if(($list !== null) && (!is_numeric($list) || $list <= 0 || $list > 9223372036854775807 || $this->_list !== null)) {
			//throw new ItemException("Task ID error");
			$this->_list = 0;
		}
		$this->_id = $list;
	}
	
	public function setCost($cost) {
		if(($cost !== null) && (!is_numeric($cost) || $cost <= 0 || $cost > 9223372036854775807 || $this->_cost !== null)) {
			//throw new ItemException("Task ID error");
			$this->_cost = 0;
		}
		$this->_cost = $cost;
	}

    public function setSupersedesTo($supersedesto) {
		// if passed in title is not between 1 and 40 characters
		if(strlen($supersedesto) < 1 || strlen($supersedesto) > 40) {
			throw new ItemException("Item Supersedes error");
		}
		$this->_supersedesto = $supersedesto;
	}

	public function setWeight($weight) {
		if(($weight !== null) && (!is_numeric($weight) || $weight <= 0 || $weight > 9223372036854775807 || $this->_weight !== null)) {
				//throw new ItemException("Task ID error");
			$this->_weight = 0;
		}
		$this->_weight = $weight;
	}		
  //---------------------------------------------------------------------------//
  // function to return task object as an array for json
	public function returnItemAsArray() {
		$item = array();
		$item['id'] = $this->getID();
		$item['partNumber'] = $this->getPartNumber();
		$item['upc'] = $this->getUpc();
		$item['description'] = $this->getDescription();
		$item['mfg'] = $this->getMfg();
		$item['list'] = $this->getList();
		$item['cost'] = $this->getCost();
		$item['supersedesto'] = $this->getSupersedesTo();
		$item['weight'] = $this->getWeight();
		return $item;
	}
}