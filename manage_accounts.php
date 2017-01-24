<?php 
//This will prevent data tables js from showing on every page for speed increase
$show_table_js = true;
include("includes/header.php"); 
?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
	<div class="page-title">
	  <div class="title_left">
		<h3>Accounts <small>manage accounts</small></h3>
	  </div>

	  <div class="title_right">
			<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
			  <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
			  <span>November 20, 2016 - December 19, 2016</span> <b class="caret"></b>
			</div>
	  </div>
	</div>

	<div class="clearfix"></div>

	<div class="row">
	  <div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
		  <div class="x_title">
			<h2>Deposits <small></small></h2>
			<ul class="nav navbar-right panel_toolbox">
			  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
			  </li>
			  <li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
				<ul class="dropdown-menu" role="menu">
				  <!--<li><a href="#">Settings 1</a>
				  </li>
				  <li><a href="#">Settings 2</a>
				  </li>-->
				</ul>
			  </li>
			  <!--<li><a class="close-link"><i class="fa fa-close"></i></a>-->
			  </li>
			</ul>
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">
			<table id="datatable-buttons2" class="table table-striped table-bordered">
				<thead>
					<tr>
						<?php 
						$header_keys = array("Person Number", "Names", "Date", "Amount");
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
						<td class="right_remove"><b>Total (UGX)</b></td>
						<td class="right_remove left_remove"><?php  ?></td>
						<td class="right_remove left_remove"><?php  ?></td>
						<td class="right_remove left_remove"><?php  ?></td>
					</tr>
				</tfoot>
			</table>
		  </div>
		</div>
	  </div>
	   <div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
		  <div class="x_title">
			<h2>Withdraws <small></small></h2>
			<ul class="nav navbar-right panel_toolbox">
			  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
			  </li>
			  <li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
				<ul class="dropdown-menu" role="menu">
				  <!--<li><a href="#">Settings 1</a>
				  </li>
				  <li><a href="#">Settings 2</a>
				  </li>-->
				</ul>
			  </li>
			  <!--<li><a class="close-link"><i class="fa fa-close"></i></a>-->
			  </li>
			</ul>
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">
			<table id="datatable-buttons" class="table table-striped table-bordered">
				<thead>
					<tr>
						<?php 
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
						<td class="right_remove"><b>Total (UGX)</b></td>
						<td class="right_remove left_remove"><?php  ?></td>
						<td class="right_remove left_remove"><?php  ?></td>
						<td class="right_remove left_remove"><?php  ?></td>
					</tr>
				</tfoot>
			</table>
		  </div>
		</div>
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
				d.page = 'deposits';
				d.start_date = getStartDate();
				d.end_date = getEndDate();
				}
		  },"columnDefs": [ {
			  "targets": [0],
			  "orderable": false
		  }],
		  columns:[ { data: 'person_number', render: function ( data, type, full, meta ) {return '<a href="member-details.php?member_id='+full.member_id+'" title="Update details">'+data+'</a>';}},
				{ data: 'firstname', render: function ( data, type, full, meta ) {return full.firstname + ' ' + full.othername + ' ' + full.lastname;}},
				{ data: 'transaction_date', render: function ( data, type, full, meta ) {return moment(data).format('LL');}},
				{ data: 'amount' }
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

	dTable2 = $('#datatable-buttons2').DataTable({
		  "processing": true,
		  "serverSide": true,
		  "deferRender": true,
		  "ajax": {
			  "url":"server_processing.php",
			  "type": "POST",
			  "data": function(d){
				d.page = 'withdraws';
				d.start_date = getStartDate();
				d.end_date = getEndDate();
				}
		  },"columnDefs": [ {
			  "targets": [0],
			  "orderable": false
		  }],
		  columns:[ { data: 'person_number', render: function ( data, type, full, meta ) {return '<a href="member-details.php?member_id='+full.member_id+'" title="Update details">'+data+'</a>';}},
				{ data: 'firstname', render: function ( data, type, full, meta ) {return full.firstname + ' ' + full.othername + ' ' + full.lastname;}},
				{ data: 'transaction_date', render: function ( data, type, full, meta ) {return moment(data).format('LL');}},
				{ data: 'amount' }
				] ,
	});
	dTable2.on('draw.dt', function() {
	  $('input').iCheck({
		checkboxClass: 'icheckbox_flat-green'
	  });
	});

	TableManageButtons.init();
  });
</script>