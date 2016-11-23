<?php 
//This will prevent data tables js from showing on every page for speed increase
$show_table_js = true;
include("includes/header.php"); 
require_once("lib/Libraries.php");
require_once("lib/Forms.php");
require_once("lib/Reports.php");
$member = new Member();
$person = new Person();
$locations = new Locations();
$all_members = array();
$found_member = array();
$names  = "";
if($_GET['member_id']){
	$member_data  = $member->findById($_GET['member_id']);
	$person_data = $person->findByid($member_data['person_number']);
	$names =  $person_data['firstname']." ". $person_data['lastname']." ".$person_data['othername']; 
}else{
	header("Location:view_members.php");
}

?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="x_panel">
	  <div class="x_title">
		<h2><?php echo $names; ?> <small> - <?php echo $person_data['person_number'];?> </small></h2>
		<ul class="nav navbar-right panel_toolbox">
		  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
		  </li>
		  
		  <li><a class="close-link"><i class="fa fa-close"></i></a>
		  </li>
		</ul>
		<div class="clearfix"></div>
	  </div>
	  <div class="x_content" id="member-details">
		<div class="row" >
		  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
			<?php  if($person_data['photograph'] !="" && file_exists($person_data['photograph'])){?> <img src="<?php echo $person_data['photograph']; ?>" style="width:100%;"><?php }else{?> <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus"></i> Add a Photograph</button> <?php } ?>
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
						<p class="p"><?php echo $locations->findDistrict($person_data["district"]); ?></p>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 details">
					<div class="col-md-3 col-sm-12 col-xs-12 form-group">
						<p class="lead" >County</p>
						<p class="p"><?php  echo  $locations->findCounty($person_data["county"]); ?></p>
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
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 form-group" style="border-top:1px solid #09A; padding-top:10px;">
				<ul class="nav navbar-left panel_toolbox">
				  <li><a href="?member_id=<?php echo  $_GET['member_id']; ?>&task=loan.add" class="btn btn-primary"><i class="fa fa-plus"></i> Add Loan</a> </li>
				<!--
				  <li><a href="?member_id=<?php //echo  $_GET['member_id']; ?>&task=repayment.add" class="btn btn-primary"><i class="fa fa-plus"></i> Loan Re-Payment</a></li> -->
				  <li><a href="?member_id=<?php echo  $_GET['member_id']; ?>&task=nok.add" class="btn btn-primary"><i class="fa fa-plus"></i></i> Add Next of Kin</a></li>
				  <li><a href="?member_id=<?php echo  $_GET['member_id']; ?>&task=deposit.add" class="btn btn-primary"><i class="fa fa-plus"></i> Deposit Saving</a></li>
				  <li><a href="?member_id=<?php echo  $_GET['member_id']; ?>&task=withdraw.add" class="btn btn-primary"><i class="fa fa-plus"></i> Withdraw</a></li>
				  <li><a href="?member_id=<?php echo  $_GET['member_id']; ?>&view=client_trasaction_history" class="btn btn-success"><i class="fa fa-folder-open-o"></i> Transaction History</a></li>
				  <li><a href="?member_id=<?php echo  $_GET['member_id']; ?>&view=client_loans" class="btn btn-success"><i class="fa fa-folder-open-o"></i> View Loans</a></li>
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