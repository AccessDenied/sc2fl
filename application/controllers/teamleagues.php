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
			$data['auth'] = true;
		}
		
		$this->load->model('teamleague/Team_league');
		$this->load->model('teamleague/Team_fantasy');
		$this->load->model('teamleague/Match');
		$this->load->model('teamleague/Round');
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
		
		$this->load->model('teamleague/Team_league');
		$this->load->model('teamleague/Match');
		$this->load->model('teamleague/Round');
		$this->load->model('Team');
		$this->load->model('Player');

		$data['match'] = $this->Match->get_match($this->uri->segment(3));
		$data['teamLeague'] = $data['match']->get_league();
		$data['competitors'] = $data['match']->get_competitors();
		$this->template->load('template', 'teamleagues/match', $data);
	}
	function create() {
		$this->load->helper(array('form', 'url'));
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
			
			$data = array(
				'fantasy_id'=>$this->db->insert_id(),
				'user_id'=>$this->tank_auth->get_user_id()
			);
			$this->db->insert('team_fantasy_participant', $data);
		} else {
			if (sizeOf($this->input->post()) > 1) {
				echo validation_errors();
			} else {
				$data['team_league_id'] = $this->uri->segment(3);
				$this->load->view('teamleagues/create', $data);
			}
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */