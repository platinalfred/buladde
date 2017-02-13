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
	  <div class="col-md-5">
		<h3>Loans <small>list</small></h3>
	  </div>
	  <div class="col-md-5">
		<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
		  <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
		  <span>November 20, 2016 - December 19, 2016</span> <b class="caret"></b>
		</div>
	  </div>
	  <div class="col-md-2">
		<select id="loan_types" class="form-control">
		  <option>All loans</option>
		  <option value="1" <?php echo (isset($_GET['type'])&&$_GET['type']==1)?"selected":"";?>>Performing loans</option>
		  <option value="2" <?php echo (isset($_GET['type'])&&$_GET['type']==2)?"selected":"";?>> Non Performing</option>
		  <option value="3" <?php echo (isset($_GET['type'])&&$_GET['type']==3)?"selected":"";?>> Active loans</option>
		  <option value="4" <?php echo (isset($_GET['type'])&&$_GET['type']==4)?"selected":"";?>> Due loans</option>
		</select>
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
						$header_keys = array("Loan Number", "Client", "Principal", "Interest", "Total","Default","Paid","Loan Date","Duration", "Loan Type", "Expected PayBack Date");
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
						<th colspan="2">Total (UGX)</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
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
	$(document).ready(function() {
	var handleDataTableButtons = function() {
	  if ($("#datatable-buttons").length) {
		dTable = $('#datatable-buttons').DataTable({
		  dom: "Bfrtip",
		  "order": [ /* [6, 'desc' ],[4, 'desc' ], */[7, 'desc' ]],
		  "processing": true,
		  "serverSide": true,
		  "deferRender": true,
		  "ajax": {
			  "url":"server_processing.php",
			  "type": "POST",
			  "data":  function(d){
				d.page = 'view_loans';
				d.type = getLoanType();
				d.start_date = getStartDate();
				d.end_date = getEndDate();
				}
		  },
		  "footerCallback": function (tfoot, data, start, end, display ) {
            var api = this.api(), cols = [2,3,4,5,6];
			$.each(cols, function(key, val){
				var total = api.column(val).data().sum();
				$(api.column(val).footer()).html( format1(total) );
			});
		  },columns:[ { data: 'loan_number', render: function ( data, type, full, meta ) {return '<a href="member-details.php?member_id='+full.member_id+'&view=client_loan&lid='+full.id+'" title="View details">'+data+'</a>';}},
				{ data: 'firstname', render: function ( data, type, full, meta ) {return full.firstname+' '+full.lastname+' '+full.othername;}},
				{ data: 'loan_amount' , render: function ( data, type, full, meta ) {return format1(parseInt(data));}},
				{ data: 'interest', render: function ( data, type, full, meta ) {return format1(data);}},
				{ data: 'expected_payback', render: function ( data, type, full, meta ) {return format1(parseInt(data));}},
				{ data: 'def_days', render: function ( data, type, full, meta ) {return format1(parseInt(parseInt(data)*parseInt(full.daily_default_amount)/100*parseInt(full.expected_payback)));}},
				{ data: 'amount_paid', render: function ( data, type, full, meta ) {return format1(parseInt(data));}},
				{ data: 'loan_date',  render: function ( data, type, full, meta ) {return moment(data, 'YYYY-MM-DD hh:mm:ss').format('DD-MMM-YYYY');}},
				{ data: 'duration'},
				{ data: 'name'},
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