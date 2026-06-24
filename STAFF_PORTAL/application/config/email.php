<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'protocol' => 'smtp',
    'smtp_host' => 'smtp.googlemail.com',
    'smtp_port' => 465,
    'smtp_user' => 'norepaly@schoolphins.com',
    'smtp_pass' => '&@O)N?]Y#0z1',
    'smtp_crypto' => 'ssl',
    'mailtype' => 'text', //plaintext 'text' mails or 'html'
    'smtp_timeout' => '4', //in seconds
    'charset' => 'iso-8859-1',
    'wordwrap' => TRUE,
    'validate' => TRUE,


    //Custom Properties
    'sender_name' => "Agnes",//sender display name
);