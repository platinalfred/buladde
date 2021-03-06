<?php 
//This will prevent data tables js from showing on every page for speed increase
$show_table_js = true;
$page_title = "Member Subscriptions";
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
	  <div class="col-md-6">
		<h3>Member Subscriptions <small></small></h3>
	  </div>
	  <div class="col-md-6">
		<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
		  <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
		  <span>November 20, 2016 - December 19, 2016</span> <b class="caret"></b>
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
						$header_keys = array("Client", "Date", "Subscription Year", "Amount");
						foreach($header_keys as $key){ ?>
							<th><?php echo $key; ?></th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
				<tfoot>
					<tr>
						<th class="right_remove"><b>Total (UGX)</b></th>
						<th colspan="2" class="right_remove left_remove"></th>
						<th class="right_remove left_remove"></th>
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
<?php }else{  include("includes/error_400.php"); }?> 
<?php 
include("includes/footer.php"); 
?>
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
		  "ajax": {
			  "url":"server_processing.php",
			  "type": "POST",
			  "data": function(d){
				d.page = 'view_subcriptns';
				d.start_date = getStartDate();
				d.end_date = getEndDate();
				}
		  },
		  "footerCallback": function (tfoot, data, start, end, display ) {
            var api = this.api(), total = api.column(3).data().sum();
			// UPDATE TOTALS //
            $(api.column(3).footer()).html( format1(total) );
		  },
		  columns:[ { data: 'firstname', render: function ( data, type, full, meta ) {return '<a href="member-details.php?member_id='+full.person_number+'" title="Member details">' + full.firstname+' '+full.lastname+' '+full.othername + '</a>';}},
				{ data: 'subscription_year'},
				{ data: 'date_paid'},
				{ data: 'amount' , render: function ( data, type, full, meta ) {return format1(parseFloat(data));}}
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
<?php }?> 