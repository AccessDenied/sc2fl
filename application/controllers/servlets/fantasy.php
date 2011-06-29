<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Fantasy extends CI_Controller
{
	function __construct() {
		parent::__construct();
	}

	function index() {
		
	}
	function playerdraft() {
		$data = array();
		if ($this->tank_auth->is_logged_in()) {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
		}		
		
		$this->load->model('teamleague/Team_fantasy');
		$this->load->model('Player');
		
		$fantasy = Team_fantasy::get_fantasy_by_id($this->uri->segment(4));
		$this->db->select('*');
		
		$this->db->from('team_fantasy_draft');
		$this->db->join('player', 'player.player_id = team_fantasy_draft.player_id');
		$query = $this->db->get();
		$players = array();
		foreach ($query->result() as $row) {
			$players[$row->player_id] = $row->name;
		}
		echo json_encode($players);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */