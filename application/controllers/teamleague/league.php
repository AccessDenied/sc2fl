<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class League extends CI_Controller
{
	function __construct() {
		parent::__construct();
	}

	function index() {
		$data = array();
		if ($this->tank_auth->is_logged_in()) {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['auth'] = true;
		}
		
		$this->load->model('teamleague/Team_league');
		$this->load->model('teamleague/Team_fantasy');
		$this->load->model('teamleague/Team_match');
		$this->load->model('teamleague/Team_round');
		$this->load->model('Team');
		$this->load->model('Player');
		
		$data['teamLeague'] = Team_league::get_league_by_id($this->uri->segment(3));
		$data['matches'] = $data['teamLeague']->get_matches();
		$this->template->load('template', 'teamleague/league', $data);
	}
	function match() {
		$data = array();
		if ($this->tank_auth->is_logged_in()) {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
		}
		
		$this->load->model('teamleague/Team_league');
		$this->load->model('teamleague/Team_match');
		$this->load->model('teamleague/Team_round');
		$this->load->model('Team');
		$this->load->model('Player');

		$data['match'] = $this->Team_match->get_match($this->uri->segment(4));
		$data['teamLeague'] = $data['match']->get_league();
		$data['competitors'] = $data['match']->get_competitors();
		$this->template->load('template', 'teamleague/match', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */