<?php
class Team_statistics extends CI_Model {
	
	private $league;
	private $team;
	private $wins;
	private $losses;
	
	public function __construct($league=null, $team=null) {
		parent::__construct();
		$this->league = $league;
		$this->team = $team;
		
		$this->build_statistics();
	}
	public function get_losses() {
		return $this->losses;
	}
	public function get_wins() {
		return $this->wins;
	}
	public function get_total_points() {
		return $wins;
	}
	private function build_statistics() {
		if ((!isset($this->wins) || !isset($this->losses)) && !is_null($this->team)) {
			$this->wins = 0;
			$this->losses = 0;
			$this->db->select('winner');
			$this->db->where('team_one',$this->team->get_id());
			$this->db->or_where('team_two',$this->team->get_id());
			$query = $this->db->get('team_league_match');
			foreach ($query->result() as $row){
				if (!is_null($row->winner)) {
					if ($row->winner == $this->team->get_id()) {
						$this->wins++;
					} else {
						$this->losses++;
					}
				}
			}
		}
		
	}
}
?>