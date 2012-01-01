<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Test controller class
 *
 * @class Test
 */
class Test extends NMN_Controller
{
	/**
	 * Test Constructor
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

	/**
	 * The 'show_constants' method
	 */
	public function show_constants()
	{
		echo "<pre>";
		print_r(get_defined_constants(true));
		die();
	}

	/**
	 * The 'chromephp' method
	 */
	public function chromephp()
	{
		$this->chromephp->log('This log should be shown in your Browser console.');
		$this->chromephp->log($_SERVER);

		foreach ($_SERVER as $key => $value)
		{
			$this->chromephp->log($key, $value);
		}
	}

	/**
	 * The 'prowl' method
	 */
	public function prowl()
 	{
		// my prowl API key
		$config['apikey'] = '123456789123456789';
		
		// Application identifier
		$config['application'] = "livesets.de";
		
		// Load the class
		$this->load->library('prowl', $config);
		
		// Try to send a test message to Prowl
		$result = $this->prowl->send('Development', 'This TEST message was sent from livesets.de!');
		
		// Show whats Prowl returned..
		print_r($result);
 	}
}

/* End of file test.php */
/* Location: ./application/controllers/test.php */