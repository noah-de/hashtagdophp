<?php

class Person {
	private $firstname = "";
	private $lastname = "";
	private $role = "";
	private $email = "";
	private $times_searched = 0;

	function __construct() {

	}

	public function setFirstname ($firstname) {
		$this->firstname = $firstname;
	}
	public function getFirstname () {
		return $this->firstname;
	}
	public function setLastname ($lastname) {
		$this->lastname = $lastname;
	}
	public function getLastname () {
		return $this->lastname;
	}
	public function setRole ($role) {
		$this->role = $role;
	}
	public function getRole () {
		return $this->role;
	}
	public function setEmail ($email) {
		$this->email = $email;
	}
	public function getEmail () {
		return $this->email;
	}
	public function setSearchedNum ($searched_num) {
		$this->searched_num = $searched_num;
	}
	public function getSearchedNum () {
		return $this->searched_num;
	}
}

class Student extends Person {
	private $student_id = "";
	private $year = 0;
	private $dorm = "";
	private $room_num = "";
	private $ms_num = 0;
	private $phone_num = "";
	private $primary_contact = "";
	private $roommates = array();


	function __construct($student_id) {
		$this->student_id = $student_id;
	}

	public function getStudentID () {
		return $this->student_id;
	}

	public function setYear ($year) {
		$this->year = $year;
	}
	public function getYear () {
		return $this->year;
	}
	public function setDorm ($dorm) {
		$this->dorm = $dorm;
	}
	public function getDorm () {
		return $this->dorm;
	}
	public function setRoomNum ($room_num) {
		$this->room_num = $room_num;
	}
	public function getRoomNum () {
		return $this->room_num;
	}
	public function setMSNum ($ms_num) {
		$this->ms_num = $ms_num;
	}
	public function getMSNum () {
		return $this->ms_num;
	}
	public function setPhoneNum ($phone_num) {
		$this->phone_num = $phone_num;
	}
	public function getPhoneNum () {
		return $this->phone_num;
	}
	public function setPrimaryContact ($primary_contact) {
		$this->primary_contact = $primary_contact;
	}
	public function getPrimaryContact () {
		return $this->primary_contact;
	}
	// must be passed in as an array
	public function setRoommates ($roommates) {
		$this->roommates = $roommates;
	}
	public function getRoommates () {
		return $this->roommates;
	}
}

class Faculty extends Person {
	
}

class Staff extends Person {
	
}

?>
