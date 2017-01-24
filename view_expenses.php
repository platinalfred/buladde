<?php 
//This will prevent data tables js from showing on every page for speed increase
$show_table_js = true;
require_once("lib/Libraries.php");
require_once("lib/Forms.php");
$expense = new Expenses();
$person = new Person();

$page_title = "Expenses";
include("includes/header.php"); 
$all_expenses = array();
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="x_panel">
	  <div class="x_title">
		<h2>Expenses <small> manage expenses </small></h2>
		<ul class="nav navbar-right panel_toolbox">
		  <li>
			<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
			  <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
			  <span>November 20, 2016 - December 19, 2016</span> <b class="caret"></b>
			</div>
		  </li>
		  <li>
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".expense_modal"><i class="fa fa-plus"></i> Add New Expense</button>
		  </li>
		</ul>
		<div class="clearfix"></div>
	  </div>
	  <div class="x_content">
			<table id="datatable-buttons" class="table table-striped table-bordered">
				<thead>
					<tr>
						<?php 
						$header_keys = array("Expense No", "Expense Type", "Expensed Staff", "Amount", "Description", "Date of Expense");
						foreach($header_keys as $key){ ?>
							<th><?php echo $key; ?></th>
							<?php
						}
						?>
					</tr>
				</thead>
				<tbody>
				</tbody>
				<tfoot>
					<tr>
						<th class="right_remove">Total (UGX)</th>
						<th colspan="2" class="right_remove left_remove"></th>
						<th class="right_remove left_remove"></th>
						<th colspan="2" class="right_remove left_remove"></th>
					</tr>
				</tfoot>
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
							<?php $person->loadList("SELECT * FROM expensetypes", "expense_type", "name", "id"); ?>
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
										<option value="<?php echo $single['id']; ?>" ><?php echo $single['firstname']." ".$single['lastname']; ?></option>
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
		dTable = $("#datatable-buttons").DataTable({
		  dom: "Bfrtip",
		  "processing": true,
		  "serverSide": true,
		  "deferRender": true,
		  "ajax": {
			  "url":"server_processing.php",
			  "type": "POST",
			  "data": function(d){
				d.page = 'view_expenses';
				d.start_date = getStartDate();
				d.end_date = getEndDate();
				}
		  },
		  "footerCallback": function (tfoot, data, start, end, display ) {
            var api = this.api(), total = api.column(3).data().sum();
			// UPDATE FOOTER //
            $(api.column(3).footer()).html( format1(total) );
		  },"columnDefs": [ {
			  "targets": [0],
			  "orderable": false
		  }],
		  columns:[ { data: 'id', render: function ( data, type, full, meta ) {return '<a href="expense-details.php?expense_id='+data+'" title="Update details">'+data+'</a>';}},
				{ data: 'name'},
				{ data: 'firstname', render: function ( data, type, full, meta ) {return full.firstname + ' ' + full.othername + ' ' + full.lastname;}},
				{ data: 'date_of_expense', render: function ( data, type, full, meta ) {return moment(data).format('LL');}},
				{ data: 'amount_used' , render: function ( data, type, full, meta ) {return format1(parseFloat(data));}},
				{ data: 'amount_description'}
				] ,
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

	TableManageButtons.init();
  });
</script>