<?php 
$show_table_js = false;
$page_title = "Dashboard";
include("includes/header.php");
?>

<?php if(isset($_SESSION['access_level'])&&in_array($_SESSION['access_level'],array(1,2))){?>
<!-- page content -->
<div class="right_col" role="main">
	 <!-- top tiles -->
	  <div class="row tile_count">
		<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		  <span class="count_top"><i class="fa fa-user"></i> Profit</span>
		  <div class="count"><a class="count green dash_link" href="view_members.php" title="Details" id="profit_fig">0</a></div>
		  <span class="count_bottom"><i class="green fa fa-sort-asc" id="members_percent">0% </i></span>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		  <span class="count_top"><i class="fa fa-user"></i> Income</span>
		  <div class="count"><a class="count green dash_link" href="view_members.php" title="Details" id="income_fig">0</a></div>
		  <span class="count_bottom"><i class="green fa fa-sort-asc" id="members_percent">0% </i></span>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		  <span class="count_top"><i class="fa fa-money"></i> Shares</span>
		  <div><a class="count green dash_link" href="view_shares.php" title="Details" id="total_shares">0</a></div>
		  <span class="count_bottom"><i class="green fa fa-sort-asc" id="shares_percent">0% </i></span>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		  <span class="count_top"><i class="fa fa-money"></i> Deposits</span>
		  <div><a class="count green dash_link" href="view_member_savings.php" title="Details" id="deposits">0</a></div>
		  <span class="count_bottom"><i class="green fa fa-sort-asc" id="deposits_percent">0% </i></span>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		  <span class="count_top"><i class="fa fa-money"></i> Withdrawals</span>
		  <div><a class="count green dash_link" href="view_member_savings.php" title="Details" id="withdraws">0</a></div>
		  <span class="count_bottom"><i class="green fa fa-sort-asc" id="withdraws_percent">0% </i></span>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		  <span class="count_top"><i class="fa fa-money"></i> Loan Payments</span>
		  <div class="count"><a href="view_loan_payments.php" class="count green dash_link" title="Details" id="loan_payments">0</a></div>
		  <span class="count_bottom"><i class="green fa fa-sort-asc" id="loan_payments_percent">0% </i></span>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		  <span class="count_top"><i class="fa fa-money"></i> Active Loans</span>
		  <div class="count"><a class="count green dash_link" href="view_loans.php?type=3" title="Details" id="total_actv_loans">0</a></div>
		  <span class="count_bottom"><i class="green fa fa-sort-asc" id="actv_loans_percent">0% </i></span>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		  <span class="count_top"><i class="fa fa-money"></i> Due Loans</span>
		  <div class="count"><a href="view_loans.php?type=4" class="count green dash_link" title="Details" id="due_loans">0</a></div>
		  <span class="count_bottom"><i class="green fa fa-sort-asc" id="due_loans_percent">0% </i></span>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		  <span class="count_top"><i class="fa fa-money"></i> P Loans</span>
		  <div class="count"><a href="view_loans.php?type=1" class="count green dash_link" title="Details" id="p_loans">0</a></div>
		  <span class="count_bottom"><i class="green fa fa-sort-asc" id="p_loans_percent">0% </i></span>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		  <span class="count_top"><i class="fa fa-money"></i> NP Loans</span>
		  <div class="count"><a href="view_loans.php?type=2" class="count green dash_link" title="Details" id="np_loans">0</a></div>
		  <span class="count_bottom"><i class="green fa fa-sort-asc" id="np_loans_percent">0% </i></span>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		  <span class="count_top"><i class="fa fa-user"></i> Members</span>
		  <div class="count"><a class="count green dash_link" href="view_members.php" title="Details" id="no_members">0</a></div>
		  <span class="count_bottom"><i class="green fa fa-sort-asc" id="members_percent">0% </i></span>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		  <span class="count_top"><i class="fa fa-money"></i> Subscriptions</span>
		  <div class="count"><a class="count green dash_link" href="view_subscriptions.php" title="Details" id="total_scptions">0</a></div>
		  <span class="count_bottom"><i class="green fa fa-sort-asc" id="scptions_percent">0% </i></span>
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
} else { 
	$exclude = true;
	include("view_members.php");
	
}?> 
<?php 
include("includes/footer.php"); 
?>
  