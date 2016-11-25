<?php 
//This will prevent data tables js from showing on every page for speed increase
$show_table_js = true;
include("includes/header.php"); 
require_once("lib/Libraries.php");
require_once("lib/Forms.php");
$member = new Member();
$person = new Person();
$locations = new Locations();
$all_members = array();
$found_member = array();
$names  = "";

$all_expenses = array();
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="x_panel">
	  <div class="x_title">
		<h2>Expenses <small> manage expenses </small></h2>
		<ul class="nav navbar-right panel_toolbox">
		  <li>
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".expense_modal">Add New Expense</button>
		  </li>
		  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
		  </li>
		  
		</ul>
		<div class="clearfix"></div>
	  </div>
	  <div class="x_content">
			<table id="datatable-buttons" class="table table-striped table-bordered">
				<thead>
					<tr>
						<?php 
						$header_keys = array("Expense Type", "Expensed Staff", "Amount", "Date of Expense", "Description");
						foreach($header_keys as $key){ ?>
							<th><?php echo $key; ?></th>
							<?php
						}
						?>
					</tr>
				</thead>
				<tbody>
					<?php 
					if($all_expenses){
						foreach($all_expenses as $single){ 
							$person_data = $person->findById($single['person_number']);
							?>
							<tr>
							  <td><a href="member-details.php?member_id=<?php echo $single['id']; ?>"><?php echo $person_data['person_number']; ?></A></td>
							  <td><?php echo $person->Username($person_data['firstname'], $person_data['lastname'], $person_data['othername']); ?></td>
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
					
					?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="clearfix"></div>
	 <div class="modal fade expense_modal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
		  <div class="modal-content">

			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
			  </button>
			  <h4 class="modal-title" id="myModalLabel">Add New Expense</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal form-label-left" novalidate>
					<input type="hidden" name="add_expense">
					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="expense_type">Expense Type<span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<?php $person->loadList("SELECT * FROM expensetypes", "expenses", "name", "id"); ?>
						</div>
					  </div>
					  <div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="staff">Staff <span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<select class="form-control" name="title">
								<?php 
								$all_staff = $person->queryData("SELECT p.firstname, p.lastname, p.id FROM staff s ,person p WHERE p.id = s.person_number");
								if($all_staff){
									foreach($all_staff as $single){ ?>
										<option value="<?php echo $single['id']; ?>" ><?php echo $single['firstname']."".$single['lastname']; ?></option>
										<?php
									}
								}
								?>
							</select>
						</div>
					  </div>
					  <div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="office_phone">Amount Used<span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <input type="number"  name="amount_used"  required="required"   class="form-control col-md-7 col-xs-12">
						</div>
					  </div>
					  <div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount_description">Description
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <textarea   name="amount_description"    class="form-control col-md-7 col-xs-12"></textarea>
						</div>
					  </div>
					  
					  <div class="ln_solid"></div>
					  <div class="form-group">
						<div class="col-md-6 col-md-offset-3">
						  <button type="submit" class="btn btn-primary">Cancel</button>
						  <button id="send" type="button" class="btn btn-success save_data">Submit</button>
						</div>
					  </div>
				</form>
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