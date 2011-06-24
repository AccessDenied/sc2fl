<?php
class Match extends CI_Model {
	
	private $id;
	private $team_one;
	private $team_two;
	private $date_start;
	private $league_id;
	private $lineup_position;
	private $winner;
	
	public function __construct($id=null, $team_one=null, $team_two=null, $date_start=null, $league_id=null, $lineup_position=null, $winner=null) {
		parent::__construct();
		$this->id=$id;
		$this->team_one=$team_one;
		$this->team_two=$team_two;
		$this->date_start=$date_start;
		$this->league_id=$league_id;
		$this->lineup_position=$lineup_position;
		$this->winner=$winner;
	}
	public function get_id() {
		return $this->id;
	}
	public function get_teams() {
		$teams = array();
		$query = $this->db->query("SELECT * FROM team WHERE team_id = ? OR team_id = ?", array($this->team_one, $this->team_two));
		foreach ($query->result() as $team) {
			array_push($teams, new Team($team->team_id, $team->name, $team->description));
		}
		return $teams;
	}
	public function get_date_start() {
		return $this->date_start;
	}
	public function get_league() {
		$this->db->where('league_id', $this->league_id);
		$league = $this->db->get('team_league');
		return new Team_league($league->league_id, $league->name, $league->description, $league->date_start, $league->date_end);
	}
	public function get_lineup_position() {
		return $this->lineup_position;
	}
	public function get_winner() {
		return $this->winner;
	}
	public function get_rounds() {
		$this->db->where('match_id', $this->id);
		$query = $this->db->get('team_league_round');
		$rounds = array();
		foreach ($query->result() as $round):
			array_push($rounds, new Round($round->round_id, $round->match_id, $round->player_one, $round->player_two, $round->winner));
		endforeach;
		return $rounds;
	}
	public function get_match($id) {
		$this->db->where('match_id', $id);
		$query = $this->db->get('team_league_match');
		$match = $query->row();
		return new Match($match->match_id, $match->team_one, $match->team_two, $match->date_start, $match->league_id, $match->lineup_position, $match->winner);
	}
}
?>