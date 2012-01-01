<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| NMN Company Constants
|--------------------------------------------------------------------------
|
| At last these constants are only aliases for me to write less code.
|
*/
defined('NMN_DEVELOPER') ? null : define('NMN_DEVELOPER', 'Norman Georg-Tusel');
defined('NMN_COMPANY')   ? null : define('NMN_COMPANY',   '(NMN) IT-Consulting & Development');
defined('NMN_PHONE')     ? null : define('NMN_PHONE',     '+49 (0) 151 / 15 60 10 97');
defined('NMN_EMAIL')     ? null : define('NMN_EMAIL',     'norm@ngeorg.com');
defined('NMN_URL')       ? null : define('NMN_URL',       'http://ngeorg.com');

/*
|--------------------------------------------------------------------------
| NMN Project Constants
|--------------------------------------------------------------------------
*/
defined('NMN_CORE_VERSION') ? null : define('NMN_CORE_VERSION', '1.0');
defined('NMN_REVISION')     ? null : define('NMN_REVISION',     '0.0.3');
defined('SVN_ID')           ? null : define('SVN_ID',           '$Id$');
defined('SVN_REVISION')     ? null : define('SVN_REVISION',     '$Revision$');

/*
|--------------------------------------------------------------------------
| NMN Copyright
|--------------------------------------------------------------------------
*/
define('PROPAGANDA', '(c) 2011, '.NMN_DEVELOPER.' <'.NMN_EMAIL.'>, All rights reserved.');

/*
|--------------------------------------------------------------------------
| DevHelper Constants
|--------------------------------------------------------------------------
|
| At last these constants are only aliases for developers to write
| cleaner code.
|
*/
defined('LB') ? null : define('LB', PHP_EOL); //"\r\n");
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
defined('PS') ? null : define('PS', PATH_SEPARATOR);
defined('CS') ? null : define('CS', '_'); // class separator (defaults to "_")
defined('QS') ? null : define('QS', '?'); // query string (deaults to "?")
defined('BR') ? null : define('BR', '<br>'); // line break 
defined('HR') ? null : define('HR', '<hr>'); // horizontal-line
defined('LN') ? null : define('LN', '------------------------------------------------------------------------------');

/*
|--------------------------------------------------------------------------
| OS Environment
|--------------------------------------------------------------------------
|
| Check the PHP_OS Constant
|
*/
switch(strtoupper(substr(PHP_OS,0,3)))
{
	case 'WIN': define('NMN_OS', 'Windows');break;
	case 'DAR': define('NMN_OS', 'Darwin'); break;
	default:    define('NMN_OS', PHP_OS);   break;
}

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */