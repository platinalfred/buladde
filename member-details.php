<?php 
//This will prevent data tables js from showing on every page for speed increase
$show_table_js = true;
require_once("lib/Libraries.php");
require_once("lib/Forms.php");
require_once("lib/Reports.php");
$member = new Member();
$person = new Person();
$locations = new Locations();
$accounts = new Accounts();
$all_members = array();
$found_member = array();
$names  = "";
$person_number  = "";

if(isset($_GET['p_id'])){
	$id = $member->findMemberIdByPersonIdNo($_GET['p_id']);
	$_GET['member_id'] = $id;
	$member_data  = $member->findById($_GET['member_id']);
	$person_data = $person->findByid($member_data['person_number']);
	$names =  $person_data['firstname']." ". $person_data['lastname']." ".$person_data['othername']; 
}else{
	if($_GET['member_id']){
		$member_data  = $member->findById($_GET['member_id']);
		$person_number = $member_data['person_number'];
		$person_data = $person->findByid($member_data['person_number']);
		$names =  $person_data['firstname']." ". $person_data['lastname']." ".$person_data['othername']; 
	}else{
		header("Location:view_members.php");
	}
}
$page_title = $names;
include("includes/header.php"); 

?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="x_panel">
	  <div class="x_title">
		<h2><?php echo $names; ?> <small> - <?php echo $person_data['person_number'];?> </small>   </h2> 	
		<ul class="nav navbar-right panel_toolbox">
		  <li> <a href="update-member-details.php?member_id=<?php echo $_GET['member_id']; ?>"  class="btn btn-primary" title="Edit Member"><i class="fa fa-edit"></i > Edit</a>
		  </li>
		  <li><a class="btn btn-danger member delete" id="<?php echo $_GET['member_id']; ?>_member" title="Delete <?php echo $names; ?> "><i class="fa fa-close"></i>Delete member</a>
		  </li>
		</ul>
		<div class="clearfix"></div>
	  </div>
	  
	  <div class="x_content" id="member-details">
		<div class="row" >
		  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
				<h2> A/C - <?php echo $accounts->findAccountNumberByPersonNumber($person_data['id']);?></h2>
				<?php  
				if($person_data['photograph'] !="" && file_exists($person_data['photograph'])){?> 
					<img style="width:100%; height:100%;" height="100%" src="<?php echo $person_data['photograph']; ?>" > <a  href="" type="button"  data-toggle="modal" data-target=".add_photo"><i class="fa fa-edit"></i> Change photo</a>
					<?php 
				}else{?>
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".add_photo"><i class="fa fa-plus"></i> Add a Photograph</button> <?php 
				} ?>
				<div class="modal fade add_photo" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
					  <div class="modal-content">
							<form method="post" action="photo_upload.php" id="photograph">
								<div class="modal-header">
								  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
								  </button>
								  <h4 class="modal-title" id="myModalLabel2">Add member photograph</h4>
								</div>
								<div class="modal-body">
									<input type="hidden" name="photo_upload" >
								  <input type="hidden" id="p_no" name="person_number" value="<?php echo $member_data['person_number']; ?>">
								  <input id="myFileInput" type="file" name="photograph" accept="image/*;capture=camera">
								</div>
								<div class="modal-footer">
								  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								  <button type="submit" class="btn btn-primary photo_upload">Upload a Photo</button>
								</div>
							</form>
							
					  </div>
					</div>
				</div>
		  </div>
		  <div class="col-md-10 col-sm-12 col-xs-12 form-group">
				<div class="col-md-12 col-sm-12 col-xs-12 details">
					<div class="col-md-3 col-sm-12 col-xs-12 form-group " >
						<p class="lead" style="">Branch</p>
						<p class="p"><?php  echo $member->findBranch($member_data['branch_number']); ?></p>
					</div>
					<div class="col-md-3 col-sm-12 col-xs-12 form-group " >
						<p class="lead">Gender</p>
						<p class="p"><?php echo $member->findGenger($person_data["gender"]); ?></p>
					</div>
					<div class="col-md-3 col-sm-12 col-xs-12 form-group ">
						<p class="lead" >Age of Client</p>
						<p class="p"><?php echo $member->findAge($person_data["dateofbirth"])." Years";?></p>
					</div>
					<div class="col-md-3 col-sm-12 col-xs-12 form-group">
						<p class="lead" >Mobile Phone</p>
						<p class="p"><?php echo $person_data["phone"]; ?></p>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 details">
					<div class="col-md-3 col-sm-12 col-xs-12 form-group ">
						<p class="lead">Email Address</p>
						<p class="p"><?php echo $person_data["email"]; ?></p>
					</div>
					<div class="col-md-3 col-sm-12 col-xs-12 form-group ">
						<p class="lead" >Physical  Address</p>
						<p class="p"><?php echo $person_data["physical_address"]; ?></p>
					</div>
					<div class="col-md-3 col-sm-12 col-xs-12 form-group ">
						<p class="lead">Postal Address</p>
						<p class="p"><?php echo $person_data["postal_address"]; ?></p>
					</div>
					<div class="col-md-3 col-sm-12 col-xs-12 form-group">
						<p class="lead" >District</p>
						<p class="p"><?php  echo $locations->findDistrict($person_data["district"]); ?></p>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 details">
					<div class="col-md-3 col-sm-12 col-xs-12 form-group">
						<p class="lead" >County</p>
						<p class="p"><?php echo  $locations->findCounty($person_data["county"]); ?></p>
					</div>
					<div class="col-md-3 col-sm-12 col-xs-12 form-group ">
						<p class="lead" >Sub County</p>
						<p class="p"><?php echo @$locations->findSubcounty(@$person_data["subcounty"]); ?></p>
					</div>
					<div class="col-md-3 col-sm-12 col-xs-12 form-group ">
						<p class="lead" >Parish</p>
						<p class="p"><?php echo @$locations->findParish(@$person_data["parish"]); ?></p>
					</div>
					<div class="col-md-3 col-sm-12 col-xs-12 form-group ">
						<p class="lead" >Village</p>
						<p class="p"><?php echo @$locations->findVillage(@$person_data["village"]); ?></p>
					</div>
				</div>
				<?php 
				
				$balance =  $accounts->findByAccountBalance($person_data['id']); 
				if($balance > 1){
					$minimum_amount = $accounts->findMinimumBalance();
					$available = $balance - $minimum_amount;
				}else{
					$available = 0;
				} ?>
				
				<div class="col-md-12 col-sm-12 col-xs-12 details">
					<div class="col-md-5 col-sm-12 col-xs-12 form-group">
						<p class="p"><b>Actual balance: <?php  echo number_format($balance,2,".",",");  ?> UGX</b></p>
					</div>
					<div class="col-md-5 col-sm-12 col-xs-12 form-group ">
						<p class="p"><b>Available Balance: <?php   echo number_format($available,2,".",","); ?>UGX</b></p>
					</div>
					
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 form-group" style="border-top:1px solid #09A; padding-top:10px;">
				<ul class="nav navbar-left panel_toolbox">
					<!--<li><a class="btn btn-primary" data-toggle="modal" data-target=".loan_application"> <i class="fa fa-plus"></i> Apply for Loan</a></li>
					<div class="modal fade loan_application" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-md">
							<div class="modal-content">
								<div class="modal-header">
								  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
								  </button>
								  <h4 class="modal-title" id="myModalLabel">Record Received Income</h4>
								</div>
								<div class="modal-body">
									<?php 
									//include("loan_application.php");
									?>
								</div>
							</div>
						</div>      
					</div> -->
		
				  <li><a href="?member_id=<?php echo  $_GET['member_id']; ?>&task=loan.add" class="btn btn-primary"><i class="fa fa-plus"></i> Record a Loan</a> </li>
				  <li><a href="?member_id=<?php echo  $_GET['member_id']; ?>&task=subscription.add" class="btn btn-primary"><i class="fa fa-plus"></i> Subscribe</a></li>
				  <li><a href="?member_id=<?php echo  $_GET['member_id']; ?>&task=shares.add" class="btn btn-primary"><i class="fa fa-plus"></i> Buy Shares</a></li>
				  <li><a href="?member_id=<?php echo  $_GET['member_id']; ?>&task=nok.add" class="btn btn-primary"><i class="fa fa-plus"></i></i> Add Next of Kin</a></li>
				  <li><a href="?member_id=<?php echo  $_GET['member_id']; ?>&task=deposit.add" class="btn btn-primary"><i class="fa fa-plus"></i> Deposit Saving</a></li>
				  <li><a href="?member_id=<?php echo  $_GET['member_id']; ?>&task=withdraw.add" class="btn btn-primary"><i class="fa fa-plus"></i> Withdraw</a></li>
				 
				 
				</ul>
				<ul class="nav navbar-right panel_toolbox">
				  <li><a href="?member_id=<?php echo  $_GET['member_id']; ?>&view=client_loans" class="btn btn-success"><i class="fa fa-folder-open-o"></i> View Loans</a></li>
				   <li><a href="?member_id=<?php echo  $_GET['member_id']; ?>&view=mysubscriptions" class="btn btn-success"><i class="fa fa-folder-open-o"></i>Subscriptions</a></li>
				  <li><a href="?member_id=<?php echo  $_GET['member_id']; ?>&view=myshares" class="btn btn-success"><i class="fa fa-folder-open-o"></i>My Shares</a></li>
				  <li><a href="?member_id=<?php echo  $_GET['member_id']; ?>&view=nok" class="btn btn-success"><i class="fa fa-folder-open-o"></i>Next of kin details</a></li>
				  <li><a href="?member_id=<?php echo  $_GET['member_id']; ?>&view=mysavings" class="btn btn-success"><i class="fa fa-folder-open-o"></i>My savings</a></li>
				   <li><a href="?member_id=<?php echo  $_GET['member_id']; ?>&view=ledger" class="btn btn-success"><i class="fa fa-folder-open-o"></i> Ledger</a></li>
				   <li><a href="?member_id=<?php echo  $_GET['member_id']; ?>&view=client_trasaction_history" class="btn btn-success"><i class="fa fa-folder-open-o"></i> Transaction History</a></li>
				</ul>
			</div>
		  </div>
	  </div>
	</div>
	<div class="clearfix"></div>
	<?php 
	if(isset($_GET['task'])){
		$task = $_GET['task']; 
		$forms = new Forms($task);
	}elseif(isset($_GET['view'])){
		$view = $_GET['view'];
		$reports = new Reports($view);
	}
	?>
