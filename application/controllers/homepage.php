<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Homepage controller class
 *
 * @class Homepage
 */
class Homepage extends NMN_Controller
{
	/**
	 * Homepage Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * The 'index' method
	 */
	public function index()
	{
		$this->template->render();
	}
}

/* End of file homepage.php */
/* Location: ./application/controllers/homepage.php */