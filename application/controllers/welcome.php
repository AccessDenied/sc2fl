<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$data = array();
		if ($this->tank_auth->is_logged_in()) {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['auth'] = true;
		}
		$this->load->model('teamleague/Team_league');
		$this->load->model('teamleague/Team_fantasy');
		$data['teamLeagues'] = $this->Team_league->get_leagues();
		$this->template->load('template', 'welcome', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */