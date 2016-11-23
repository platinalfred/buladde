<?php 
include("includes/header.php"); 
require_once("lib/Member.php");
$member = new Member();
?>
 <!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
		  <div class="title_left">
			<h3>Members</h3>
		  </div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>Add new member</h2>
						<ul class="nav navbar-right panel_toolbox">
						  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						  </li>
						  
						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<!-- Smart Wizard -->
						<!--<p>This is a basic form wizard example that inherits the colors from the selected scheme.</p>-->
						<div id="add_member" class="form_wizard wizard_horizontal">
							<ul class="wizard_steps">
								<li>
								  <a href="#step-1">
									<span class="step_no">1</span>
									<span class="step_descr">
										Step 1<br /><small>Demographic Infomation</small>
									</span>
								  </a>
								</li>
								<li>
									<a href="#step-2">
										<span class="step_no">2</span>
										<span class="step_descr">Step 2<br /><small>Contact Information</small></span>
									</a>
								</li>
								<li>
									<a href="#step-3"><span class="step_no">3</span>
									<span class="step_descr">Step 3<br /><small>Registration Infomation</small></span>
								  </a>
								</li>
							</ul>
							<div id="step-1">
								<form class="form-horizontal form-label-left" novalidate>
									<input type="hidden" name="add_member" value="add_member">
									<?php
									$type = "member";
									$person_type = $member->getfrec("persontype","id","name= '$type'","", "");
									$p_type = $person_type['id'];
									$person_number = (strtoupper(substr($type, 0, (1-strlen($type)))))."".(date('dmyHis'));
									?>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Person Number</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
										  <input type="text" class="form-control" name="person_number" value="<?php echo $person_number; ?>" readonly="readonly" placeholder="Read-Only Input">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Title</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
										  <select class="form-control" name="title">
											<option value="">Choose option</option>
											<option value="Mr" >Mr.</option>
											<option value="Mrs">Mrs.</option>
											<option value="Dr">Dr.</option>
											<option value="Prof">Prof.</option>
										  </select>
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="firstname">First Name <span class="required">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
										  <input id="firstname" class="form-control col-md-7 col-xs-12"  name="firstname" placeholder="First Name" required="required" type="text">
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="lastname">Last Name <span class="required">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
										  <input id="lastname" class="form-control col-md-7 col-xs-12"   name="lastname" placeholder="Last Name" required="required" type="text">
										</div>
									</div>
									<div class="form-group">
										<label for="othername" class="control-label col-md-3 col-sm-3 col-xs-12">Other Name / Initial</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
										  <input id="othername" class="form-control col-md-7 col-xs-12" type="text" name="othername">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Gender</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											Male: <input type="radio" class="flat" name="gender" id="genderM" value="M" checked="" required /> Female:
											<input type="radio" class="flat" name="gender" id="genderF" value="F" />
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-3">Date Of Birth</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
										  <input type="text" name="birthday" required="required"   class="form-control" data-inputmask="'mask': '99/99/9999'">
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Occupation <span class="required">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
										  <input id="occupation" type="text" name="occupation" data-validate-length-range="5,20" class="optional form-control col-md-7 col-xs-12">
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_type">ID Type <span class="required">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											National Id: <input type="radio" class="flat" name="id_type" id="national_id" value="national_id" checked="" required />Passport:
											<input type="radio" class="flat" name="id_type" id="" value="passport_no" />
											Driving Permit:
											<input type="radio" class="flat" name="id_type" id="driving_permit" value="driving_permit" />
											Residential Id:
											<input type="radio" class="flat" name="id_type" id="residential_id" value="residential_id" />
										
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_number">Id Number <span class="required">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
										  <input id="id_number" type="text" name="id_number" data-validate-length-range="5,20" class="optional form-control col-md-7 col-xs-12">
										</div>
									</div>
								</form>
							</div>
							<div id="step-2">
								<form class="form-horizontal form-label-left" novalidate>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-3">Mobile Telephone <span class="required">*</span></label>
										<div class="col-md-6 col-sm-6 col-xs-6">
										  <input required="required" type="text" name="phone" class="form-control" data-inputmask="'mask' : '(9999) 999-999'">
										  <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
										  <input type="email" id="email" name="email"  class="form-control col-md-7 col-xs-12">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Country</label>
										<div class="col-md-9 col-sm-9 col-xs-12">
										  <select class="select2_single form-control" id="country" name="country" tabindex="-1">
											<option value="Uganda">Uganda</option>
											<option value="Kenya">Kenya</option>
										  </select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" >District</label>
										<div class="col-md-9 col-sm-9 col-xs-12">
										  <select class="select2_single form-control" id="district" name="district" tabindex="-1">
											<option value="Uganda">Uganda</option>
											<option value="Kenya">Kenya</option>
										  </select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">County</label>
										<div class="col-md-9 col-sm-9 col-xs-12">
										  <select class="select2_single form-control" id="county" name="county" tabindex="-1">
											<option value="Uganda">Uganda</option>
											<option value="Kenya">Kenya</option>
										  </select>
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Sub Country</label>
										<div class="col-md-9 col-sm-9 col-xs-12">
										  <select class="select2_single form-control" id="subcounty" name="subcounty" tabindex="-1">
											<option value="Uganda">Uganda</option>
											<option value="Kenya">Kenya</option>
										  </select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Parish</label>
										<div class="col-md-9 col-sm-9 col-xs-12">
										  <select class="select2_single form-control" id="parish" name="parish" tabindex="-1">
											<option value="Uganda">Uganda</option>
											<option value="Kenya">Kenya</option>
										  </select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Village</label>
										<div class="col-md-9 col-sm-9 col-xs-12">
										  <select class="select2_single form-control" id="village" name="village" tabindex="-1">
											<option value="Uganda">Uganda</option>
											<option value="Kenya">Kenya</option>
										  </select>
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="physical_address">Physical Address<span class="required">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
										  <textarea id="physical_address" required="required" name="physical_address" class="form-control col-md-7 col-xs-12"></textarea>
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="postal_address">Postal Address
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
										  <textarea id="postal_address" required="required" name="postal_address" class="form-control col-md-7 col-xs-12"></textarea>
										</div>
									</div>
								</form>
							</div>
							<div id="step-3">
								<form class="form-horizontal form-label-left" novalidate>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Registration Branch</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
										  <input type="text" class="form-control" name="branch_number" value="<?php echo $_SESSION['branch_number']; ?>" readonly="readonly" placeholder="Read-Only Input">
										</div>
									</div>
									<div class="item form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Comments</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
										  <textarea id="textarea" required="required" name="comment" class="form-control col-md-7 col-xs-12"></textarea>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Registration Date</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
										 <?php echo date("j F, Y"); ?>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Registered By</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
										 <?php echo $logged_in_user; ?>
										</div>
										 <input type="hidden" class="form-control" name="added_by" value="<?php echo $_SESSION['user_id']; ?>" readonly="readonly" placeholder="Read-Only Input">
									</div>
									
								</form>
							</div>
						</div>
					<!-- End SmartWizard Content -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->

<?php 
include("includes/footer.php"); 
?>
  