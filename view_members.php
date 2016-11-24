<?php 
//This will prevent data tables js from showing on every page for speed increase
$show_table_js = true;
include("includes/header.php"); 
require_once("lib/Libraries.php");
$member = new Member();
$person = new Person();
$all_members = array();
$found_member = array();
if(isset($_POST['person_number']) && $_POST['person_number'] != ""){
	$perons = $person->findByPersonNumber($_POST['person_number']);
	$found_member = $member->findByPersonIdNo($perons['id']);
}else{
	$all_members = $member->findAll();
}

?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
	<div class="page-title">
	  <div class="title_left">
		<h3>Members <small>All active members</small></h3>
	  </div>

	  <div class="title_right">
		<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
		<form method="post" action="" >
			<div class="input-group">
			
				<input type="text" name="person_number" class="form-control" placeholder="Search by person no...">
				<span class="input-group-btn">
				  <button class="btn btn-default" type="submit">Go!</button>
				</span>
			
			</div>
		  </form>
		</div>
	  </div>
	</div>

	<div class="clearfix"></div>

	<div class="row">
	  <div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
		  <div class="x_title">
			<h2>Members <small></small></h2>
			<ul class="nav navbar-right panel_toolbox">
			  <li><a class="btn btn-primary" data-toggle="modal" data-target=".member_modal"> <i class="fa fa-plus"></i> Add New Member</a></li></ul>
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">
			<table id="datatable-buttons" class="table table-striped table-bordered">
				<thead>
					<tr>
						<?php 
						$header_keys = array("Person Number", "Name", "Phone", "Date of Birth", "Subscription", "Shares Paid", "Total Savings", "Loans");
						foreach($header_keys as $key){ ?>
							<th><?php echo $key; ?></th>
							<?php
						}
						?>
					</tr>
				</thead>
				<tbody>
					<?php 
					if($all_members){
						foreach($all_members as $single){ 
							$person_data = $person->findById($single['person_number']);
							?>
							<tr>
							  <td><a href="member-details.php?member_id=<?php echo $single['id']; ?>"><?php echo $person_data['person_number']; ?></A></td>
							  <td><?php echo $person_data['firstname']." ".$person_data['othername']." ".$person_data['lastname']; ?></td>
							  <td><?php echo $person_data['phone'] ?></td>
							  <td><?php echo date("j F, Y", strtotime($person_data['dateofbirth'])); ?></td>
							  <td><?php   ?></td>
							  <td><?php  ?></td>
								<td><?php  ?></td>
								<td><?php  ?></td>
							</tr>
							<?php
						}
					}
					if($found_member){
						$person_data = $person->findById($found_member['person_number']);
						?>
						<tr>
						  <td><a href="member-details.php?member_id=<?php echo $found_member['id']; ?>"><?php echo $person_data['person_number']; ?></a></td>
						  <td><?php echo $person->Username($person_data['firstname'], $person_data['lastname'], $person_data['othername']); ?></td>
						  <td><?php echo $person_data['phone'] ?></td>
						  <td><?php echo date("j F, Y", strtotime($person_data['dateofbirth'])); ?></td>
						  <td><?php  if($found_member['member_type']== 1){ echo 'Member and Share Holder'; }else{ echo "Member"; } ?></td>
						  <td><?php echo date("j F, Y", strtotime($found_member['date_added'])) ?></td>
						  <td><?php  ?></td>
						  <td><button type="submit" class="btn btn-success">Edit</button><button type="submit" class="btn btn-danger">Delete</button></td>
						  
						</tr>
						<?php
					}
					?>
					
					<tr>
						<td class="right_remove"><b>Total (UGX)</b></td>
						<td class="right_remove left_remove"><?php  ?></td>
						<td class="right_remove left_remove"><?php  ?></td>
						<td class="right_remove left_remove"><?php  ?></td>
						<td class="right_remove left_remove"><?php  ?></td>
						<td class="right_remove left_remove"><?php  ?></td>
						<td class="right_remove left_remove"><?php  ?></td>
						<td ><?php  ?></td>
					</tr>
				</tbody>
			</table>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</div>
<div class="clearfix"></div>
	 <div class="modal fade member_modal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
		  <div class="modal-content">

			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
			  </button>
			  <h4 class="modal-title" id="myModalLabel">Add  New Member</h4>
			</div>
			<div class="modal-body">
				<?php 
				include("add_member.php");
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