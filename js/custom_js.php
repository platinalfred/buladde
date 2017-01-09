<script>
var dTable;//Global datatables variable
var st_date = <?php echo isset($_GET['s_dt'])?"'{$_GET['s_dt']}'":"null"; ?>, //start date for the datatable
	ed_date = <?php echo isset($_GET['e_dt'])?"'{$_GET['e_dt']}'":"null"; ?>; //end date for the datatable
  function getStartDate(){
	  return st_date;
  }
  function getEndDate(){
	  return ed_date;
  }
 $(document).ready(function() {
	saveData();
	
	removeRedBorderOnRequiredField();
	cancelFormFields();
	
	$('.date-picker').daterangepicker({
	  singleDatePicker: true,
	  calender_style: "picker_1"
	}, function(start, end, label) {
	  console.log(start.toISOString(), end.toISOString(), label);
	});
		
		
/* ADD MEMBER JS */
	$(".photo_upload").click(function(){
		var formData = new FormData($("form#photograph")[0]);
		$.ajax({
			url: "photo_upload.php",
			type: 'POST',
			data: formData,
			async: false,
			success: function (response) {
				alert(response);
				if(response.trim() == "success"){
					window.location.reload(true);
				}else{
					showStatusMessage(response, "error");
				}
			},
			cache: false,
			contentType: false,
			processData: false
		});

		return false;
	});
	function doPasswordsMatch(){
		var pass = $("#password").val();
		var pass2 = $("#password2").val();
		if(pass.trim() == pass2.trim()){
			return true;
		}
		return false;
	}
	function findExpectedPayBackAmount(){
		var loan_amount = parseInt($("#loan_amount").val());
		var interest_rate = parseFloat($("#interest_rate").val());
		var total  = 0 ;
		var interest = 0;
		if(loan_amount != ""){
			if(interest_rate != ""){
				interest  = ((parseInt(interest_rate)/100)* parseInt(loan_amount));
				total = parseInt(interest) + parseInt(loan_amount);
				if(!isNaN(total)){
					var display_text = "Your interest is "+interest+"/= "+getWords(interest)+" Uganda Shillings Only and your total payback is "+total+"/= "+getWords(total)+"Uganda Shillings Only";
					$("#expected_payback").html(display_text);
					$("#expected_payback2").val(total);
				}
				else{
					$("#expected_payback").html("");
					$("#expected_payback2").val("");
				}
				
			}else{
				alert("Please enter loan interest rate.");
			}
		}else{
			alert("Please enter loan amount.");
		}
		
	}

//Value max validator
	$('#interest_rate').keyup(function(){
	  if (parseFloat($(this).val()) > 100){
		 alert("Interest rate has to be less than 100");
		$(this).val('100');
	  }else{
		  findExpectedPayBackAmount();
	  }
	});
	$("#withdraw_amount").keyup(function(){
		var max_size = $(this).attr("max");
		if (parseInt($(this).val()) > parseInt(max_size)){
			 alert("You can only with a maximum of "+max_size+"/=");
			$(this).val(max_size);
		  } 
	});
//End value max validator
	function getWords(s){
		// American Numbering System
		var th = ['', 'Thousand', 'Million', 'Billion', 'Trillion'];

		var dg = ['Zero', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];

		var tn = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];

		var tw = ['Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

		
		s = s.toString();
		s = s.replace(/[\, ]/g, '');
		if (s != parseFloat(s)) return 'not a number';
		var x = s.indexOf('.');
		if (x == -1) x = s.length;
		if (x > 15) return 'too big';
		var n = s.split('');
		var str = '';
		var sk = 0;
		for (var i = 0; i < x; i++) {
			if ((x - i) % 3 == 2) {
				if (n[i] == '1') {
					str += tn[Number(n[i + 1])] + ' ';
					i++;
					sk = 1;
				} else if (n[i] != 0) {
					str += tw[n[i] - 2] + ' ';
					sk = 1;
				}
			} else if (n[i] != 0) {
				str += dg[n[i]] + ' ';
				if ((x - i) % 3 == 0) str += 'hundred ';
				sk = 1;
			}
			if ((x - i) % 3 == 1) {
				if (sk) str += th[(x - i - 1) / 3] + ' ';
				sk = 0;
			}
		}
		if (x != s.length) {
			var y = s.length;
			str += 'point ';
			for (var i = x + 1; i < y; i++) str += dg[n[i]] + ' ';
		}
		return str.replace(/\s+/g, ' ');
	}
	$("#loan_amount").keyup(function(){
		var currentInput  = parseInt($(this).val());
		if(!isNaN(currentInput)){
			var words  = getWords(currentInput);
			$("#number_words").html( words +" Ugandan Shillings Only");
			$("#loan_amount_word").val( words);
		}
		else
		{
			$("#number_words").html("");
			$("#loan_amount_word").val("");
		}
		
	});
	$("#loan_duration").change(function(){
		var loan_duration = parseInt($(this).val());
		$("#loan_end_date").val(moment().add(loan_duration, 'days').format('YYYY-MM-DD HH:mm:ss'));
		$("#loan_end_date1").val(moment().add(loan_duration, 'days').format('D MMMM, YYYY'));
	});
	$("#deposit_amount, #withdraw_amount").keyup(function(){
		var currentInput  = parseInt($(this).val());
		var words  = getWords(currentInput);
		if(!isNaN(currentInput)){
			words = words +" Ugandan Shillings Only";
			$("#amount_description").html(words);
			$(".amount_description").val(words);
		}
		else
		{
			$("#amount_description").html("");
			$(".amount_description").val("");
		}
	})
	$("#add_staff").smartWizard({
		transitionEffect:'fade',
		onFinish:submitStaff, 
		transitionEffect: 'fade', // Effect on navigation, none/fade/slide/slideleft
		contentCache:false,
		labelFinish:'Submit Staff' // label for Finish button    
	});
	$('#add_member').smartWizard({
		transitionEffect:'fade',
		onFinish:submitMember, 
		transitionEffect: 'fade', // Effect on navigation, none/fade/slide/slideleft
		contentCache:true,
		labelFinish:'Submit Member' // label for Finish button    
	});
	function cancelFormFields(){
		$(".cancel").click(function(){
			var form  = $(this).closest("form");
			form[0].reset();
		});
	}
	
	function saveData(){
		$(".save_data").click(function(){
			if(areAllFilled()){
				var form  = $(this).closest("form");
				var formData = form.serializeArray();
				$.ajax({
					type: "post",
					url: "add_data.php",
					data: formData,
					cache: false,
					success: function(response){
						
						if(response.trim() == "success"){
							showStatusMessage("<strong>Successful!</strong> Your data was successfully added!", "success");
							setTimeout(function(){
								form[0].reset();
								$("#number_words, #expected_payback").html( "");
							}, 3000);
						}else{
							showStatusMessage(response  + "Could not add data,please try again. If the problem persisits contact the technical team for assistance!", "error");
							setTimeout(function(){
								
							}, 3000);
						}
					}
				});
			}else{
				showStatusMessage("Please fill in all the required fields <b>(*)</b>", "error");
			}
		});
	}
	
	function showStatusMessage(message='', display_type='success'){
		new PNotify({
			  title: "Alert",
			  text: message,
			  type: display_type,
			  styling: 'bootstrap3',
			  sound: true,
			  hide:true,
			  nonblock: {
				  nonblock: true
			  }
			  
		  });
		
	}
			
	function submitStaff(){
		if(!areAllFilled()){
			showStatusMessage('Please fill in all the required fiels marked with (*)', "error");
		}else{
			if(!doPasswordsMatch()){
				showStatusMessage('Please make sure all the passwords are the same!', "error");
			}else{
				$.ajax({
					type: "post",
					url: "add_data.php",
					data: $('.form-horizontal').serialize(),
					cache: false,
					success: function(response){
						if(response.trim() == "success"){
							showStatusMessage('A staff has been successfully added!', "success");
							setTimeout(function(){
								window.location.reload();
							}, 4000);
						}else{  
							showStatusMessage('Failed to a member, please try again. If the problem persisits contact the technical team for assistance!', "error");
							/* setTimeout(function(){
								$($('.form-horizontal')[0]).each(function(){
									$(this).reset();
								})
							}, 4000); */
						}
						
					}
				});
			}
		}
	}
	function submitMember(){
		if(!areAllFilled()){
			showStatusMessage('Please fill in all the required fiels marked with (*)', "error");
		}else{
			
			$.ajax({
				type: "post",
				url: "add_data.php",
				data: $('.form-horizontal').serialize(),
				cache: false,
				success: function(response){
					if($.isNumeric(response)){
						showStatusMessage('A member has been successfully added!', "success");
						setTimeout(function(){
							$('.form-horizontal')[0].reset();
							window.location="member-details.php?member_id="+response;
						}, 4000);
						
					}else{
						showStatusMessage('Failed to a member, please try again. If the problem persisits contact the technical team for assistance!', "error");
						setTimeout(function(){
							$('.form-horizontal')[0].reset();
						}, 4000);
					}
					
				}
			});
		}
	}
	function removeRedBorderOnRequiredField(){
		$('.required_f').each(function() {
			$(this).keypress(function(){
				$($(this)).css({"border":"1px solid #ccc"});
			});
		});
	}
	function areAllFilled() {
		var found = true;
		$('.required_f').each(function() {
			if($(this).val() == ''){
				$($(this)).css({"border":"1px solid #ff0000"});
				found = false;
			}
		});
		return found;
	}
	
	/* Geographical location load functions */
		var country = $("#country_select").val();
		getDistricts(country);
		function getChangeValues(){
			$("#country_select").on('change',function(){
				var id = $(this).val();
				getDistricts(id);
			});
			$("#district_select").on('change',function(){
				var id = $(this).val();
				getCounties(id);
			});
			$("#county_select").on('change',function(){
				var id = $(this).val();
				getSubCounties(id);
			});
			$("#subcounty_select").on('change',function(){
				var id = $(this).val();
				getParishes(id);
			});
			$("#parish_select").on('change',function(){
				var id = $(this).val();
				getVillage(id);
			});
		}
		function getDistricts(country_id){
			$.ajax({
				type: "post",
				url: "find_location.php?country="+country_id,
				data: $('.form-horizontal').serialize(),
				cache: false,
				success: function(response){
					$("#district").html(response);
					setTimeout(function(){
						var district = $("#district_select").val();
						getCounties(district);
					}, 200);
				}
			});
		}
		
		function getCounties(district_id){
			$.ajax({
				type: "post",
				url: "find_location.php?district="+district_id,
				success: function(response){
					$("#county").html(response);
					setTimeout(function(){
						var county = $("#county_select").val();
						getSubCounties(county);
					}, 200);
				}
			});
		}
		function getSubCounties(county_id){
			$.ajax({
				type: "post",
				url: "find_location.php?county="+county_id,
				success: function(response){
					$("#subcounty").html(response);
					setTimeout(function(){
						var subcounty = $("#subcounty_select").val();
						getParishes(subcounty);
					}, 200);
				}
			});
		}
		function getParishes(subcounty_id){
			$.ajax({
				type: "post",
				url: "find_location.php?subcounty="+subcounty_id,
				success: function(response){
					$("#parish").html(response);
					setTimeout(function(){
						var parish = $("#parish_select").val();
						getVillage(parish);
					}, 200);
				}
			});
		}
		function getVillage(parish_id){
			$.ajax({
				type: "post",
				url: "find_location.php?parish="+parish_id,
				success: function(response){
					$("#village").html(response);
					getChangeValues();
				}
			});
		}
	/* Geographical location load functions */
/*END ADD MEMBER */
		$('#single_cal1').daterangepicker({
          singleDatePicker: true,
          singleClasses: "picker_1"
		}, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
		$(document).ready(function() {
			$(":input").inputmask();
		  });
	 /* FORM VALIDATION */
		  // initialize the validator function
	  validator.message.date = 'not a real date';

	  // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
	  $('form')
		.on('blur', 'input[required], input.optional, select.required', validator.checkField)
		.on('change', 'select.required', validator.checkField)
		.on('keypress', 'input[required][pattern]', validator.keypress);

	  $('.multi.required').on('keyup blur', 'input', function() {
		validator.checkField.apply($(this).siblings().last()[0]);
	  });

	  $('form').submit(function(e) {
		e.preventDefault();
		var submit = true;

		// evaluate the form using generic validaing
		if (!validator.checkAll($(this))) {
		  submit = false;
		}

		if (submit)
		  this.submit();

		return false;
	  });
	 /* END FORM VALIDATION */
	 /* FORM WIZARD */
	
	
	/* $('#wizard_verticle').smartWizard({
		transitionEffect: 'slide'
	}); */

	$('.buttonNext').addClass('btn btn-success');
	$('.buttonPrevious').addClass('btn btn-primary');
	$('.buttonFinish').addClass('btn btn-default loginbtn');

	//list the guarantors
var GuarantorSelection = function() {
    var self = this;
    self.guarantor = ko.observable();
};
 
var Guarantor = function() {
    var self = this;
    // Stores an array of selectedGuarantors
    self.selectedGuarantors = ko.observableArray([new GuarantorSelection()]); // Put one guarantor in by default
    self.totalSavings = ko.pureComputed(function() {
        var total = 0;
		$.map(self.selectedGuarantors(), function(selectedGuarantor) {
			if(selectedGuarantor.guarantor()) {
                total += parseInt("0" + selectedGuarantor.guarantor().savings);
            };
        });
        return total;
    });
    self.totalShares = ko.pureComputed(function() {
		var sum = 0;
        $.map(self.selectedGuarantors(), function(selectedGuarantor) {
			if(selectedGuarantor.guarantor()) {
                sum += parseInt("0" + selectedGuarantor.guarantor().shares);
            };
        });
        return sum;
    });
 
    // Operations
    self.addGuarantor = function() { self.selectedGuarantors.push(new GuarantorSelection()) };
    self.removeGuarantor = function(selectedGuarantor) { self.selectedGuarantors.remove(selectedGuarantor) };
};
var guarantor = new Guarantor();
ko.applyBindings(guarantor);

//Date range picker
	var cb = function(start, end, label) {
		//console.log(start.toISOString(), end.toISOString(), label);
		$('#reportrange span').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
	};
   var optionSet1 = {
          startDate: moment().subtract(29, 'days'),
          endDate: moment(),
          minDate: '01/01/2012',
          maxDate: '12/31/2020',
          dateLimit: {
            days: 60
          },
          showDropdowns: true,
          showWeekNumbers: true,
          timePicker: false,
          timePickerIncrement: 1,
          timePicker12Hour: true,
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          opens: 'right',
          buttonClasses: ['btn btn-default'],
          applyClass: 'btn-small btn-primary',
          cancelClass: 'btn-small',
          format: 'DD/MM/YYYY',
          separator: ' to ',
          locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Clear',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
          }
    };
		var start_date = moment().subtract(29, 'days'), end_date = moment();
		$('#reportrange span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));
		format_hrefs(start_date.format('YYYY-MM-DD'), end_date.format('YYYY-MM-DD'));
		
		$('#reportrange').daterangepicker(optionSet1, cb);
		
		$('#reportrange').on('show.daterangepicker', function() {
			//console.log("show event fired");
		});
		$('#reportrange').on('hide.daterangepicker', function() {
		//console.log("hide event fired");
		});
		$('#reportrange').on('apply.daterangepicker', function(ev, picker) {
			<?php 
			if(isset($_GET['member_id'])){ ?>
				findReportRange(<?php echo $_GET['member_id']; ?>, picker.startDate.format('MMMM D, YYYY'), picker.endDate.format('MMMM D, YYYY'));
			<?php
			}else{?>
				var start_date=picker.startDate.format('YYYY-MM-DD'), end_date = picker.endDate.format('YYYY-MM-DD');
				
				//when at the dashboard page
				if(document.getElementById("nploans")){
					var elements = ["nploans","ploans","actvloans","income","expenses","barChart","lineChart","pieChart"];
					getDashboardData(elements, moment().subtract(29, 'days').format('YYYY-MM-DD'), moment().format('YYYY-MM-DD'));
					format_hrefs(start_date, end_date);
				}
				searchTable(start_date,end_date); /* */
			<?php } ?>
		});
		$('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
			console.log("cancel event fired");
		});
		$('#options1').click(function() {
			$('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
		});
		$('#options2').click(function() {
		$('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
		});
		$('#destroy').click(function() {
		$('#reportrange').data('daterangepicker').remove();
		});
	//Clients transaction details
		<?php 
		if(isset($_GET['view']) && $_GET['view'] == "client_trasaction_history"){ ?>
			//Get the initial range
			var initial_range = $("#reportrange span").html().split("-");
			var start_date = initial_range[0];
			var end_date = initial_range[1];
			var member = <?php echo $_GET['member_id']; ?>;
			findReportRange(member, start_date, end_date);
		<?php 
		}
		?>
		//add params to the urls at the dashboard page
		function format_hrefs(start_date, end_date){
			$(".dash_link").each(function(){
				var cur_url = $(this).attr("href"), params = "s_dt="+start_date+"&e_dt="+end_date;
				
				params = (cur_url.search(/\?(type)/)!==-1)?"&"+params:"?"+params;
				cur_url = cur_url.replace(/(\?|\&)s_dt(.+)/gi, "");
				$(this).attr("href", cur_url+params);
			});
		}
		//find results for report given the date range
		function findReportRange(member, start_date, end_date){
			$.ajax({
				type: "get",
				url: "client_transactions.php?member_id="+member+"&start_date="+start_date+"&end_date="+end_date,
				success: function(response){
					$("#report_data").html(response);
				}
			});
		}
		// Apply the search on the table
		function searchTable(startDate,endDate){
			st_date = startDate;
			ed_date = endDate;
			dTable.ajax.reload();
		}	
	//End client transaction details 
		function getDashboardData(elements, startDate, endDate){
			$.each(elements, function(key, value){
				$.ajax({
					type: "post",
					data:{element:value, start_date:startDate, end_date:endDate},
					url: "dashboard_data.php",
					success: function(response){
						switch(value){
							case "barChart":
								var data = JSON.parse(response);
								draw_bar_chart(data)
							break;
							case "lineChart":
								var data = JSON.parse(response);
								//lineChart.clear();
								draw_line_chart(data)
								/* lineChart.data.datasets[0].data = data.loans_sum;
								lineChart.data.datasets[1].data = data.subscriptions_sum;
								lineChart.data.labels = data.data_points;
								lineChart.update();
								lineChart.render(300,true); */
							break;
								case "pieChart":
								//draw the pie chart
								var data = JSON.parse(response);
								draw_pie_chart(data);
								break;
							default:
								$("#"+value).html(response);
								break;
						}
					}
				});
			});
		}
      //Bar chart
	  function draw_bar_chart(url_data){
		  $("#barChart").replaceWith('<canvas id="barChart"></canvas>');
		  var ctx = $("#barChart").get(0).getContext("2d");
		  var barChart = new Chart(ctx, {
			type: 'bar',
			data: {
			  labels: url_data.data_points,
			  datasets: [{
				label: 'Loans',
				backgroundColor: "#26B99A",
				data: url_data.loans_count
			  }, {
				label: 'Shares',
				backgroundColor: "#03586A",
				data: url_data.shares_count
			  }, {
				label: 'Subscriptions',
				backgroundColor: "#B9264A",
				data: url_data.subscriptions_count
			  }]
			},

			options: {
			  scales: {
				yAxes: [{
				  ticks: {
					beginAtZero: true
				  }
				}]
			  }
			}
		  });
	  }
      // Line chart
	  function draw_line_chart(url_data){
		  $("#lineChart").replaceWith('<canvas id="lineChart"></canvas>');
		  var ctx = $("#lineChart").get(0).getContext("2d");
		  var lineChart = new Chart(ctx, {
			type: 'line',
			data: {
			  labels: url_data.data_points,
			  datasets: [{
				label: "Loans",
				backgroundColor: "rgba(38, 185, 154, 0.31)",
				borderColor: "rgba(38, 185, 154, 0.7)",
				pointBorderColor: "rgba(38, 185, 154, 0.7)",
				pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
				pointHoverBackgroundColor: "#fff",
				pointHoverBorderColor: "rgba(220,220,220,1)",
				pointBorderWidth: 1,
				data: url_data.loans_sum
			  }, {
				label: "Subscriptions",
				backgroundColor: "rgba(3, 88, 106, 0.3)",
				borderColor: "rgba(3, 88, 106, 0.70)",
				pointBorderColor: "rgba(3, 88, 106, 0.70)",
				pointBackgroundColor: "rgba(3, 88, 106, 0.70)",
				pointHoverBackgroundColor: "#fff",
				pointHoverBorderColor: "rgba(151,187,205,1)",
				pointBorderWidth: 1,
				data: url_data.subscriptions_sum
			  }]
			},
		  });
	  }
	  // Pie chart
	  function draw_pie_chart(url_data){
		  $("#pieChart").replaceWith('<canvas id="pieChart"></canvas>');
		  var ctx = $("#pieChart").get(0).getContext("2d");
		  var data = {
			datasets: [{
			  data: url_data,
			  backgroundColor: [
				"#356AA0",
				"#B54C4C"
			  ],
			  label: 'My dataset' // for legend
			}],
			labels: [
			  "Perf. Loans",
			  "NP Loans"
			]
		  };

		  var pieChart = new Chart(ctx, {
			data: data,
			type: 'pie',
			otpions: {
			  legend: false
			}
		  });
	  }
		if(document.getElementById("nploans")){
			var elements = ["nploans","ploans","actvloans","income","expenses","barChart","lineChart","pieChart"];
			getDashboardData(elements, moment().subtract(29, 'days').format('YYYY-MM-DD'), moment().format('YYYY-MM-DD'));
		}
  });
  
</script>