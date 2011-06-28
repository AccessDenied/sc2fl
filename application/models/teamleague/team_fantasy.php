<?php
class Team_fantasy extends CI_Model {
	
	private $id;
	private $name;
	private $description;
	private $date_created;
	private $owner_id;
	private $user_limit;
	private $league_id;
	private $participant_ids;
	
	public function __construct($id=null, $name=null, $description=null, $date_created=null, $owner_id=null, $user_limit=null, $league_id=null) {
		parent::__construct();
		$this->id=$id;
		$this->name=$name;
		$this->description=$description;
		$this->date_created=$date_created;
		$this->owner_id=$owner_id;
		$this->user_limit=$user_limit;
		$this->league_id=$league_id;
	}
	public function get_id() {
		return $this->id;
	}
	public function get_name() {
		return $this->name;
	}
	public function get_description() {
		return $this->description;
	}
	public function get_date_created() {
		return $this->date_created;
	}
	public function get_owner_id() {
		return $this->owner_id;
	}
	public function get_user_limit() {
		return $this->user_limit;
	}
	public function get_league_id() {
		return $this->league_id;
	}
	public function get_participant_ids() {
		if (!isset($this->participants)) {
			$this->db->where('fantasy_id', $this->id);
			$query = $this->db->get('team_fantasy_participant');
			$participant_ids = array();
			foreach ($query->result() as $row) {
				array_push($participant_ids, $row->user_id);
			}
			$this->participant_ids = $participant_ids;
		}
		return $this->participant_ids;
	}
}
?>