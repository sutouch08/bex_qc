<?php $this->load->view('include/header'); ?>
<div class="row">
	<div class="col-sm-6">
    <h3 class="title">
      <i class="fa fa-users"></i> <?php echo $this->title; ?>
    </h3>
    </div>
		<div class="col-sm-6">

		</div>
</div><!-- End Row -->
<hr class="title-block"/>
<form class="form-horizontal" id="resetForm" method="post" action="<?php echo $this->home."/change_password"; ?>">

	<div class="form-group">
    <label class="col-sm-3 control-label no-padding-right">Display name</label>
    <div class="col-xs-12 col-sm-3">
			<span class="input-icon input-icon-right width-100">
      	<input type="text" name="dname" id="dname" class="width-100" value="<?php echo $data->emp_name; ?>" disabled />
				<i class="ace-icon fa fa-user"></i>
			</span>
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline red" id="dname-error"></div>
  </div>



  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right">User name</label>
    <div class="col-xs-12 col-sm-3">
			<span class="input-icon input-icon-right width-100">
        <input type="text" name="uname" id="uname" class="width-100" value="<?php echo $data->uname; ?>" disabled />
				<i class="ace-icon fa fa-user"></i>
			</span>
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline red" id="uname-error"></div>
  </div>


	<div class="form-group">
    <label class="col-sm-3 control-label no-padding-right">Current password</label>
    <div class="col-xs-12 col-sm-3">
			<span class="input-icon input-icon-right width-100">
        <input type="password" name="cpwd" id="cpwd" class="width-100" placeholder="รหัสผ่านปัจจุบัน" autofocus required />
				<i class="ace-icon fa fa-key"></i>
			</span>
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline red" id="cpwd-error"></div>
  </div>


  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right">New password</label>
    <div class="col-xs-12 col-sm-3">
			<span class="input-icon input-icon-right width-100">
        <input type="password" name="pwd" id="pwd" class="width-100" required />
				<i class="ace-icon fa fa-key"></i>
			</span>
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline red" id="pwd-error"></div>
  </div>

	<div class="form-group">
    <label class="col-sm-3 control-label no-padding-right">Confirm password</label>
    <div class="col-xs-12 col-sm-3">
			<span class="input-icon input-icon-right width-100">
        <input type="password" name="cfpwd" id="cfpwd" class="width-100" required />
				<i class="ace-icon fa fa-key"></i>
			</span>
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline red" id="cfpwd-error"></div>
  </div>

	<div class="divider-hidden">

	</div>
  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right"></label>
    <div class="col-xs-12 col-sm-3">
      <p class="pull-right">
        <button type="button" class="btn btn-sm btn-success" onclick="changePassword()"><i class="fa fa-save"></i> เปลี่ยนรหัสผ่าน</button>
      </p>
    </div>
    <div class="help-block col-xs-12 col-sm-reset inline">
      &nbsp;
    </div>
  </div>
	<input type="hidden" name="user_id" id="user_id" value="<?php echo $data->id; ?>" />
</form>

	<input type="hidden" name="uid" id="uid" value="<?php echo $data->uid; ?>" />
</form>

<script src="<?php echo base_url(); ?>scripts/users/user_pwd.js"></script>
<?php $this->load->view('include/footer'); ?>
