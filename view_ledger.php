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
		<h3>Ledger <small>Account</small></h3>
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
						include("add_imcome.php");
						?>
					</div>
				</div>
			</div>      
		</div>
	</div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Income <small>Account</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="income_account" class="table table-hover">
						<thead>
							<tr>
								<?php
								$header_keys = array("&nbsp;", "Dr", "Cr");
								foreach($header_keys as $key){ ?>
									<th><?php echo $key; ?></th>
									<?php 
								} ?>
							</tr>
						</thead>
						<tbody>
							<tr id="deposits">
								<th>Income</th><td id="income">xx</td><td></td>
							</tr>
							<tr>
								<th>Expenses</th><td></td><td id="expenses">xx</td>
							</tr>
						</tbody>
                    </table>
                  </div>
                </div>
              </div>
		</div>
	</div>
</div>
<!-- /page content -->
<?php } else {include("includes/error_400.php"); }?> 
<?php include("includes/footer.php"); ?>