<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }


  public function get($id)
  {
    $rs = $this->db->where('id', $id)->get('profile');

    if($rs->num_rows() === 1)
    {
      return $rs->row();
    }

    return NULL;
  }


  public function get_name($id)
  {
    $rs = $this->db->where('id', $id)->get('profile');

    if($rs->num_rows() === 1)
    {
      return $rs->row()->name;
    }

    return NULL;
  }


  public function add(array $ds = array())
  {
    if(!empty($ds))
    {
      $rs = $this->db->insert('profile', $ds);

      if($rs)
      {
        return $this->db->insert_id();
      }
    }

    return FALSE;
  }


  public function update($id, $ds = array())
  {
    if(!empty($ds))
    {
      return $this->db->where('id', $id)->update('profile', $ds);
    }

    return FALSE;
  }


  public function delete($id)
  {
    if($id != 0 && $id != NULL && $id != "")
    {
      return $this->db->where('id', $id)->delete('profile');
    }

    return FALSE;
  }


  public function count_rows(array $ds = array())
  {
    if(isset($ds['name']) && $ds['name'] != "")
    {
      $this->db->like('name', $ds['name']);
    }

    return $this->db->count_all_results('profile');
  }


  public function get_list(array $ds = array(), $perpage = 20, $offset = 0)
  {
    if(isset($ds['name']) && $ds['name'] != "")
    {
      $this->db->like('name', $ds['name']);
    }

    $rs = $this->db
    ->order_by('name', 'ASC')
    ->limit($perpage, $offset)
    ->get('profile');

    if($rs->num_rows() > 0)
    {
      return $rs->result();
    }

    return NULL;
  }

} //--- end model
 ?>
