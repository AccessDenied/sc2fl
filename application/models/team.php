<?php
class Team extends CI_Model {
	
	private $id;
	private $name;
	private $description;
	private $roster;
	
	public function __construct($id=null, $name=null, $description=null) {
		parent::__construct();
		$this->id=$id;
		$this->name=$name;
		$this->description=$description;
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
	public function get_roster() {
		if (!isset($this->roster)) {
			$this->db->where('team_id', $this->id);
			$query = $this->db->get('player');
			$players = array();
			foreach ($query->result() as $player){
				array_push($players, new Player($player->player_id, $player->name, $player->description, $player->team_id));
			}
			$this->roster = $players;
		}
		
		return $this->roster;
	}
	public function get_team($team_id) {
		$this->db->where('team_id', $team_id);
		$query = $this->db->get('team');
		$team = $query->row();
		return new Team($team->team_id, $team->name, $team->description);
	}
}
?>