<?php 
//This will prevent data tables js from showing on every page for speed increase
$show_table_js = true;
$page_title = "Income";
include("includes/header.php"); 
require_once("lib/Libraries.php");
$income = new Income();

?>
<?php if(isset($_SESSION['access_level'])&&in_array($_SESSION['access_level'],array(1,2))){?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
	<div class="clearfix"></div>
	
	<div class="row x_title">
	  <div class="col-md-4">
		<h3>Income <small></small></h3>
	  </div>
	  <div class="col-md-6">
		<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
		  <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
		  <span>November 20, 2016 - December 19, 2016</span> <b class="caret"></b>
		</div>
	  </div>
		<div class="col-md-2"><li><a class="btn btn-primary" data-toggle="modal" data-target=".member_modal"> <i class="fa fa-plus"></i> Receive Income</a></li></div>
		<div class="modal fade member_modal" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
					  </button>
					  <h4 class="modal-title" id="myModalLabel">Record Received Income</h4>
					</div>
					<div class="modal-body">
						<?php 
						include("add_income.php");
						?>
					</div>
				</div>
			</div>      
		</div>
	</div>

	<div class="row">
	  <div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
		  <div class="x_content">
			<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap">
				<thead>
					<tr>
						<?php 
						$header_keys = array("#", "Income Type", "Amount", "Description", "Date");
						foreach($header_keys as $key){ ?>
							<th><?php echo $key; ?></th>
							<?php 
						} ?>
					</tr>
				</thead>
				<tbody>
				</tbody>
				<tfoot>
					<tr>
						<th class="right_remove">Total (UGX)</th>
						<th class="right_remove left_remove"></th>
						<th class="right_remove left_remove"></th>
						<th class="right_remove left_remove" colspan="2"></th>
					</tr>
				</tfoot>
			</table>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</div>
<div class="clearfix"></div>
	 <div class="modal fade income_modal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
		  <div class="modal-content">

			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
			  </button>
			  <h4 class="modal-title" id="myModalLabel">Add  Income</h4>
			</div>
			<div class="modal-body">
				<?php 
				//include("add_income.php");
				?>
			</div>
		</div>
	  </div>      
	</div>
<!-- /page content -->
<?php } else {include("includes/error_400.php"); }?> 
<?php include("includes/footer.php"); ?>
<?php if(isset($_SESSION['access_level'])&&in_array($_SESSION['access_level'],array(1,2))){?>
<!-- Datatables -->
<script>
  $(document).ready(function() {
	var handleDataTableButtons = function() {
	  if ($("#datatable-buttons").length) {
		dTable = $('#datatable-buttons').DataTable({
		  dom: "Bfrtip",
		  "processing": true,
		  "serverSide": true,
		  "deferRender": true,
		  "order": [[ 1, 'asc' ]],
		  "ajax": {
			  "url":"server_processing.php",
			  "type": "POST",
			  "data":  function(d){
				d.page = 'view_income';
				d.start_date = getStartDate();
				d.end_date = getEndDate();
				}
		  },
		  "footerCallback": function (tfoot, data, start, end, display ) {
            var api = this.api(), total = api.column(2).data().sum();
			// UPDATE TOTALS //
            $(api.column(2).footer()).html( "<strong>" + format1(total) + "<strong>" );
		  },/* "columnDefs": [ {
			  "targets": [4],
			  "orderable": false,
			  "searchable": false
		  }], */
		  columns:[ { data: 'id'},
				{ data: 'name'},
				{ data: 'amount' },
				{ data: 'description'},
				{ data: 'date_added'}
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
		  responsive: true/*, */
		  
		});
		//$("#datatable-buttons").DataTable();
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
/* 
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
 */
	TableManageButtons.init();
  });
</script>
<?php }?> 