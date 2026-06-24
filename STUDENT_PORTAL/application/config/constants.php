<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

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
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


/**** USER DEFINED CONSTANTS **********/

define('ROLE_ADMIN',                            '1');
define('ROLE_MANAGER',                         	'2');
define('ROLE_EMPLOYEE',                         '3');

define('SEGMENT',								2);

define('ADMIN_PATH','https://sjpuchassan.schoolphins.com/staff/');


define('TITLE','ST ANNS COMPOSITE PU COLLEGE');
define('SUB_TITLE','ST ANNS COMPOSITE PU COLLEGE');
define('INSTITUTION_LOGO','assets/dist/img/anns_logo.jpg');
define('TAB_TITLE','SchoolPhins - ST ANNS COMPOSITE PU');
/************************** EMAIL CONSTANTS *****************************/

define('EMAIL_FROM',                            'info@schoolphins.com');		// e.g. email@example.com
define('EMAIL_BCC',                            	'');		// e.g. email@example.com
define('FROM_NAME',                             'SJPUCH Schoolphins');	// Your system name
define('EMAIL_PASS',                            'Your email password');	// Your email password
define('PROTOCOL',                             	'smtp');				// mail, sendmail, smtp
define('SMTP_HOST',                             'Your smtp host');		// your smtp host e.g. smtp.gmail.com
define('SMTP_PORT',                             '25');					// your smtp port e.g. 25, 587
define('SMTP_USER',                             'Your smtp user');		// your smtp user
define('SMTP_PASS',                             'Your password');	// your smtp password
define('MAIL_PATH',                             '/usr/sbin/sendmail');

//payment Gateway Worldline Config
define('M_ID','WL0000000009333'); //prod: WL0000000009333 test: WL0000000027698
define('ENC_KEY','bd13116b6708f39208d2455054a9cd60'); // prod:bd13116b6708f39208d2455054a9cd60 TEST: 6375b97b954b37f956966977e5753ee6
define('CUR_TYPE_INR','INR');
define('PROD_GATEWAY_URL','https://ipg.in.worldline.com/doMEPayRequest');//prod: https://ipg.in.worldline.com/doMEPayRequest //test: https://cgt.in.worldline.com/ipg/doMEPayRequest


define('M_ID_TEST','');
define('ENC_KEY_TEST','');
define('TEST_GATEWAY_URL','');


//payment Paytm
define('PAYTM_ENVIRONMENT', 'TEST'); // PROD
define('PAYTM_MERCHANT_KEY', 'Z3akFMYqqaCrcl#k'); //Change this constant's value with Merchant key received from Paytm.
define('PAYTM_MERCHANT_MID', 'voNgvy71821468563824'); //Change this constant's value with MID (Merchant ID) received from Paytm.
define('PAYTM_MERCHANT_WEBSITE', 'WEBSTAGING'); //Change this constant's value with Website name received from Paytm.

$PAYTM_STATUS_QUERY_NEW_URL='https://securegw-stage.paytm.in/order/status';
$PAYTM_TXN_URL='https://securegw-stage.paytm.in/order/process';
if (PAYTM_ENVIRONMENT == 'PROD') {
	$PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/order/status';
	$PAYTM_TXN_URL='https://securegw.paytm.in/order/process';
}

define('PAYTM_REFUND_URL', '');
define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_TXN_URL', $PAYTM_TXN_URL);


define('CURRENT_YEAR', '2026');
define('FEE_YEAR', '2026');


define('USERNAME_TEXTLOCAL',                            'info@schoolphins.com');
define('HASH_TEXTLOCAL',                                '7d6114f94ffd371cdae05b9132732b94dc5667f9a7315cf7aa3168a2465e20f6');
define('SENDERID_TEXTLOCAL',                            'PARROP');	
define('API_KEY',                                       'NGU3ODYyNjk1NzM5NjE0NDMxNmE0NjQ2NDc2NjRhNjg=');
define('EXAM_YEAR', '2024-25');

define('FEES_ADDRESS', 'Near Shivagiri, Ukkali Road, Vijayapur - 586104');
define('SCHOOL_CODE', 'EE0272');
define('DISE_CODE', '29031401417');
define('FEEDBACK_YEAR', '2025');

define('EB_MERCHANT_KEY', 'TGJ0KCXBV');
define('EB_SALT', 'FABW2YTIV');
define('EB_ENV', 'test');
define('APP_EB_MODE', 'test');
define('EB_LINK','https://testpay.easebuzz.in/payment/initiateLink');

define('FEES_TITLE','ST ANNS COMPOSITE PU COLLEGE');
define('FEES_ADDRESS','VR5P+QM3, Pandeshwar, Mangaluru, Karnataka 575001');

