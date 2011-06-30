<?php
class Team_round extends CI_Model {
	
	private $id;
	private $match_id;
	private $player_one;
	private $player_two;
	private $winner;
	private $competitors;
	
	public function __construct($id=null, $match_id=null, $player_one=null, $player_two=null, $winner=null) {
		parent::__construct();
		$this->id=$id;
		$this->match_id=$match_id;
		$this->player_one=$player_one;
		$this->player_two=$player_two;
		$this->winner=$winner;
	}
	public function get_id() {
		return $this->id;
	}
	public function get_competitors() {
		if (!isset($this->competitors)) {
			$competitors = array();
			$query = $this->db->query("SELECT * FROM player WHERE player_id = ? OR player_id = ?", array($this->player_one, $this->player_two));
			foreach ($query->result() as $player) {
				array_push($competitors, new Player($player->player_id, $player->name, $player->description, $player->team_id));
			}
			$this->competitors = $competitors;
		}
		return $this->competitors;
	}
	public function get_winner() {
		return $this->winner;
	}
}
?>