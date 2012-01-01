<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter NMN Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Norman Georg-Tusel <norm@ngeorg.com>
 * @link		
 */

// ------------------------------------------------------------------------


/**
 * Script
 *
 * Generates an HTML script tag for importing an external javascript file.
 *
 * @access   public
 * @param   string
 * @return   string
 */
if ( ! function_exists('script'))
{
	function script($rpath)
	{
		return '<script src="'.base_url().$rpath.'"></script>';
	}
}
// ------------------------------------------------------------------------

/**
 * builds a breadcrumb line
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('nmn_breadcrumb'))
{
	function nmn_breadcrumb($arr, $return=false)
	{
		$out = '<br /><ul id="breadcrumbs">';
		$out .= "\n<li>".anchor('/', 'Zur Startseite', 'title="Zurück zur Startseite"')."</li>\n";

		foreach($arr as $level => $entry)
		{
			if(is_array($entry))
			{
				$out .= '<li>'.anchor($entry[0], $entry[1])."</li>\n";
			}
			else $out .= '<li>'.$entry."</li>\n";
		}
		if($return)
		{
			return $out . "</ul>\n";
		}
		else echo $out . "</ul>\n";
	}
}

// ------------------------------------------------------------------------

/**
 * Strip the UTF-8 BOM header from string/file
 *
 * @access public
 */
function strip_bom($str)
{
	$bom = pack("CCC", 0xef, 0xbb, 0xbf);
	if(0==strncmp($str, $bom, 3))
	{
		notify("UTF-8 BOM detected and stripped.",'attention');
		$str = substr($str, 3);
	}
	return $str;
}

function strip_invalid_chars($str)
{
	$pos = strpos($str, '"');
	if(false!==$pos AND $pos>0)
	{
		notify("Illegal chars in file heading detected and stripped.",'attention');
		$str = substr($str,$pos);
	}
	return $str;
}

if( ! function_exists('ceiling'))
{
    function ceiling($number, $significance=1)
    {
        return(is_numeric($number) && is_numeric($significance))
			? (ceil($number/$significance)*$significance)
		    : false;
    }
}

// ------------------------------------------------------------------------





/**
 * Set Global Messages
 *
 * @access	public
 * @param	array | String
 * @return	void
 */	
if ( ! function_exists('notify'))
{
	function notify($msg='', $type='note', $is_multiple=true, $session=null)
	{
		if(is_null($session))
		{
			$CI =& get_instance();
			$global_messages = (array)$CI->session->userdata('global_messages');
		}
		else $global_messages = (array)$session->userdata('global_messages');
		
		foreach((array)$msg as $v)
		{
			if($is_multiple)
				$global_messages[$type][] = (string)$v;
			else
				$global_messages[$type][0] = (string)$v;
		}

		$CI->session->set_userdata('global_messages', $global_messages);
	}
}

// ------------------------------------------------------------------------

/**
 * stores a flash notification message
 *
 * available types: error|success|information|attention|note
 *
 * @access	public
 * @return	bool
 */
if ( ! function_exists('depr_notify'))
{
	function depr_notify($msg, $realm='note')
	{
		$CI =& get_instance();
		$CI->load->library('session');
da($CI);
		$notifications = $CI->session->flashdata('flash_notifications');
		if(!$notifications)
		{
			$notifications = array("$realm"=>array());
		}
		//da($notifications);
		$notifications[$realm][] = $msg;

		$CI->session->set_flashdata('flash_notifications', $notifications);
	}
}

// ------------------------------------------------------------------------

/**
 * Get Global Messages
 *
 * @access	public
 * @param	void
 * @return	string
 */
//error_reporting(0);
if ( ! function_exists('notifications'))
{
	function notifications()
	{
		$str = '';
		$CI =& get_instance();
		$allowed_types = array('note','error','success','information','attention');

		$global_messages = (array)$CI->session->userdata('global_messages');
		
		if(count($global_messages) > 0)
		{
			foreach($global_messages as $type => $val)
			{
				if( ! in_array($type, $allowed_types)) continue;

				foreach((array)$val as $w)
				{
					if( ! isset($w) OR $w=="") continue;

					$item = "<!-- Notification -->\n";
					$item .= '<div class="notification '.$type.'">';
					$item .= '<a href="#" class="close-notification" title="schließen" rel="tooltip">x</a>';
			
					switch($type)
					{
						case 'error': 
							$item.="<p><strong>Fehler: </strong>".$w."</p>\n";break;
						case 'success': 
							$item.="<p><strong>OK! </strong>".$w."</p>\n";break;
						case 'information': 
							$item.="<p><strong>Info: </strong>".$w."</p>\n";break;
						case 'attention': 
							$item.="<p><strong>Achtung: </strong>".$w."</p>\n";break;
						case 'note': 
							$item.="<p><strong>Hinweis: </strong>".$w."</p>\n";break;
					}
					$str .= $item."</div>\n<!-- /Notification -->\n";
				}
			}
		} 
		
		$CI->session->unset_userdata('global_messages');
		
		return $str;
	}
}

// ------------------------------------------------------------------------

/**
 * prints avaiable notifications
 *
 * available realms: error|success|information|attention|note
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('depr_notifications'))
{
	function depr_notifications()
	{
		$CI = &get_instance();
		$CI->load->library('session');

		//da($CI->session);die();
		$notifications = $CI->session->flashdata('flash_notifications');
		//da($notifications);
		if(is_array($notifications) AND sizeof($notifications)>0)
		{
			foreach($notifications as $realm => $msg)
			{
				foreach($msg as $id => $text)
				{
					$out = "<!-- Notification -->\n";
					$out .= '<div class="notification '.$realm.'">';
					$out .= '<a href="#" class="close-notification" title="schließen" rel="tooltip">x</a>';
			
					switch($realm)
					{
						case 'error': $out.="<p><strong>Fehler: </strong>".$text."</p>\n";break;
						case 'success': $out.="<p><strong>OK! </strong>".$text."</p>\n";break;
						case 'information': $out.="<p><strong>Info: </strong>".$text."</p>\n";break;
						case 'attention': $out.="<p><strong>Achtung: </strong>".$text."</p>\n";break;
						case 'note': $out.="<p><strong>Hinweis: </strong>".$text."</p>\n";break;
					}
			
					echo $out . "</div>\n<!-- /Notification -->\n";
				}
			}
		}
	/*
		<!-- Notification -->
		<div class="notification error">
			<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
			<p><strong>Error notification</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vulputate, sapien quis fermentum luctus, libero.</p>
		</div>
		<!-- /Notification -->
	*/
	}
}

// ------------------------------------------------------------------------

function ln($str, $br=true)
{
	print $str;
	if($br) print BR;
}

// ------------------------------------------------------------------------

function da($arrOrObj, $die=null)
{
	print "<pre>";
	if(is_object($arrOrObj)) var_dump($arrOrObj);
	if(is_array($arrOrObj)) print_r($arrOrObj);
	print "</pre>";
	if(!is_null($die)) die();
}

// ------------------------------------------------------------------------

// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------




/* End of file nmn_helper.php */
/* Location: ./application/helpers/nmn_helper.php */
