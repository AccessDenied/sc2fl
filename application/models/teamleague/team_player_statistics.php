<?php
class Team_player_statistics extends CI_Model {
	
	private $league;
	private $player;
	private $appearances;
	private $two_streaks;
	private $three_streaks;
	private $four_streaks;
	
	public function __construct($league=null, $player=null) {
		parent::__construct();
		$this->league = $league;
		$this->player = $player;
		
		$this->build_statistics();
	}
	public function get_losses() {
		return $this->losses;
	}
	public function get_wins() {
		return $this->wins;
	}
	public function get_appearances() {
		return $this->appearances;
	}
	public function get_two_streaks() {
		return $this->two_streaks;
	}
	public function get_three_streaks() {
		return $this->three_streaks;
	}
	public function get_four_streaks() {
		return $this->four_streaks;
	}
	public function get_total_points() {
		return $this->wins+($this->two_streaks*2)+($this->three_streaks*3)+($this->four_streaks*4)+$this->appearances;
	}
	private function build_statistics() {
		if ((!isset($this->wins) || !isset($this->losses)) && !is_null($this->player)) {
			$match_ids = array();
			foreach($this->league->get_matches() as $match) {
				array_push($match_ids, $match->get_id());
			}
			$this->wins = 0;
			$this->losses = 0;
			$this->appearance = 0;
			$this->two_streaks = 0;
			$this->three_streaks = 0;
			$this->four_streaks = 0;
			$this->db->select('match_id, winner');
			$whereSql = '(player_one='.$this->player->get_id().' OR player_two='.$this->player->get_id().') AND (';
			$count = 0;
			foreach($match_ids as $id) {
				if ($count == 0) {
					$whereSql.='match_id='.$id;
				}else {
					$whereSql.=' OR match_id='.$id;
				}
				$count++;
			}
			$whereSql.=')';
			$this->db->where($whereSql);
			$query = $this->db->get('team_league_round');
			$wins_per_match = array();
			foreach ($query->result() as $row){
				if (!is_null($row->winner)) {
					if (!isset($wins_per_match[$row->match_id])) {$wins_per_match[$row->match_id] = 0;$this->appearances++;}
					if ($row->winner == $this->player->get_id()) {
						$this->wins++;
						$wins_per_match[$row->match_id]++;
					} else {
						$this->losses++;
					}
				}
			}
			foreach($wins_per_match as $streak) {
				if ($streak == 2) {
					$this->two_streaks++;
				} else if ($streak == 3) {
					$this->three_streaks++;
				} else if ($streak == 4) {
					$this->four_streaks++;
				}
			}
		}
	}
}
?>