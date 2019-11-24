<?php

class Person {
	private $firstname = "";
	private $lastname = "";
	private $role = "";
	private $email = "";
	private $times_searched = 0;
	private $profile_pic_url = "";

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

	public function setProfilePicURL ($profile_pic_url) {
		$this->profile_pic_url = $profile_pic_url;
	}

	public function getProfilePicURL () {
		return $this->profile_pic_url;
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

	private $name_privacy = false;
	private $preferred_name_privacy = false;
	private $year_privacy = false;
	private $email_privacy = false;
	private $alt_email_privacy = false;
	private $phone_num_privacy = false;
	private $dorm_privacy = false;
	private $room_num_privacy = false;
	private $ms_num_privacy = false;
	private $roommates_privacy = false;
	private $searched_num_privacy = false;
	private $profile_pic_privacy = false;

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
	
	public function setNamePrivacy ($state) {
	    $this->name_privacy = $state;
	}

	public function getNamePrivacy () {
	    return $this->name_privacy;
	}
	public function setPreferredNamePrivacy ($state) {
	    $this->preferred_name_privacy = $state;
	}

	public function getPreferredNamePrivacy () {
	    return $this->preferred_name_privacy;
	}
	public function setYearPrivacy ($state) {
	    $this->year_privacy = $state;
	}

	public function getYearPrivacy () {
	    return $this->year_privacy;
	}
	public function setEmailPrivacy ($state) {
	    $this->email_privacy = $state;
	}

	public function getEmailPrivacy () {
	    return $this->email_privacy;
	}
	public function setAltEmailPrivacy ($state) {
	    $this->alt_email_privacy = $state;
	}

	public function getAltEmailPrivacy () {
	    return $this->alt_email_privacy;
	}
	public function setPhoneNumPrivacy ($state) {
	    $this->phone_num_privacy = $state;
	}

	public function getPhoneNumPrivacy () {
	    return $this->phone_num_privacy;
	}
	public function setDormPrivacy ($state) {
	    $this->dorm_privacy = $state;
	}

	public function getDormPrivacy () {
	    return $this->dorm_privacy;
	}
	public function setRoomNumPrivacy ($state) {
	    $this->room_num_privacy = $state;
	}

	public function getRoomNumPrivacy () {
	    return $this->room_num_privacy;
	}
	public function setMSNumPrivacy ($state) {
	    $this->ms_num_privacy = $state;
	}

	public function getMSNumPrivacy () {
	    return $this->ms_num_privacy;
	}
	public function setRoommatesPrivacy ($state) {
	    $this->roommates_privacy = $state;
	}

	public function getRoommatesPrivacy () {
	    return $this->roommates_privacy;
	}
	public function setSearchedNumPrivacy ($state) {
	    $this->searched_num_privacy = $state;
	}

	public function getSearchedNumPrivacy () {
	    return $this->searched_num_privacy;
	}
	public function setProfilePicPrivacy ($state) {
	    $this->profile_pic_privacy = $state;
	}

	public function getProfilePicPrivacy () {
	    return $this->profile_pic_privacy;
	}
}

class Faculty extends Person {
	
}

class Staff extends Person {
	
}

class StudentHelper extends Student {
	private $db_con = array();
	private $db = "";

	/* available vars (so you don't have to look through the other classes above)
	 * private $student_id = "";
	 * private $firstname = "";
	 * private $lastname = "";
	 * private $role = "";
	 * private $email = "";
	 * private $times_searched = 0;
	 * private $year = 0;
	 * private $dorm = "";
	 * private $room_num = "";
	 * private $ms_num = 0;
	 * private $phone_num = "";
	 * private $primary_contact = "";
	 * private $roommates = array();
	 * 
	 * private $name_privacy = false;
	 * private $preferred_name_privacy = false;
	 * private $year_privacy = false;
	 * private $email_privacy = false;
	 * private $alt_email_privacy = false;
	 * private $phone_num_privacy = false;
	 * private $dorm_privacy = false;
	 * private $room_num_privacy = false;
	 * private $ms_num_privacy = false;
	 * private $roommates_privacy = false;
	 * private $searched_num_privacy = false;
	 * private $profile_pic_privacy = false;
	 */

	private function connect_db () {
		$this->db_con['host'] = "bminer-apps";
		$this->db_con['port'] = "5433";
		$this->db_con['user'] = "dophp";
		$this->db_con['password'] = "Nalkerstet!";
		$this->db_con['dbname'] = "dophp";
		$this->db_con['string'] = "host=" . $this->db_con['host'] . " port=" . $this->db_con['port'] . " user=" . $this->db_con['user'] . " password=" . $this->db_con['password'] . " dbname=" . $this->db_con['dbname'];

		$this->db = pg_connect($this->db_con['string']);
	}

	private function close_db () {
		pg_close($this->db);
	}

	function __construct($student_id) {
		$this->student_id = $student_id;
		$this->connect_db();
	}

	// gets all information about student by student_id from db query
	public function get_all () {
		$query_string = "SELECT * FROM person WHERE student_id = '" . $this->student_id . "';";
		$prepare_query = pg_query($this->db, $query_string);
		// $results = pg_fetch_assoc($prepare_query);
		return pg_fetch_assoc($prepare_query);
		// $this->firstname = $results['firstname'];
		// echo $this->firstname;

	}

