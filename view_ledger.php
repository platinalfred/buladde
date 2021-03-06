<?php 
//This will prevent data tables js from showing on every page for speed increase
$show_table_js = true;
$page_title = "Income Statement";
include("includes/header.php");
?>
<?php if(isset($_SESSION['access_level'])&&in_array($_SESSION['access_level'],array(1,2))){?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
	<div class="clearfix"></div>
	
	<div class="row x_title">
	  <div class="col-md-6">
		<h3>Income <small>Statement</small></h3>
	  </div>
	  <div class="col-md-6">
		<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
		  <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
		  <span>November 20, 2016 - December 19, 2016</span> <b class="caret"></b>
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
                    <table id="income_account" class="table table-hover table-condensed table-bordered">
						<thead>
							<tr>
								<th>REVENUES & GAINS</th>
								<th>UGX</th>
							</tr>
						</thead>
						<tbody id="ledger">
							<tr>
								<td>Shares</td><td id="shares">xx</td>
							</tr>
							<tr>
								<td>Subscriptions</td><td id="subscriptions">xx</td>
							</tr>
							<tr>
								<td>Interest from Loans</td><td id="loan_income">xx</td>
							</tr>
							<tr>
								<th>Total Revenues & Gains</th><td><strong id="total_revenue">0</strong></td>
							</tr>
							<!--tr>
								<th>Deposits</th><td id="depositss">xx</td>
							</tr>
							<tr>
								<th>Withdraws</th><td id="withdraws">xx</td>
							</tr-->
							<tr>
								<th colspan="2">&nbsp;</th>
							</tr>
							<tr>
								<th colspan="2">EXPENSES & LOSSES</th>
							</tr>
							<tr>
								<td>Losses from bad loans</td><td id="bad_loans">0</td>
							</tr>
							<tr>
								<td>Other Expenses</td><td id="other_expenses">0</td>
							</tr>
							<tr>
								<th>Total Expenses & Losses</th><td><strong id="total_expenses">0</strong></td>
							</tr>
							<tr>
								<th colspan="2">&nbsp;</th>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<th>NET INCOME</th><td><strong id="net_income">0</strong></td>
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
<?php } else {include("includes/error_400.php"); }?> 
<?php include("includes/footer.php"); ?>