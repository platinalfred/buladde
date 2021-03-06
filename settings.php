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

?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="x_panel">
	  <div class="x_title">
		<h2>Settings <small> - Manage system settings </small></h2>
		<ul class="nav navbar-right panel_toolbox">
		  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
		  </li>
		</ul>
		<div class="clearfix"></div>
	  </div>
	  <div class="x_content Settings" id="member-details ">
		<div class="row" >
		  <div class="col-md-12 col-sm-12 col-xs-12 form-group" style=" padding-top:10px;">
				<ul class="nav navbar-left panel_toolbox">
					<li><a href="?task=expensetype.add" class="btn btn-primary"><i class="fa fa-plus"></i> Add Expense Type</a> </li>
					<li><a href="?task=security_type.add" class="btn btn-primary"><i class="fa fa-plus"></i> Add Security Type</a> </li>
					<li><a href="?task=member_type.add" class="btn btn-primary"><i class="fa fa-plus"></i> Add Member Type</a> </li>
					<li><a href="?task=branch.add" class="btn btn-primary"><i class="fa fa-plus"></i> Add Branch</a></li>
					<!--<li><a href="?task=access_level.add" class="btn btn-primary"><i class="fa fa-plus"></i> Add Access Level</a></li>-->
					<li><a href="?task=income_sources.add" class="btn btn-primary"><i class="fa fa-plus"></i> Add Income Source</a></li>
					<li><a href="?task=loan_type.add" class="btn btn-primary"><i class="fa fa-plus"></i> Add Loan Type</a></li>
					<li><a href="?task=share_rate.edit" class="btn btn-primary"><i class="fa fa-plus"></i>Manage Share Rate</a></li>
					<!--li><a href="?task=loan_repayment_durarion.add" class="btn btn-primary"><i class="fa fa-plus"></i> Add Loan Repayment Duration</a></li-->
				</ul>
				<ul class="nav navbar-right panel_toolbox">
					<li><a href="?view=membertypes" class="btn btn-success"><i class="fa fa-folder-open-o"></i>Member Types </a></li>
					<li><a href="?view=expensetypes" class="btn btn-success"><i class="fa fa-folder-open-o"></i>Expense Types </a></li>
					<li><a href="?view=securitytypes" class="btn btn-success"><i class="fa fa-folder-open-o"></i>Security Types </a></li>
					<li><a href="?view=branches" class="btn btn-success"><i class="fa fa-folder-open-o"></i> Branches</a></li>
					<li><a href="?view=incomesources" class="btn btn-success"><i class="fa fa-folder-open-o"></i> Income Sources</a></li>
					<li><a href="?view=loantypes" class="btn btn-success"><i class="fa fa-folder-open-o"></i> Loan Types</a></li>
					<!--<li><a href="?view=viewshareratehistory" class="btn btn-success"><i class="fa fa-folder-open-o"></i> Share Rate Change History</a></li>-->
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
	}
	if(isset($_GET['view'])){
		$task = $_GET['view']; 
		$reports = new Reports($task);
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