<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Fantasy_league extends CI_Controller
{
	function __construct() {
		parent::__construct();
	}

	function index() {
		
	}
	function manage() {
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('desc', 'Description', 'trim|required|xss_clean');
		$this->form_validation->set_rules('userLimit', 'User Limit', 'trim|required|xss_clean|integer');
		$this->form_validation->set_rules('leagueId', 'Team League ID', 'trim|required|xss_clean|integer');
		
		if ($this->tank_auth->is_logged_in() && $this->form_validation->run()) { // validation ok
			$data = array(
				'date_created'=>date('y-m-d H:i:s'),
				'owner_id'=>$this->tank_auth->get_user_id(),
				'name'=>$this->form_validation->set_value('name'),
				'description'=>$this->form_validation->set_value('desc'),
				'user_limit'=>$this->form_validation->set_value('userLimit'),
				'league_id'=>$this->form_validation->set_value('leagueId')
			);
			$this->db->insert('team_fantasy', $data);
		}
	}
	function players() {
		$data = array();
		if ($this->tank_auth->is_logged_in()) {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
		}		
		
		$this->load->model('teamleague/Team_fantasy');
		$this->load->model('Player');
		
		$fantasy = Team_fantasy::get_fantasy_by_id($this->uri->segment(4));
		$this->db->select('*');
		
		$this->db->from('team_fantasy_player_draft');
		$this->db->join('player', 'player.player_id = team_fantasy_player_draft.player_id');
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