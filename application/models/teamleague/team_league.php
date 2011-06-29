<?php
class Team_league extends CI_Model {
	
	private $id;
	private $name;
	private $description;
	private $date_start;
	private $date_end;
	private $matches;
	private $teams;
	private $fantasies;
	private $leagues;
	private $league;
	private $players;
	
	public function __construct($id=null, $name=null, $description=null, $date_start=null, $date_end=null) {
		parent::__construct();
		$this->id=$id;
		$this->name=$name;
		$this->description=$description;
		$this->date_start=$date_start;
		$this->date_end=$date_end;
	}
	public function get_matches() {
		if (!isset($this->matches)) {
			$this->db->where('league_id', $this->id);
			$query = $this->db->get('team_league_match');
			$matches = array();
			foreach ($query->result() as $match) {
				array_push($matches, new Match($match->match_id, $match->team_one, $match->team_two, $match->date_start, $match->league_id, $match->lineup_position, $match->winner));
			}
			$this->matches = $matches;
		}
		return $this->matches;
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
	public function get_league() {
		if (!isset($this->league)) {
			$this->db->where('league_id', $this->get_id());
			$query = $this->db->get('team_league');
			$league = $query->row();
			$this->league = new Team_league($league->league_id, $league->name, $league->description, $league->date_start, $league->date_end);
		}
		return $this->league;
	}
	public function get_league_by_id($id) {
		$this->db->where('league_id', $id);
		$query = $this->db->get('team_league');
		$league = $query->row();
		return new Team_league($league->league_id, $league->name, $league->description, $league->date_start, $league->date_end);
	}
	public function get_leagues() {
		if (!isset($this->leagues)) {
			$query = $this->db->get('team_league');
			$leagues = array();
			foreach ($query->result() as $league){
				array_push($leagues, new Team_league($league->league_id, $league->name, $league->description, $league->date_start, $league->date_end));
			}
			$this->leagues = $leagues;
		}
		return $this->leagues;
	}
	public function get_fantasies() {
		if (!isset($this->fantasies)) {
			$this->db->where('league_id', $this->id);
			$query = $this->db->get('team_fantasy');
			$fantasies = array();
			foreach ($query->result() as $fantasy){
				array_push($fantasies, new Team_fantasy($fantasy->fantasy_id, $fantasy->date_created, $fantasy->owner_id, $fantasy->name, $fantasy->description, $fantasy->user_limit, $fantasy->league_id));
			}
			$this->fantasies = $fantasies;
		}
		return $this->fantasies;
	}
	public function get_teams() {
		if (!isset($this->teams)) {
			$this->db->select('team_one, team_two');
			$this->db->where('league_id',$this->get_id());
			$query = $this->db->get('team_league_match');
			$teamIds = array();
			foreach ($query->result() as $row){
				if (!in_array($row->team_one, $teamIds)) {
					array_push($teamIds, $row->team_one);
				}
				if (!in_array($row->team_two, $teamIds)) {
					array_push($teamIds, $row->team_two);
				}
			}
			$teams = array();
			foreach ($teamIds as $teamId) {
				array_push($teams, Team::get_team($teamId));
			}
			$this->teams = $teams;
		}
		return $this->teams;
	}
	public function get_players() {
		if (!isset($this->players)) {
			$match_ids = array();
			foreach($this->get_league()->get_matches() as $match) {
				array_push($match_ids, $match->get_id());
			}
		
			$this->db->select('player_one, player_two');
			$count = 0;
			foreach($match_ids as $id) {
				if ($count == 0) {
					$this->db->where('match_id',$id);
				}else {
					$this->db->or_where('match_id',$id);
				}
				$count++;
			}
			$query = $this->db->get('team_league_round');
			$player_ids = array();
			foreach ($query->result() as $row){
				if (!in_array($row->player_one, $player_ids)) {
					array_push($player_ids, $row->player_one);
				}
				if (!in_array($row->player_two, $player_ids)) {
					array_push($player_ids, $row->player_two);
				}
			}
			$players = array();
			foreach ($player_ids as $player_id) {
				array_push($players, Player::get_player($player_id));
			}
			$this->players = $players;
		}
		return $this->players;
	}
	public function get_fantasy_statistics() {
		$teams = $this->get_teams();
		$players = $this->get_players();
		return new Statistics($this->get_league(), $teams, $players);
	}
}
?>