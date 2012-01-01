<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Core NMN_Controller Class
 *
 * @class NMN_Controller
 */
class NMN_Controller extends CI_Controller
{
	public $data = array();
	
	function __construct()
	{
		parent::__construct();

		/** 
		 * ChromePhp
		 *
		 * If class is not auto-loaded, you have to load it here.
		 */
		//$this->load->library('ChromePhp');
		
		/**
		 * ChromePhp
		 *
		 * This will allow you to specify a path on disk and a uri to access
		 * a static file that can store json. This allows you to log data
		 * that is more than 4k.
		 */
		$this->chromephp->useFile(
			'/home/norman/htdocs/livesets.de/logs/chromelogs',
			'/data/chromelogs'
		);
	}
}

/* End of file NMN_Controller.php */
/* Location: ./application/core/NMN_Controller.php */