	// sets all data in object from get_all()
	public function set_all () {
		$person = $this->get_all();
		$this->setFirstname($person['firstname']);
		$this->setLastname($person['lastname']);
		$this->setRole($person['role']);
		$this->setEmail($person['email']);
		$this->setSearchedNum($person['searched_num']);
		$this->setProfilePicURL($person['profile_pic_url']);
		$this->setYear($person['year']);
		$this->setDorm($person['dorm']);
		$this->setRoomNum($person['room_num']);
		$this->setMSNum($person['ms_num']);
		$this->setPhoneNum($person['phone_num']);
		$this->setPrimaryContact($person['primary_contact']);
		$this->setRoommates();
	}

	private function psql_boolean ($value) {
		return ($value == "t");
	}

	public function get_all_privacy () {
		$query_string = "SELECT * FROM privacy WHERE student_id = '" . $this->student_id . "';";
		$prepare_query = pg_query($this->db, $query_string);
		return pg_fetch_assoc($prepare_query);
	}

	public function set_all_privacy () {
		$person = $this->get_all_privacy();
		$this->setNamePrivacy($this->psql_boolean($person['name']));
		$this->setPreferredNamePrivacy($this->psql_boolean($person['preferred_name']));
		$this->setYearPrivacy($this->psql_boolean($person['year']));
		$this->setEmailPrivacy($this->psql_boolean($person['email']));
		$this->setAltEmailPrivacy($this->psql_boolean($person['alt_email']));
		$this->setPhoneNumPrivacy($this->psql_boolean($person['phone_num']));
		$this->setDormPrivacy($this->psql_boolean($person['dorm']));
		$this->setRoomNumPrivacy($this->psql_boolean($person['room_num']));
		$this->setMSNumPrivacy($this->psql_boolean($person['ms_num']));
		$this->setRoommatesPrivacy($this->psql_boolean($person['roommates']));
		$this->setSearchedNumPrivacy($this->psql_boolean($person['searched_num']));
		$this->setProfilePicPrivacy($this->psql_boolean($person['profile_pic']));
	}

	public function getter_by_name ($name) {
		switch ($name) {
			case: "preferred_name":
				return $this->getPreferredName();
				break;

			case: "preferred_name_privacy":
				return $this->getPreferredNamePrivacy();
				break;

			case: "phone_num":
				return $this->getPhoneNum();
				break;

			case: "phone_num_privacy":
				return $this->getPhoneNumPrivacy();
				break;

			case: "alt_email":
				return $this->getAltEmail();
				break;

			case: "alt_email_privacy":
				return $this->getAltEmailPrivacy();
				break;

			case: "profile_pic":
				return $this->getProfilePicURL();
				break;

			case: "profile_pic_privacy":
				return $this->getProfilePicPrivacy();
				break;

			case: "name_privacy":
				return $this->getNamePrivacy();
				break;

			case: "year_privacy":
				return $this->getYearPrivacy();
				break;

			case: "email_privacy":
				return $this->getEmailPrivacy();
				break;

			case: "ms_num_privacy":
				return $this->getMSNumPrivacy();
				break;

			case: "searched_num_privacy":
				return $this->getSearchedNumPrivacy();
				break;

			case: "roommates_privacy":
				return $this->getRoommatesPrivacy();
				break;

			case: "dorm_privacy":
				return $this->getDormPrivacy();
				break;

			default:
				return NULL;
		}
	}

	public function setter_by_name ($name, $value) {
		switch ($name) {
			case: "preferred_name":
				$this->setPreferredName($value);;
				break;

			case: "preferred_name_privacy":
				$this->setPreferredNamePrivacy($value);;
				break;

			case: "phone_num":
				$this->setPhoneNum($value);;
				break;

			case: "phone_num_privacy":
				$this->setPhoneNumPrivacy($value);;
				break;

			case: "alt_email":
				$this->setAltEmail($value);;
				break;

			case: "alt_email_privacy":
				$this->setAltEmailPrivacy($value);;
				break;

			case: "profile_pic":
				$this->setProfilePicURL($value);;
				break;

			case: "profile_pic_privacy":
				$this->setProfilePicPrivacy($value);;
				break;

			case: "name_privacy":
				$this->setNamePrivacy($value);;
				break;

			case: "year_privacy":
				$this->setYearPrivacy($value);;
				break;

			case: "email_privacy":
				$this->setEmailPrivacy($value);;
				break;

			case: "ms_num_privacy":
				$this->setMSNumPrivacy($value);;
				break;

			case: "searched_num_privacy":
				$this->setSearchedNumPrivacy($value);;
				break;

			case: "roommates_privacy":
				$this->setRoommatesPrivacy($value);;
				break;

			case: "dorm_privacy":
				$this->setDormPrivacy($value);;
				break;

			default:
				return NULL;
		}
	}

	// sets $this->roommates to array of student_ids of roommates from roommates table where the student column is equal to this student's student_id
	public function setRoommates () {
		$query_string = "SELECT roommate FROM roommates WHERE student = '" . $this->student_id . "';";
		$prepare_query = pg_query($this->db, $query_string);
		$roommate_array_array = pg_fetch_all($prepare_query); //array of 1 or 2 student_ids
		$this->roommates = array();
		foreach($roommate_array_array as $roommate) {
			array_push($this->roommates, $roommate['roommate']);
		}
	}

	public function getRoommates () {
		return $this->roommates;
	}

	// gets necessary info of roommates (students) by student_ids for profile page
	// should this create a new Student() object?
	public function getRoommatesInfo () {
		$roommates_info = array();
		foreach ($this->roommates as $roommate) {
			$query_string = "SELECT student_id, firstname, lastname, profile_pic_url FROM person WHERE student_id = '" . rtrim($roommate) . "';";
			$prepare_query = pg_query($this->db, $query_string);
			$result = pg_fetch_assoc($prepare_query);
			array_push($roommates_info, $result);
		}
		return $roommates_info;
	}
}

?>
