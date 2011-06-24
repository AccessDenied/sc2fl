<?php
class Round extends CI_Model {
	
	private $id;
	private $match_id;
	private $player_one;
	private $player_two;
	private $winner;
	
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
	public function get_players() {
		$players = array();
		$query = $this->db->query("SELECT * FROM player WHERE player_id = ? OR player_id = ?", array($this->player_one, $this->player_two));
		foreach ($query->result() as $player) {
			array_push($players, new Player($player->player_id, $player->name, $player->description, $player->team_id));
		}
		return $players;
	}
	public function get_winner() {
		$this->db->where('player_id', $this->winner);
		$query = $this->db->get('player');
		$player = $query->row();
		return new Player($player->player_id, $player->name, $player->description, $player->team_id);
	}
}
?>