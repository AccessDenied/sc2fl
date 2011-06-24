<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class TeamLeagues extends CI_Controller
{
	function __construct() {
		parent::__construct();
	}

	function index() {
		$data = array();
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
		
		$this->load->model('teamleague/Team_league');
		$this->load->model('teamleague/Match');
		$this->load->model('Team');
		$this->load->model('Player');
		
		$data['teamLeague'] = $this->Team_league->get_league($this->uri->segment(3));
		$data['matches'] = $data['teamLeague']->get_matches();
		$this->template->load('template', 'teamleagues/league', $data);
	}
	function match() {
		$data = array();
		if ($this->tank_auth->is_logged_in()) {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
		}
		
		$this->load->model('teamleague/Match');
		$this->load->model('teamleague/Round');
		$this->load->model('Team');
		$this->load->model('Player');

		$data['match'] = $this->Match->get_match($this->uri->segment(3));
		$this->template->load('template', 'teamleagues/match', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */