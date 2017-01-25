<?php 
//This will prevent data tables js from showing on every page for speed increase
$show_table_js = true;
include("includes/header.php"); 
require_once("lib/Libraries.php");
$member = new Member();
$person = new Person();

?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">

	<div class="row">
	  <div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
		  <div class="x_title">
			<h2>Active Members <small></small></h2>
			<ul class="nav navbar-right panel_toolbox">
				<li>
					<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
						<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
						<span>November 20, 2016 - December 19, 2016</span> <b class="caret"></b>
					</div>
				</li>
			  <li><a class="btn btn-primary" data-toggle="modal" data-target=".member_modal"> <i class="fa fa-plus"></i> Add New Member</a></li>
			</ul>
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">
			<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap">
				<thead>
					<tr>
						<?php
						$header_keys = array("Person Number", "Name", "Phone", "Member since", "Subscription", "Shares", "Savings", "Loans");
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
						<th class="right_remove">Total</th>
						<th colspan="4"></th>
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
				d.page = 'view_members';
				d.start_date = getStartDate();
				d.end_date = getEndDate();
				}
		  },
		  "footerCallback": function (tfoot, data, start, end, display ) {
            var api = this.api(), cols = [5,6,7];
			//set the totals at the appropriate columns
			$.each(cols, function(index, value){
				total = api.column(value).data().sum();
				$(api.column(value).footer()).html( format1(total) );
			});
			
		  },
			"columnDefs": [ {
			  "targets": [0],
			  "orderable": false
		  }],
		  columns:[ { data: 'member_id', render: function ( data, type, full, meta ) {return '<a href="member-details.php?member_id='+data+'" title="Update details">'+full.person_number+'</a>';}},
				{ data: 'firstname', render: function ( data, type, full, meta ) {return full.firstname + ' ' + full.othername + ' ' + full.lastname;}},
				{ data: 'phone' },
				{ data: 'date_added', render: function ( data, type, full, meta ) {return moment(data).format('LL');}},
				{ data: 'member_type', render: function ( data, type, full, meta ) {return '<a href="member-details.php?member_id='+full.member_id+'&view=subscritions" title="View subscriptions">'+((data == 1)?"Member and Share Holder": "Member")+'</a>'; }},
				{ data: 'shares', render: function ( data, type, full, meta ) {return data>0?'<a href="member-details.php?member_id='+full.member_id+'&view=myshares" title="View shares">'+format1(data)+'</a>':0;} },
				{ data: 'savings', render: function ( data, type, full, meta ) {return data>0?'<a href="member-details.php?member_id='+full.member_id+'&view=savings" title="View savings">'+format1(data)+'</a>':0;} },
				{ data: 'loans', render: function ( data, type, full, meta ) {return data>0?'<a href="member-details.php?member_id='+full.member_id+'&view=client_loans" title="View loans">'+data+'</a>':0;}}
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