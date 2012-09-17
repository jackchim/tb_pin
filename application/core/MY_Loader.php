<?php if (!defined('BASEPATH')) exit('No direct access allowed.');


class MY_Loader extends CI_Loader
{
	public function __construct()
	{
		parent::__construct();
	}
	public function set_theme($theme='default')
	{
		$this->_ci_view_paths = array(FCPATH.'themes/'.$theme.'/'	=> TRUE);
	}

	public function set_admin_theme()
	{
		$this->_ci_view_paths = array(FCPATH.'themes/'	=> TRUE);
	}

	public function set_install_theme()
	{
		$this->_ci_view_paths = array(FCPATH.'themes/'	=> TRUE);
	}



}