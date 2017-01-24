<?php 
//This will prevent data tables js from showing on every page for speed increase
$show_table_js = true;

$page_title = "Loans";
include("includes/header.php");

?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
	<div class="clearfix"></div>
	
	<div class="row x_title">
	  <div class="col-md-6">
		<h3>Loans <small>list</small></h3>
	  </div>
	  <div class="col-md-5">
		<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
		  <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
		  <span>November 20, 2016 - December 19, 2016</span> <b class="caret"></b>
		</div>
	  </div>
	  <div class="col-md-1">
		<a href="http://localhost/buladde/view_loans.php<?php echo (isset($_GET['type'])&&strlen($_GET['type'])>1)?"?type=".$_GET['type']:"";?>" class="btn btn-primary"><i class="fa fa-money"></i> All loans</a>
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
						$header_keys = array("Loan Number", "Client", "Loan Type", "Principal", "Interest", "Total PayBack","Loan Date","Duration", "Expected PayBack Date");
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
						<?php 
						foreach($header_keys as $key){ ?>
							<th><?php echo $key; ?></th>
							<?php
						}
						?>
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
<!-- /page content -->
<?php 
include("includes/footer.php"); 
?>
<!-- Datatables -->
<script>
	var dTable;
  $(document).ready(function() {
	var handleDataTableButtons = function() {
	  if ($("#datatable-buttons").length) {
		dTable = $('#datatable-buttons').DataTable({
		  dom: "Bfrtip",
		  "processing": true,
		  "serverSide": true,
		  "deferRender": true,
		  "ajax": {
			  "url":"server_processing.php",
			  "type": "POST",
			  "data":  function(d){
				d.page = 'view_loans';
				<?php echo isset($_GET['type'])?"d.type=".$_GET['type']:"";?>;
				d.start_date = getStartDate();
				d.end_date = getEndDate();
				}
		  },
		  columns:[ { data: 'loan_number', render: function ( data, type, full, meta ) {return '<a href="#" title="View details">'+data+'</a>';}},
				{ data: 'firstname', render: function ( data, type, full, meta ) {return full.firstname+' '+full.lastname+' '+full.othername;}},
				{ data: 'name'},
				{ data: 'loan_amount' , render: function ( data, type, full, meta ) {return format1(parseFloat(data));}},
				{ data: 'interest_rate', render: function ( data, type, full, meta ) {return data+'%';}},
				{ data: 'expected_payback', render: function ( data, type, full, meta ) {return format1(parseFloat(data));}},
				{ data: 'loan_date',  render: function ( data, type, full, meta ) {return moment(data, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM-DD');}},
				{ data: 'duration'},
				{ data: 'loan_end_date'}
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
	TableManageButtons.init();
  });
</script>