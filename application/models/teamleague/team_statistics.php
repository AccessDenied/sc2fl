<?php
class Team_statistics extends CI_Model {
	
	private $league;
	private $teams;
	private $players;
	private $team_statistics;
	private $player_statistics;
	
	public function __construct($league=null, $teams=null, $players=null) {
		parent::__construct();
		$this->league = $league;
		$this->teams = (is_null($teams)?array():$teams);
		$this->players = (is_null($players)?array():$players);
		$this->team_statistics = array();
		$this->player_statistics = array();
		
		$this->build_statistics($teams);
		
	}
	public function get_teams() {
		return $this->teams;
	}
	public function get_players() {
		return $this->players;
	}
	public function get_league() {
		return $this->league;
	}
	public function get_team_statistics() {
		return $this->team_statistics;
	}
	public function get_player_statistics() {
		return $this->player_statistics;
	}
	private function build_statistics($teams) {
		foreach($this->teams as $team) {
			$this->team_statistics[$team->get_id()] = new Team_team_statistics($this->get_league(), $team);
		}
		foreach($this->players as $player) {
			$this->player_statistics[$player->get_id()] = new Team_player_statistics($this->get_league(), $player);
		}
	}
}
?>