</div>
<!-- /page content -->
<?php 
include("includes/footer.php"); 
?>
<!-- Datatables -->
<script>
  $(document).ready(function() {
	var handleDataTableButtons = function() {
	  if ($("#datatable-buttons").length) {
		$("#datatable-buttons").DataTable({
		  dom: "Bfrtip",
		  buttons: [
			{
			  extend: "copy",
			  className: "btn-sm"
			},
			{
			  extend: "csv",
			  className: "btn-sm"
			},
			{
			  extend: "excel",
			  className: "btn-sm"
			},
			{
			  extend: "pdfHtml5",
			  className: "btn-sm"
			},
			{
			  extend: "print",
			  className: "btn-sm"
			},
		  ],
		  responsive: true,
		  
		});
	  }
	};

	TableManageButtons = function() {
	  "use strict";
	  return {
		init: function() {
		  handleDataTableButtons();
		}
	  };
	}();

	

	var $datatable = $('#datatable-checkbox');

	$datatable.dataTable({
	  'order': [[ 1, 'asc' ]],
	  'columnDefs': [
		{ orderable: false, targets: [0] }
	  ]
	});
	$datatable.on('draw.dt', function() {
	  $('input').iCheck({
		checkboxClass: 'icheckbox_flat-green'
	  });
	});

	TableManageButtons.init();
  });
</script>