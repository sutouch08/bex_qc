<?php
function _check_login()
{
  $CI =& get_instance();
  $uid = get_cookie('uid');
  if($uid === NULL OR $CI->user_model->verify_uid($uid) === FALSE)
  {
    redirect(base_url().'authentication');
  }
}


function get_permission($menu, $uid = NULL, $id_profile = NULL)
{
  $CI =& get_instance();

  $uid = $uid === NULL ? get_cookie('uid') : $uid;
  $user = $CI->user_model->get_user_by_uid($uid);
  if(empty($user))
  {
    return reject_permission();
  }

  //--- If super admin
  if($user->id_profile == -987654321)
  {
    $pm = new stdClass();
    $pm->can_view = 1;
    $pm->can_add = 1;
    $pm->can_edit = 1;
    $pm->can_delete = 1;
    $pm->can_approve = 1;
  }
  else
  {
    $pm = $CI->user_model->get_permission($menu, $uid, $user->id_profile);
    if(empty($pm))
    {
      return reject_permission();
    }
    else
    {
      if(getConfig('CLOSE_SYSTEM') == 2)
      {
        $pm->can_add = 0;
        $pm->can_edit = 0;
        $pm->can_delete = 0;
        $pm->can_approve = 0;
      }
    }
  }

  return $pm;
}


function reject_permission()
{
  $pm = new stdClass();
  $pm->can_view = 0;
  $pm->can_add = 0;
  $pm->can_edit = 0;
  $pm->can_delete = 0;
  $pm->can_approve = 0;

  return $pm;
}


function select_sales_team($code = NULL)
{
  $CI =& get_instance();
  $CI->load->model('sales_team_model');
  $result = $CI->sales_team_model->get_all();
  $ds = '';
  if(!empty($result))
  {
    foreach($result as $rs)
    {
      $ds .= '<option value="'.$rs->code.'" '.is_selected($rs->code, $code).'>'.$rs->code.' : '.$rs->name.'</option>';
    }
  }

  return $ds;
}


function select_user_group($code = NULL)
{
  $ds = '';
  $CI =& get_instance();
  $qs = $CI->user_model->get_all_user_group();
  if(!empty($qs))
  {
    foreach($qs as $rs)
    {
      $ds .= '<option value="'.$rs->code.'" '.is_selected($rs->code, $code).'>'.$rs->name.'</option>';
    }
  }

  return $ds;
}


function select_department($code = NULL)
{
  $ds = '';
  $CI =& get_instance();
  $qs = $CI->user_model->get_all_department();
  if(!empty($qs))
  {
    foreach($qs as $rs)
    {
      $ds .= '<option value="'.$rs->code.'" '.is_selected($rs->code, $code).'>'.$rs->code.' : '.$rs->name.'</option>';
    }
  }

  return $ds;
}


function select_division($code = NULL)
{
  $ds = '';
  $CI =& get_instance();
  $qs = $CI->user_model->get_all_division();
  if(!empty($qs))
  {
    foreach($qs as $rs)
    {
      $ds .= '<option value="'.$rs->code.'" '.is_selected($rs->code, $code).'>'.$rs->code.' : '.$rs->name.'</option>';
    }
  }

  return $ds;
}


function select_employee($empID = NULL)
{
  $ds = '';
  $CI =& get_instance();
  $qs = $CI->user_model->get_all_employee();
  if(!empty($qs))
  {
    foreach($qs as $rs)
    {
      $ds .= '<option value="'.$rs->empID.'" '.is_selected($rs->empID, $empID).'>'.$rs->firstName.' '.$rs->lastName.'</option>';
    }
  }

  return $ds;
}



function select_saleman($sale_id = '')
{
  $ds = '';
  $CI =& get_instance();
  $qs = $CI->user_model->get_all_slp();
  if(!empty($qs))
  {
    foreach($qs as $rs)
    {
      $ds .= '<option value="'.$rs->id.'" '.is_selected($rs->id, $sale_id).'>'.$rs->name.'</option>';
    }
  }

  return $ds;
}


function get_sale_name($sale_id)
{
  $CI =& get_instance();
  return $CI->get_sale_name($sale_id);
}


 ?>
