 <!-- page content -->
<div class="" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
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
								<input type="hidden" name="person_type" value="1">
								<?php
								$type = "member";
								$person_type = $member->getfrec("persontype","id","name= '$type'","", "");
								$p_type = $person_type['id'];
								?>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">Member Type</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<?php	$member->loadList("SELECT * FROM membertype", "member_type", "id", "name", "member_type"); ?>
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
									  <input id="firstname" class="form-control col-md-7 col-xs-12 required_f"  name="firstname" placeholder="First Name" required="required" type="text">
									</div>
								</div>
								<div class="item form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="lastname">Last Name <span class="required">*</span>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
									  <input id="lastname" class="form-control col-md-7 col-xs-12 required_f"   name="lastname" placeholder="Last Name" required="required" type="text">
									</div>
								</div>
								<div class="form-group">
									<label for="othername" class="control-label col-md-3 col-sm-3 col-xs-12">Other Name / Initial</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
									  <input id="othername" class="form-control col-md-7 col-xs-12 " type="text" name="othername">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">Gender</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										Male: <input type="radio" class="flat" name="gender" id="genderM" value="M" checked=""  /> Female:
										<input type="radio" class="flat" name="gender" id="genderF" value="F" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-3">Date Of Birth<br/>(day/month/year)</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
									  <input type="text" name="dateofbirth" required="required"   class="form-control required_f" data-inputmask="'mask': '99/99/9999'">
									</div>
								</div>
								<div class="item form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Occupation <span class="required">*</span>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
									  <input id="occupation" type="text" name="occupation" data-validate-length-range="5,20" class="optional form-control col-md-7 col-xs-12 required_f">
									</div>
								</div>
								<div class="item form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_type">ID Type <span class="required">*</span>
									</label>
									<div class="col-md-7 col-sm-7 col-xs-12">
										National Id: <input type="radio" class="flat" name="id_type" id="national_id" value="national_id" checked="" required />Passport:
										<input type="radio" class="flat" name="id_type" id="" value="passport_no" />
										Driving Permit:
										<input type="radio" class="flat" name="id_type" id="driving_permit" value="driving_permit" />
										Residential:
										<input type="radio" class="flat" name="id_type" id="residential_id" value="residential_id" />
									
									</div>
								</div>
								<div class="item form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_number">Id Number <span class="required">*</span>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
									  <input id="id_number" type="text" name="id_number" required="required" class="optional form-control col-md-7 col-xs-12 required_f">
									</div>
								</div>
							</form>
						</div>
						<div id="step-2">
							<form class="form-horizontal form-label-left" novalidate>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-3">Mobile Telephone <span class="required">*</span></label>
									<div class="col-md-6 col-sm-6 col-xs-6">
									  <input required="required" type="text" name="phone" class="form-control required_f" data-inputmask="'mask' : '9999 999-999'">
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
									<div class="col-md-6 col-sm-6 col-xs-12" id="country">
										<?php	$member->loadList("SELECT * FROM countries", "country", "id", "name", "country_select"); ?>
									  
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" >District</label>
									<div class="col-md-6 col-sm-6 col-xs-12" id="district">
									  
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">County</label>
									<div class="col-md-6 col-sm-6 col-xs-12"   id="county">
									  
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">Sub Country</label>
									<div class="col-md-6 col-sm-6 col-xs-12" id="subcounty">
									  <select class="select2_single form-control"  id="subcounty_select" name="subcounty" tabindex="-1">
										
									  </select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">Parish</label>
									<div class="col-md-6 col-sm-6 col-xs-12" id="parish">
									  <select class="select2_single form-control" id="parish_select"  name="parish" tabindex="-1">
									  </select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">Village</label>
									<div class="col-md-6 col-sm-6 col-xs-12" id="village">
									  
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
									  <input type="hidden" class="form-control" name="branch_id" value="<?php echo $_SESSION['branch_id']; ?>" readonly="readonly" placeholder="Read-Only Input">
									  <?php echo $branch->findBranchName($_SESSION['branch_id']); ?>
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
									 <?php echo $member->findMemberNames($_SESSION['person_id']); ?>
									</div>
									 <input type="hidden" class="form-control" name="registered_by" value="<?php echo $_SESSION['person_id']; ?>" readonly="readonly" placeholder="Read-Only Input">
								</div>
								<input type="hidden" name="added_by" value="<?php echo $_SESSION['person_id'];?>">
							</form>
						</div>
					</div>
				<!-- End SmartWizard Content -->
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->

<?php 
//include("includes/footer.php"); 
?>
  