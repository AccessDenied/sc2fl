<?php
class Team_league extends CI_Model {
	
	private $id;
	private $name;
	private $description;
	private $date_start;
	private $date_end;
	
	public function __construct($id=null, $name=null, $description=null, $date_start=null, $date_end=null) {
		parent::__construct();
		$this->id=$id;
		$this->name=$name;
		$this->description=$description;
		$this->date_start=$date_start;
		$this->date_end=$date_end;
	}
	public function get_matches() {
		$this->db->where('league_id', $this->id);
		$query = $this->db->get('team_league_match');
		$matches = array();
		foreach ($query->result() as $match):
			array_push($matches, new Match($match->match_id, $match->team_one, $match->team_two, $match->date_start, $match->league_id, $match->lineup_position, $match->winner));
		endforeach;
		return $matches;
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
	public function get_date_start() {
		return $this->date_start;
	}
	public function get_date_end() {
		return $this->date_end;
	}
	public function get_league($id) {
		$this->db->where('league_id', $id);
		$query = $this->db->get('team_league');
		$league = $query->row();
		return new Team_league($league->league_id, $league->name, $league->description, $league->date_start, $league->date_end);
	}
	public function get_leagues() {
		$teamLeagues = $this->db->get('team_league');
		$data = array();
		foreach ($teamLeagues->result() as $league):
			array_push($data, new Team_league($league->league_id, $league->name, $league->description, $league->date_start, $league->date_end));
		endforeach;
		return $data;
	}
	public function get_fantasies() {
		$this->db->where('league_id', $this->id);
		$query = $this->db->get('team_fantasy');
		$fantasies = array();
		foreach ($query->result() as $fantasy):
			array_push($fantasies, new Team_fantasy($fantasy->fantasy_id, $fantasy->date_created, $fantasy->owner_id, $fantasy->name, $fantasy->description, $fantasy->user_limit, $fantasy->league_id));
		endforeach;
		return $fantasies;
	}
}
?>