<?php 
//This will prevent data tables js from showing on every page for speed increase
$show_table_js = true;

$page_title = "Members savings";
include("includes/header.php"); 
require_once("lib/Libraries.php");
?>
<?php if(isset($_SESSION['access_level'])&&in_array($_SESSION['access_level'],array(1,2))){?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
	<div class="row">
	  <div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
		  <div class="x_title">
			  <div class="col-md-6">
				<h2>Members <small>savings</small></h2>
			  </div>
			  <div class="col-md-6">
				<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
				  <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
				  <span>November 20, 2016 - December 19, 2016</span> <b class="caret"></b>
				</div>
			  </div>
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">
			<table id="member-savings" class="table table-striped table-bordered jambo_table">
				<thead>
					<tr>
						<?php 
						$header_keys = array("Date", "Client No.", "Client", "Account No.", "Deposit", "Withdraw", "Balance");
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
						<th class="right_remove" colspan="4"><b>Total (UGX)</b></th>
						<th class="right_remove left_remove"></th>
						<th class="right_remove left_remove"></th>
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
<?php } else {include("includes/error_400.php"); }?>
<?php include("includes/footer.php"); ?>
<?php if(isset($_SESSION['access_level'])&&in_array($_SESSION['access_level'],array(1,2))){?>
<!-- Datatables -->
<script>
  $(document).ready(function() {
	var handleDataTableButtons = function() {
	  if ($("#member-savings").length) {
		  dTable = $('#member-savings').DataTable({
		  dom: "Bfrtip",
		  "order": [[ 0, 'desc' ]],
		  columnDefs: [
				//{ targets: [0, 1], visible: true},
				{ targets: '_all', orderable: false }
			],
		  "ajax": {
			  "url":"ajax_data.php",
			  "type": "POST",
			  "data":  function(d){
				d.origin = 'client_savings';
				d.start_date = getStartDate();
				d.end_date = getEndDate();
				}
		  },
		  "footerCallback": function (tfoot, data, start, end, display ) {
			//the closing balance (according to the json data returned) is found in the last cell of the last row of data
			//find that cell and display in the bal c/f
			//
			var api = this.api();
			$(api.column(6).footer()).html( format1(parseFloat(api.cell(api.row( ':last' ).index(), api.column( ':last' ).index()).data())) );
		  },
		  columns:[ { data: 'transaction_date'},
				{ data: 'person_number', render: function ( data, type, full, meta ) {return '<a href="member-details.php?member_id='+full.member_id+'&view=mysavings" title="View member savings">'+data+'</a>';}},
				{ data: 'names'},
				{ data: 'account_number' },
				{ data: 'deposit', render: function ( data, type, full, meta ) {if(parseInt(data)>0){return format1(data);}},"defaultContent": "-"},
				{ data: 'withdraw', render: function ( data, type, full, meta ) {if(parseFloat(data)<0){return "("+format1(parseFloat(data)*-1)+")"};},"defaultContent": "-"},
				{ data: 'balance', render: function ( data, type, full, meta ) {return (parseInt(data)<0)?"("+format1(parseFloat(data)*-1)+")":format1(data);}, "defaultContent": "0"}
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
		  responsive: true
		  
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