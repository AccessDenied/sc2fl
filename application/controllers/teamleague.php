<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class TeamLeague extends CI_Controller
{
	function __construct() {
		parent::__construct();
	}

	function index() {
		$data['teamLeagues'] = $this->db->get('team_league');
		if ($this->tank_auth->is_logged_in()) {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
		}
		$this->template->load('template', 'teamleagues', $data);
	}
	
	function league() {
		$data = array();
		if ($this->tank_auth->is_logged_in()) {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
		}
		$this->db->where('league_id', $this->uri->segment(3));
		$data['matches'] = $this->db->get('team_league_match');
		$this->template->load('template', 'teamleague', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */