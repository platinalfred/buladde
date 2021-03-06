<?php 
//This will prevent data tables js from showing on every page for speed increase
$show_table_js = true;
include("includes/header.php"); 
require_once("lib/Libraries.php");
require_once("lib/Forms.php");
$person = new Person();
$member = new Member();
$locations = new Locations();
$all_staff = array();
$found_member = array();
$member_details =  $member->personDetails($_GET['member_id']);
$branch = new Branch();
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="x_panel">
		<div class="x_title">
			<h2><a href="member-details.php?member_id=<?php echo $_GET['member_id']; ?>">Member Details </a> >> Update Member</h2>
			<ul class="nav navbar-right panel_toolbox">
			  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
			  </li>
			  
			</ul>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<!-- Smart Wizard -->
			<!--<p>This is a basic form wizard example that inherits the colors from the selected scheme.</p>-->
			<div id="" class="">
				<form class="form-horizontal form-label-left" novalidate>
					<div id="step-1">
						<input type="hidden" name="id" value="<?php echo $_GET['member_id']; ?>">
						<?php
						$type = "staff";
						$person_type = $staff->getfrec("persontype","id","name= '$type'","", "");
						$p_type = $person_type['id'];
						?>
						<input type="hidden" name="person_type" value="<?php echo $p_type;?>">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Person Number</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <input type="hidden" class="form-control" name="person_id" value="<?php echo $member_details['person_id']; ?>" readonly="readonly" placeholder="Read-Only Input">
							  <?php echo $member->findPersonsPersonNumber($member_details['person_id']); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Title</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <select class="form-control" name="title">
								<option <?php if($member_details['title'] == "Mr"){ echo "selected"; } ?> value="Mr" >Mr.</option>
								<option <?php if($member_details['title'] == "Mrs"){ echo "selected"; } ?> value="Mrs">Mrs.</option>
								<option <?php if($member_details['title'] == "Dr"){ echo "selected"; } ?> value="Dr">Dr.</option>
								<option <?php if($member_details['title'] == "Prof"){ echo "selected"; } ?> value="Prof">Prof.</option>
							  </select>
							</div>
						</div>
							
					</div>
					<div id="step-2">
						<div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="firstname">First Name <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <input id="firstname" class="form-control col-md-7 col-xs-12 required_f" value="<?php echo $member_details['firstname']; ?>"  name="firstname" placeholder="First Name" required="required" type="text">
							</div>
						</div>
						<div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="lastname">Last Name <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <input id="lastname" class="form-control col-md-7 col-xs-12 required_f"  value="<?php echo $member_details['lastname']; ?>"  name="lastname" placeholder="Last Name" required="required" type="text">
							</div>
						</div>
						<div class="form-group">
							<label for="othername" class="control-label col-md-3 col-sm-3 col-xs-12">Other Name / Initial</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <input id="othername" class="form-control col-md-7 col-xs-12 " type="text" value="<?php echo $member_details['othername']; ?>" name="othername">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Gender</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								Male: <input <?php if($member_details['gender'] == 1){ echo "checked"; } ?> type="radio" class="flat" name="gender" id="genderM" value="1" checked=""  /> Female:
								<input type="radio" <?php if($member_details['gender'] == 2){ echo "checked"; } ?> class="flat" name="gender" id="genderF" value="2" />
							</div>
						</div>
					
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-3">Date Of Birth <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <input type="text" name="dateofbirth" required="required" value="<?php echo date("d/m/Y", strtotime($member_details['dateofbirth'])); ?>" class="form-control required_f">
							</div>
						</div>
						<div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_type">ID Type <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								National Id: <input type="radio" <?php if($member_details['id_type'] == "driving_permit"){ echo "checked"; } ?> class="flat" name="id_type" id="national_id" value="national_id" checked="" required />Passport:
								<input type="radio" <?php if($member_details['id_type'] == "driving_permit"){ echo "checked"; } ?> class="flat" name="id_type" id="" value="passport_no" />
								Driving Permit:
								<input type="radio" <?php if($member_details['id_type'] == "driving_permit"){ echo "checked"; } ?>  class="flat" name="id_type" id="driving_permit" value="driving_permit" />
							</div>
						</div>
						<div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_number">Id Number <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <input id="id_number" type="text" value="<?php echo $member_details['id_number']; ?>"  name="id_number" data-validate-length-range="5,20" class="optional form-control col-md-7 col-xs-12 required_f">
							</div>
						</div>
					</div>
					<div id="step-3">
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-3">Mobile Telephone <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-6">
							  <input required="required" type="text" value="<?php echo $member_details['phone']; ?>" name="phone" class="form-control required_f" data-inputmask="'mask' : '9999-999-999'">
							  <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
							</div>
						</div>
						<div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <input type="email" id="email" value="<?php echo $member_details['email']; ?>" name="email" placeholder="info@buladde.or.ug" class="form-control col-md-7 col-xs-12">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Country</label>
							<div class="col-md-6 col-sm-6 col-xs-12" id="country">
								<?php	$staff->loadList("SELECT * FROM countries", "country", "id", "name", "country_select", $member_details['country']); ?>
							  
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
							  <textarea id="physical_address" required="required" name="physical_address" class="form-control col-md-7 col-xs-12"><?php echo $member_details['physical_address']; ?></textarea>
							</div>
						</div>
						<div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="postal_address">Postal Address
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <textarea id="postal_address" required="required" name="postal_address" class="form-control col-md-7 col-xs-12"><?php echo $member_details['postal_address']; ?></textarea>
							</div>
						</div>
						
					</div>
					<div id="step-4">
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Registration Branch</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <input type="hidden" class="form-control" name="branch_number" value="<?php echo $_SESSION['branch_id']; ?>" readonly="readonly" placeholder="Read-Only Input">
							  <?php echo $branch->findBranchName($_SESSION['branch_id']); ?>
							</div>
						</div>
						<div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Comments</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <textarea id="textarea" required="required" name="comment" class="form-control col-md-7 col-xs-12"><?php echo $member_details['comment']; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Date Updated</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							 <?php echo date("j F, Y"); ?>
							</div>
						</div>
						
						<input type="hidden" name="added_by" value="<?php echo $_SESSION['user_id'];?>">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<button type="button" class="btn btn-success center save_data">Save changes</button>
							</div>
						</div>
						
					</div>
				</div>
				<input type="hidden" name="update_member" value="update_member">
			</form>
		<!-- End SmartWizard Content -->
		</div>
	</div>
</div>
	
<!-- /page content -->
<?php 
include("includes/footer.php"); 
?>
<!-- Datatables -->
<script>

</script>