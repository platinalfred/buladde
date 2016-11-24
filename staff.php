<?php 
//This will prevent data tables js from showing on every page for speed increase
$show_table_js = true;
include("includes/header.php"); 
require_once("lib/Libraries.php");
require_once("lib/Forms.php");
$person = new Person();
$staff = new Staff();
$locations = new Locations();
$all_staff = array();
$found_member = array();
$names  = "";

$all_staff =  $staff->findAll();

?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="x_panel">
	  <div class="x_title">
		<h2>Staff <small> manage staff </small></h2>
		<ul class="nav navbar-right panel_toolbox">
			<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
		  </li>
		  <li>
			<a href="#" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".staff_modal"><i class="fa fa-plus"></i> Add </a>
		  </li>
		  <li>
			<a href="#" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i> Edit </a>
		  </li>
		   <li>
			<a href="#" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
		  </li>
		   
		</ul>
		<div class="clearfix"></div>
	  </div>
	  <div class="x_content">
			<table id="datatable-buttons" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th></th>
						<?php 
						
						$header_keys = array("Person Number", "Name", "Position","Date of Birth", "Branch", "Photograph");
						foreach($header_keys as $key){ ?>
							
							<th><?php echo $key; ?></th>
							<?php
						}
						?>
					</tr>
				</thead>
				<tbody>
					<?php 
					if($all_staff){
						foreach($all_staff as $single){ 
							$person_data = $person->findById($single['person_number']);
							?>
							<tr>
								<td><input type="checkbox" class="flat" name="table_records"></td>
							  <td><a href="" ><?php echo $person_data['person_number']; ?></A></td>
							  <td><?php echo $person->combineNames($person_data); ?></td>
							  <td><?php echo $person_data['phone'] ?></td>
							  <td><?php echo date("j F, Y", strtotime($person_data['dateofbirth'])); ?></td>
							  <td><?php  echo $person->findBranchByBranchNo($single['branch_number']);  ?></td>
							  <td>
								<?php 
								if($person_data['photograph'] != "" && file_exists($person_data['photograph'])){ ?>
									<img src="<?php echo $person_data['photograph'];?>"/> <?php 
								}else{ ?> 
									<a href="#" class="btn btn-danger"><i class="fa fa-picture-o"> Add photo</i></a> <?php 
								} ?>
							  </td>
							  
							</tr>
							<?php
						}
					}
					
					?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="clearfix"></div>
	 <div class="modal fade staff_modal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
		  <div class="modal-content">

			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
			  </button>
			  <h4 class="modal-title" id="myModalLabel">Add  Staff Member</h4>
			</div>
			<div class="modal-body">
				<?php 
				include("add_staff.php");
				?>
			</div>
		</div>
	  </div>      
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