<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends PS_Controller
{
	public $menu_code = 'PROFILE';
	public $menu_group_code = 'ADMIN';
	public $title = 'User Profile';

  public function __construct()
  {
    parent::__construct();
    $this->home = base_url().'profile';
		$this->load->model('profile_model');
  }



  public function index()
  {

		$filter = array(
			'name' => get_filter('name', 'profile_name', '')
		);

				//--- แสดงผลกี่รายการต่อหน้า
		$perpage = get_filter('set_rows', 'rows', 20);
		//--- หาก user กำหนดการแสดงผลมามากเกินไป จำกัดไว้แค่ 300
		if($perpage > 300)
		{
			$perpage = get_filter('rows', 'rows', 300);
		}

		$segment = 3; //-- url segment
		$rows = $this->profile_model->count_rows($filter);

		//--- ส่งตัวแปรเข้าไป 4 ตัว base_url ,  total_row , perpage = 20, segment = 3
		$init	= pagination_config($this->home.'/index/', $rows, $perpage, $segment);

		$rs = $this->profile_model->get_list($filter, $perpage, $this->uri->segment($segment));

    $filter['data'] = $rs;

		$this->pagination->initialize($init);
    $this->load->view('profile/profile_list', $filter);
  }



	public function add_new()
	{
		if($this->pm->can_add)
		{
			$this->load->view('sale_team/sale_team_add');
		}
		else
		{
			$this->deny_page();
		}
	}


	public function add()
	{
		$sc = TRUE;
		$code = trim($this->input->post('code'));
		$name = trim($this->input->post('name'));
		$status = $this->input->post('status');

		if($this->pm->can_add)
		{
			if(!empty($code))
			{
				if(!empty($name))
				{
					$arr = array(
						'code' => $code,
						'name' => $name,
						'status' => $status === 'Y' ? 1 : 0
					);

					if(! $this->profile_model->add($arr))
					{
						$sc = FALSE;
						$this->error = "Insert data failed";
					}
				}
				else
				{
					$sc = FALSE;
					$this->error = "Missing 'Name' Parameter";
				}
			}
			else
			{
				$sc = FALSE;
				$this->error = "Missing 'Code' Parameter";
			}
		}
		else
		{
			$sc = FALSE;
			$this->error = "Missing permission";
		}

		$this->response($sc);
	}


	public function edit($code)
	{
		if($this->pm->can_edit)
		{
			$rs = $this->profile_model->get($code);
			if(!empty($rs))
			{
				$data['data'] = $rs;
				$this->load->view('sale_team/sale_team_edit', $data);
			}
			else
			{
				$this->error_page();
			}
		}
		else
		{
			$this->deny_page();
		}
	}



	public function update()
	{
		$sc = TRUE;

		if($this->pm->can_edit)
		{
			$code = trim($this->input->post('code'));
			$old_code = trim($this->input->post('old_code'));
			$name = trim($this->input->post('name'));
			$status = $this->input->post('status');

			$arr = array(
				'code' => $code,
				'name' => $name,
				'status' => $status === 'Y' ? 1 : 0
			);

			if(! $this->profile_model->update($old_code, $arr))
			{
				$sc = FALSE;
				$this->error = "Update Failed";
			}
		}
		else
		{
			$sc = FALSE;
			$this->error = "Missing Permission";
		}


		$this->response($sc);
	}



	public function delete()
	{
		$sc = TRUE;
		if($this->pm->can_delete)
		{
			$code = trim($this->input->post('code'));
			if(!empty($code))
			{
				//--- check sales team use by any user ?
				$has_transection = $this->user_model->has_sales_team($code);
				if(! $has_transection)
				{
					if(! $this->profile_model->delete($code))
					{
						$sc = FALSE;
						$this->error = "Delete Failed";
					}
				}
				else
				{
					$sc = FALSE;
					$this->error = "Delete failed : This Sales Team use by user(s)";
				}
			}
			else
			{
				$sc = FALSE;
				$this->error = "Missing Required Parameter";
			}
		}
		else
		{
			$sc = FALSE;
			$this->error = "Missing Permission";
		}

		$this->response($sc);
	}


	public function is_exists_code()
	{
		$sc = TRUE;
		$code = $this->input->post('code');
		$old_code = $this->input->post('old_code');

		if($this->profile_model->is_exists_code($code, $old_code))
		{
			$sc = FALSE;
			$this->error = "รหัสซ้ำ กรุณาใช้รหัสอื่น";
		}

		$this->response($sc);
	}


	public function is_exists_name()
	{
		$sc = TRUE;
		$name = $this->input->post('name');
		$old_name = $this->input->post('old_name');

		if($this->sales_team_model->is_exists_name($name, $old_name))
		{
			$sc = FALSE;
			$this->error = "ชื่อซ้ กรุณาใช้ชื่ออื่น";
		}

		$this->response($sc);
	}





  public function clear_filter()
	{
		$filter = array(
			'team_code',
			'team_name',
			'team_status',
			'team_order_by',
			'team_sort_by'
		);

		clear_filter($filter);
		echo 'done';
	}

}//--- end class


 ?>
