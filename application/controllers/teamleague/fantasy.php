<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Fantasy extends CI_Controller
{
	function __construct() {
		parent::__construct();
	}

	function index() {
		$data = array();
		if ($this->tank_auth->is_logged_in()) {
			$data['user_id'] = $this->tank_auth->get_user_id();
			$data['username'] = $this->tank_auth->get_username();
			$data['auth'] = true;
		}
		
		$this->load->model('teamleague/Team_league');
		$this->load->model('teamleague/Team_fantasy');
		$this->load->model('teamleague/Team_statistics');
		$this->load->model('teamleague/Team_team_statistics');
		$this->load->model('teamleague/Team_player_statistics');
		$this->load->model('teamleague/Team_match');
		$this->load->model('teamleague/Team_round');
		$this->load->model('Team');
		$this->load->model('Player');

		$data['fantasy'] = $this->Team_fantasy->get_fantasy_by_id($this->uri->segment(3));
		$data['statistics'] = $this->Team_league->get_league_by_id($data['fantasy']->get_league_id())->get_fantasy_statistics();
		
		if (isset($data['user_id'])) {
			$data['drafted_players'] = array();
			$this->db->join('player', 'player.player_id = team_fantasy_player_draft.player_id');
			$query = $this->db->get_where('team_fantasy_player_draft', array('user_id'=>$data['user_id'],'fantasy_id'=>$data['fantasy']->get_id()));
			foreach ($query->result() as $row) {
				array_push($data['drafted_players'], new Player($row->player_id, $row->name, $row->description, $row->team_id));
			}
			
			$this->db->join('team', 'team.team_id = team_fantasy_team_draft.team_id');
			$query = $this->db->get_where('team_fantasy_team_draft', array('user_id'=>$data['user_id'],'fantasy_id'=>$data['fantasy']->get_id()));
			$row = $query->row();
			if (sizeOf($row) > 0)
				$data['drafted_team'] = new Team($row->team_id, $row->name, $row->description);
		}
		$this->template->load('template', 'teamleague/fantasy', $data);
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
				
		$this->db->join('player', 'player.player_id = team_fantasy_player_draft.player_id');
		$this->db->join('users', 'team_fantasy_player_draft.user_id = users.id');
		$query = $this->db->get_where('team_fantasy_player_draft', array('fantasy_id'=>$fantasy->get_id()));
		$response = array();
		$response['players'] = array();
		$response['users'] = array();
		foreach ($query->result() as $row) {
			if (!isset($response['players'][$row->player_id])) $response['players'][$row->player_id] = array();
			$response['players'][$row->player_id]['name'] = $row->name;
			$response['players'][$row->player_id]['ownerId'] = $row->user_id;
			
			$response['users'][$row->user_id] = $row->username;
		}
		echo json_encode($response);
	}
	function manage() {
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		
		$this->load->model('teamleague/Team_league');
		$this->load->model('teamleague/Team_fantasy');
		$this->load->model('Team');
		$this->load->model('Player');
		
		$data = array();
		if ($this->tank_auth->is_logged_in()) {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
		}
		
		$data['fantasy'] = Team_fantasy::get_fantasy_by_id($this->uri->segment(4));
		$data['league'] = Team_league::get_league_by_id($data['fantasy']->get_league_id());
		$query = $this->db->get_where('team_fantasy_team_draft', array('user_id'=>$data['user_id'],'fantasy_id'=>$data['fantasy']->get_id()));
		$row = $query->row();
		if (sizeOf($row) > 0) $data['team_id'] = $row->team_id;
		$this->load->view('teamleague/fantasy/manage', $data);
	}
	function updatedraft() {
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('count', 'Number of Players Drafted', 'trim|required|xss_clean|integer');
		for ($key = 0;$key < intval($_POST['count']);$key++) {
			$this->form_validation->set_rules(strval($key), 'Player Drafted', 'trim|required|xss_clean|integer');
		}
		$this->form_validation->set_rules('teamId', 'Team Drafted', 'trim|required|xss_clean|integer');
		$this->form_validation->set_rules('fantasy_id', 'Fantasy League', 'trim|required|xss_clean|integer');
		
		$response = array();
		
		if ($this->tank_auth->is_logged_in() && $this->form_validation->run()) { // validation ok
			$this->db->delete('team_fantasy_player_draft', array('user_id'=>$this->tank_auth->get_user_id(),'fantasy_id'=>$this->form_validation->set_value('fantasy_id')));
			
			$draftedPlayers = array();
			$query = $this->db->get_where('team_fantasy_player_draft', array('fantasy_id'=>$this->form_validation->set_value('fantasy_id')));
			foreach ($query->result() as $row) {
				array_push($draftedPlayers, $row->player_id);
			}
			
			$count = $this->form_validation->set_value('count');
			for ($key = 0;$key<$count;$key++) {
				if (!in_array($this->form_validation->set_value($key),$draftedPlayers)) {
					$data = array(
						'user_id'=>$this->tank_auth->get_user_id(),
						'player_id'=>$this->form_validation->set_value(strval($key)),
						'fantasy_id'=>$this->form_validation->set_value('fantasy_id'),
						'date_drafted'=>date('y-m-d H:i:s')
					);
					$this->db->insert('team_fantasy_player_draft', $data);
				}
			}
			
			if (!is_null($this->form_validation->set_value('teamId'))) {
				$query = $this->db->get_where('team_fantasy_team_draft', array('user_id'=>$this->tank_auth->get_user_id(),'fantasy_id'=>$this->form_validation->set_value('fantasy_id')));
				$row = $query->row();
				if (sizeOf($row) == 0) {
					$data = array(
						'user_id'=>$this->tank_auth->get_user_id(),
						'team_id'=>$this->form_validation->set_value('teamId'),
						'fantasy_id'=>$this->form_validation->set_value('fantasy_id'),
						'date_drafted'=>date('y-m-d H:i:s')
					);
					$this->db->insert('team_fantasy_team_draft', $data);
				} else {
					$this->db->where('user_id',$this->tank_auth->get_user_id());
					$this->db->where('fantasy_id',$this->form_validation->set_value('fantasy_id'));
					$this->db->update('team_fantasy_team_draft', array('team_id'=>$this->form_validation->set_value('teamId'))); 
				}
			}
		} else {
			$response['error'] = $_POST["count"].' | '.validation_errors();
			echo json_encode($response);
		}
	}
	function join() {
		$this->load->model('teamleague/Team_fantasy');
		$this->load->library('form_validation');
		$user_id = $this->tank_auth->get_user_id();
		
		$fantasy = Team_fantasy::get_fantasy_by_id($this->uri->segment(4));
		$participant_ids = $fantasy->get_participant_ids();
		
		if ($this->tank_auth->is_logged_in() && !in_array($user_id, $participant_ids)) { // validation ok
			$data = array(
				'fantasy_id'=>$fantasy->get_id(),
				'user_id'=>$user_id
			);
			$this->db->insert('team_fantasy_participant', $data);	
		}
	}
	function delete() {
		$this->load->model('teamleague/Team_fantasy');
		$this->load->library('form_validation');
		$user_id = $this->tank_auth->get_user_id();
		
		$fantasy = Team_fantasy::get_fantasy_by_id($this->uri->segment(4));
		$owner_id = $fantasy->get_owner_id();
		if ($this->tank_auth->is_logged_in() && $owner_id == $user_id) { // validation ok
			$data = array(
				'fantasy_id'=>$fantasy->get_id()
			);
			$this->db->delete('team_fantasy_participant', $data);
			$this->db->delete('team_fantasy', $data);
		}
	}
	function leave() {
		$this->load->model('teamleague/Team_fantasy');
		$this->load->library('form_validation');
		$user_id = $this->tank_auth->get_user_id();
		
		$fantasy = Team_fantasy::get_fantasy_by_id($this->uri->segment(4));
		$participant_ids = $fantasy->get_participant_ids();
		
		if ($this->tank_auth->is_logged_in() && in_array($user_id, $participant_ids)) { // validation ok
			$data = array(
				'fantasy_id'=>$fantasy->get_id(),
				'user_id'=>$user_id
			);
			$this->db->delete('team_fantasy_participant', $data);	
		}
	}
	function create() {
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('desc', 'Description', 'trim|required|xss_clean');
		$this->form_validation->set_rules('userLimit', 'User Limit', 'trim|required|xss_clean|integer');
		$this->form_validation->set_rules('leagueId', 'Team League ID', 'trim|required|xss_clean|integer');
		
		$response = array();
		
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
			$response['fantasy_id'] = $data['fantasy_id'];
			echo json_encode($response);
			$this->db->insert('team_fantasy_participant', $data);
		} else {
			if (sizeOf($this->input->post()) > 1) {
				$response['error'] = validation_errors();
				echo json_encode($response);
			} else {
				$data['team_league_id'] = $this->uri->segment(4);
				$this->load->view('teamleague/fantasy/create', $data);
			}
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */