<?php 
//This will prevent data tables js from showing on every page for speed increase
$show_table_js = true;
include("includes/header.php"); 
require_once("lib/Libraries.php");
require_once("lib/Forms.php");
$person = new Person();
$staff = new Staff();
$locations = new Locations();
$branch = new Branch();
$all_staff = array();
$found_member = array();
$names  = "";

$all_staff =  $staff->findAllActive();

?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="x_panel">
	  <div class="x_title">
		<h2>Staff <small> manage staff </small></h2>
		<ul class="nav navbar-right panel_toolbox">
			<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
		  </li>
		  <li>
			<a href="#" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".staff_modal"><i class="fa fa-plus"></i> Add New Staff</a>
		  </li>
		</ul>
		<div class="clearfix"></div>
	  </div>
	  <div class="x_content">
			<table id="datatable-buttons" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th></th>
						<?php 
						
						$header_keys = array("Person Number", "Name", "Position","Phone", "Date of Birth", "Branch", "Action");
						foreach($header_keys as $key){ ?>
							
							<th><?php echo $key; ?></th>
							<?php
						}
						?>
					</tr>
				</thead>
				<tbody>
					<?php 
					if($all_staff){
						foreach($all_staff as $single){ 
							$person_data = $person->findById($single['person_id']);
							?>
							<tr>
								<td><input type="checkbox" class="flat" name="table_records"></td>
								<td><a href="update_staff.php?id=<?php echo $single['id']; ?>" ><?php echo $person_data['person_number']; ?></a></td>
								<td><?php echo $person->combineNames($person_data); ?></td>
								<td><?php $p = $person->getfrec("position", "name", "id=".$single['position_id'], "", ""); echo $p['name']; ?></td>
								<td><?php echo $person_data['phone'] ?></td>
								<td><?php echo date("j F, Y", strtotime($person_data['dateofbirth'])); ?></td>
								<td><?php  echo $branch->findBranchName($single['branch_id']);  ?></td>
						  <td>
								<a href="update_staff.php?id=<?php echo $single['id']; ?>" class="btn btn-success" id="<?php echo $single['id']; ?>" ><i class="fa fa-edit" > Edit</i></a>
								<a href="#" class="btn btn-danger delete" id="<?php echo $person_data['id']; ?>_staff" ><i class="fa fa-trash-o"></i> Delete </a>
						  </td>
							 
							  
							</tr>
							<?php
						}
					}
					
					?>
				</tbody>
			</table>
			
		</div>
	</div>
</div>
<div class="clearfix"></div>
	 <div class="modal fade staff_modal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
		  <div class="modal-content">

			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
			  </button>
			  <h4 class="modal-title" id="myModalLabel">Add  Staff Member</h4>
			</div>
			<div class="modal-body">
				<?php 
				include("add_staff.php");
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
	$('#edit-modal').on('show.bs.modal', function(e) {
        var $modal = $(this);
        id_ = e.relatedTarget.id;
        $.ajax({
            cache: false,
            type: 'POST',
            url: 'update_staff.php',
            data: 'id='+id_,
            success: function(data) {
                $modal.find('.edit-content').html(data);
            }
        });
    })
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