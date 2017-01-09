<?php 
$show_table_js = false;
include("includes/header.php"); 
require_once("lib/Member.php");
require_once("lib/Dashboard.php");
$member = new Member();
$dashboard = new Dashboard();
?>
<!-- page content -->
<div class="right_col" role="main">
	 <!-- top tiles -->
	  <div class="row tile_count">
		<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		  <span class="count_top"><i class="fa fa-user"></i> Total Members</span>
		  <div class="count"><a class="count dash_link" href="view_members.php" title="Details"><?php echo $member->noOfMembers(); ?></a></div>
		  <span class="count_bottom"><i class="green">4% </i> From last Week</span>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		  <span class="count_top"><i class="fa fa-money"></i> Total Paid Subscription</span>
		  <div class="count"><a class="count dash_link" href="view_subscriptions.php" title="Details"><?php echo $dashboard->getSumOfSubscriptions(); ?></a></div>
		  <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		  <span class="count_top"><i class="fa fa-money"></i> Total Shares</span>
		  <div><a class="count green dash_link" href="view_shares.php" title="Details"><?php echo $dashboard->getSumOfShares(); ?></a></div>
		  <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		  <span class="count_top"><i class="fa fa-money"></i> Total Active Loans</span>
		  <div class="count"><a class="dash_link" href="view_loans.php?type=3" title="Details"><?php echo $dashboard->totalActiveLoans(); ?></a></div>
		  <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		  <span class="count_top"><i class="fa fa-money"></i> Total Loan Repayment Collections</span>
		  <div class="count"><a href="view_loan_payments.php" class="dash_link" title="Details"><?php echo $dashboard->getCountOfLoanRepayments(); ?></a></div>
		  <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		  <span class="count_top"><i class="fa fa-money"></i> Total Due Loans</span>
		  <div class="count"><a href="view_loans.php?type=4" class="dash_link" title="Details"><?php //echo $dashboard->getCountOfDueLoans(); ?>100</a></div>
		  <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
		</div>
	  </div>
	  <!-- /top tiles -->

	    <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="dashboard_graph">
                <div class="row x_title">
                  <div class="col-md-6">
                    &nbsp;
                  </div>
                  <div class="col-md-6">
                    <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                      <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                      <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                    </div>
                  </div>
                </div>
              </div>
            </div>
		</div>
	    <div class="row"> <!-- Graphs -->
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="x_panel">

                <div class="x_title">
                    <h2>Transactions <small>summary</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                <div class="clearfix"></div>
                </div>
                  <div class="x_content">
                    <canvas id="barChart"></canvas>
                  </div>
              </div>
            </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Performance<small>Loans + Subscriptions</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <canvas id="lineChart"></canvas>
                  </div>
                </div>
              </div>
		</div>
	    <div class="row"><!-- row -->
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Non performing <small>loans</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="nploans" class="table table-hover">
                    </table>
					<p class="pull-right"><a href="view_loans.php?type=2" class="btn btn-info dash_link">View all...</a></p>
                  </div>
                </div>
              </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>NP&P Loans <small>Pie Chart</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <canvas id="pieChart"></canvas>
                  </div>
                </div>
              </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Performing loans <small>top 10</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="ploans" class="table table-hover">
                    </table>
					<p class="pull-right"><a href="view_loans.php?type=1" class="btn btn-info dash_link">View all...</a></p>
                  </div>
                </div>
              </div>
		</div>
	    <div class="row"><!-- row -->
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Income <small>top 10</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="income" class="table table-hover">
                    </table>
					<p class="pull-right"><a href="view_income.php" class="btn btn-info dash_link">View all...</a></p>
                  </div>
                </div>
              </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Expenses <small>top 10</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="expenses" class="table table-hover">
                    </table>
					<p class="pull-right"><a href="view_expenses.php" class="btn btn-info dash_link">View all...</a></p>
                  </div>
                </div>
              </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Active loans <small>top 10</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="actvloans" class="table table-hover">
                      <thead>
                    </table>
					<p class="pull-right"><a href="view_loans.php?type=3" class="btn btn-info dash_link">View all...</a></p>
                  </div>
                </div>
              </div>
		</div>
</div>
<br />

</div>
<!-- /page content -->
<?php 
include("includes/footer.php"); 
?>
  