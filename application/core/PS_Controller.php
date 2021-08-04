<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PS_Controller extends CI_Controller
{
  public $ugroup;
  public $uid;
  public $_user;
  public $_superAdmin = FALSE;
  public $home;
  public $ms;
  public $mc;
	public $error;

  public function __construct()
  {
    parent::__construct();
    //--- check is user has logged in ?
    _check_login();

    $this->uid = get_cookie('uid');
    $this->_user = $this->user_model->get_user_by_uid($this->uid);

    if(!empty($this->_user))
    {
      $this->_superAdmin = $this->_user->id_profile == -987654321 ? TRUE : FALSE;
    }

    $this->close_system   = getConfig('CLOSE_SYSTEM'); //--- ปิดระบบทั้งหมดหรือไม่

    if($this->close_system == 1 && $this->_superAdmin === FALSE)
    {
      redirect(base_url().'setting/maintenance');
    }

    //--- get permission for user
    $this->pm = $this->user_model->get_permission($this->menu_code, $this->_user->id_profile);

    $this->ms = $this->load->database('ms', TRUE); //--- SAP database
    $this->mc = $this->load->database('mc', TRUE); //--- Temp Database

    $valid_date = date('Y-m-d', strtotime('2021-08-31'));

    if(date('Y-m-d') > $valid_date && $this->_superAdmin === FALSE)
    {
      $this->expired_page();
    }
  }


  public function response($sc = TRUE)
  {
    echo $sc === TRUE ? 'success' : $this->error;
  }

  public function deny_page()
  {
    return $this->load->view('deny_page');
  }

  public function expired_page()
  {
    return $this->load->view('expired_page');
  }


  public function error_page()
  {
    return $this->load->view('page_error');
  }
}

?>
