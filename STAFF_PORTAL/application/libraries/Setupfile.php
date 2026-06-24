<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setupfile {

  function send($number, $message)
  {
    $ci = & get_instance();
    $data=array("username"=>'stjoshep@schoolphins.com',"hash"=>'3379348e4273db8d5540aba1f1b1d2fec4916765','apikey'=>false);
    $sender  = "SJPUCB";
    $numbers = array($number);
    $ci->load->library('textlocal',$data);

    $response = $ci->textlocal->sendSms($numbers, $message, $sender);
  return $response;
  }
}
