<?php
class Player extends CI_Model {
	
	private $id;
	private $name;
	private $description;
	private $team_id;
	
	public function __construct($id=null, $name=null, $description=null, $team_id=null) {
		parent::__construct();
		$this->id=$id;
		$this->name=$name;
		$this->description=$description;
		$this->team_id=$team_id;
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
	public function get_team() {
		$this->db->where('team_id', $this->team_id);
		$query = $this->db->get('team');
		$team = $query->row();
		return new Team($team->team_id, $team->name, $team->description);
	}
}
?>