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
		  <div class="count"><?php echo $member->noOfMembers(); ?></div>
		  <span class="count_bottom"><i class="green">4% </i> From last Week</span>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		  <span class="count_top"><i class="fa fa-money"></i> Total Paid Subsciption</span>
		  <div class="count"><?php echo $dashboard->findTotalSumOfSubscriptions(); ?></div>
		  <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		  <span class="count_top"><i class="fa fa-money"></i> Total Shares</span>
		  <div class="count green"><?php echo $dashboard->findTotalSumOfShares(); ?></div>
		  <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		  <span class="count_top"><i class="fa fa-user"></i> Total Active Loans</span>
		  <div class="count"><?php echo $dashboard->totalActiveLoans(); ?></div>
		  <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		  <span class="count_top"><i class="fa fa-money"></i> Total Loan Repayment Collections</span>
		  <div class="count">2,315</div>
		  <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		  <span class="count_top"><i class="fa fa-user"></i> Total Due Loans</span>
		  <div class="count">100</div>
		  <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
		</div>
	  </div>
	  <!-- /top tiles -->

	    <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="dashboard_graph">

                <div class="row x_title">
                  <div class="col-md-6">
                    <h3>Transaction Activities <small>Graph title will be here</small></h3>
                  </div>
                  <div class="col-md-6">
                    <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                      <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                      <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                    </div>
                  </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div id="placeholder33" style="height: 300px; display: none" class="demo-placeholder"></div>
                  <div style="width: 100%;">
                    <div id="canvas_dahs" class="demo-placeholder" style="width: 100%; height:270px;"></div>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>

          </div>
          <br />

</div>
<!-- /page content -->
<?php 
include("includes/footer.php"); 
?>
   <!-- Flot -->
    <script>
      $(document).ready(function() {
        var data1 = [
          [gd(2012, 1, 1), 17],
          [gd(2012, 1, 2), 74],
          [gd(2012, 1, 3), 6],
          [gd(2012, 1, 4), 39],
          [gd(2012, 1, 5), 20],
          [gd(2012, 1, 6), 85],
          [gd(2012, 1, 7), 7]
        ];

        var data2 = [
          [gd(2012, 1, 1), 82],
          [gd(2012, 1, 2), 23],
          [gd(2012, 1, 3), 66],
          [gd(2012, 1, 4), 9],
          [gd(2012, 1, 5), 119],
          [gd(2012, 1, 6), 6],
          [gd(2012, 1, 7), 9]
        ];
        $("#canvas_dahs").length && $.plot($("#canvas_dahs"), [
          data1, data2
        ], {
          series: {
            lines: {
              show: false,
              fill: true
            },
            splines: {
              show: true,
              tension: 0.4,
              lineWidth: 1,
              fill: 0.4
            },
            points: {
              radius: 0,
              show: true
            },
            shadowSize: 2
          },
          grid: {
            verticalLines: true,
            hoverable: true,
            clickable: true,
            tickColor: "#d5d5d5",
            borderWidth: 1,
            color: '#fff'
          },
          colors: ["rgba(38, 185, 154, 0.38)", "rgba(3, 88, 106, 0.38)"],
          xaxis: {
            tickColor: "rgba(51, 51, 51, 0.06)",
            mode: "time",
            tickSize: [1, "day"],
            //tickLength: 10,
            axisLabel: "Date",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 10
          },
          yaxis: {
            ticks: 8,
            tickColor: "rgba(51, 51, 51, 0.06)",
          },
          tooltip: false
        });

        function gd(year, month, day) {
          return new Date(year, month - 1, day).getTime();
        }
      });
    </script>
    <!-- /Flot -->
  