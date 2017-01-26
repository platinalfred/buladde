<script>
var start_date = <?php echo isset($_GET['s_dt'])?"moment('{$_GET['s_dt']}','YYYY-MM-DD')":"moment().subtract(29, 'days')"; ?>,
end_date = <?php echo isset($_GET['e_dt'])?"moment('{$_GET['e_dt']}','YYYY-MM-DD')":"moment()"; ?>;

var st_date = start_date.format('YYYY-MM-DD'), //start date for the datatable
	ed_date = end_date.format('YYYY-MM-DD'), //end date for the datatable
	loan_type = <?php echo isset($_GET['type'])?"'{$_GET['type']}'":0; ?>; //loan_type for the datatable
//format numbers to currency format
function format1(n) {
	return n.toString().replace(/./g, function(c, i, a) {
		return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
	});
}
<?php if($show_table_js):?>
var dTable, dTable2;//Global datatables variable	
  function getStartDate(){
	  return st_date;
  }
  function getEndDate(){
	  return ed_date;
  }
  function getLoanType(){
	  return loan_type;
  }
jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
    return this.flatten().reduce( function ( a, b ) {
        if ( typeof a === 'string' ) {
            a = a.replace(/[^\d.-]/g, '') * 1;
        }
        if ( typeof b === 'string' ) {
            b = b.replace(/[^\d.-]/g, '') * 1;
        }
 
        return a + b;
    }, 0 );
} );
<?php endif;?>
 $(document).ready(function() {
	saveData();
	deleteData();
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
	$("#loan_amount, #loan_repayment").keyup(function(){
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
	$("#no_of_shares").keyup(function(){
		var currentInput  = parseInt($(this).val());
		var one_share_amount  = parseInt($("#rate_amount").val());
		var total_share_amount  = currentInput * one_share_amount;
		if(!isNaN(currentInput)){
			var words  = getWords(total_share_amount);
			if(currentInput != 1){
				s = "shares";
			}else{
				s = "share";
			}
			$("#share_amount").val(total_share_amount);
			$("#share_rate_amount").html(" You are buying "+currentInput+" "+ s+ " which is equivalent to "+ words +" Ugandan Shillings Only");
			
		}else{
			$("#share_rate_amount").html("");
			$("#share_amount").val("");
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
						alert(response);
						if(response.trim() == "success"){
							<?php 
							if(isset($_GET['task']) && ($_GET['task'] == "withdraw.add")){ ?>
								window.location.reload(true);
								<?php
							}
							?>
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
	function deleteData(){
		$(".delete").click(function(){
			//This check will determine if its a delete of a member
			var member = false;
			if($(this).hasClass('member')){
				member = true; 
			}
			//End member check
			var confirmation = confirm("Are sure you would like to delete this item?");
			if(confirmation){
			
				var tbl;
				var id;
				var d_id = $(this).attr("id");
				var arr = d_id.split("_");
				id = arr[0];
				tbl = arr[1];
				$.ajax({ // create an AJAX call...
					url: "delete.php?id="+id+"&tbl="+tbl, // the file to call
					success: function(response) { // on success..
				
						if(response != "fail"){
							showStatusMessage("Successfully deleted record", "success");
							setTimeout(function(){
								if(member){
									window.location = "view_members.php"
								}else{
									location.reload();
								}
							}, 1000);
						}else{
							showStatusMessage(response, "warning");
						}
					}			
				});
			}
		});
	}
	$(".update_staff").click(function(){
		updateStaff();
	});
	function updateStaff(){
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
						alert(response);
						if(response.trim() == "success"){
							showStatusMessage('A staff has been successfully updated!', "success");
							setTimeout(function(){
								window.location.reload();
							}, 4000);
						}else{  
							showStatusMessage('Failed to update staff, please try again. If the problem persisits contact the technical team for assistance!', "error");
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
	if($("#country_select").length > 0){
		var country = $("#country_select").val();
		getDistricts(country);
	}
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
          startDate: start_date,
          endDate: end_date,
          minDate: '01/01/2012',
          maxDate: '12/31/2020',
          dateLimit: {
            days: 123
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
				var startDate=picker.startDate.format('YYYY-MM-DD'), endDate = picker.endDate.format('YYYY-MM-DD');
				//when at the dashboard page
				if(document.getElementById("nploans")){
					getDashboardData(startDate, endDate);
					format_hrefs(startDate, endDate);
				}
				searchTable(startDate,endDate);
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
		$('#loan_types').on('change', function() {
			loan_type = $(this).val();
			dTable.ajax.reload();
		});
		//This is to add loan id to the loan repayment order to allow passing of the loand add when saving a repayment
		$('.add_repayment').on('show.bs.modal', function(e) {
			var loan = $(e.relatedTarget).data('id');
			$("#loan_id").val(loan);
		});
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
				url: "client_transactions.php",
				data: {member_id:member,start_date:start_date, end_date:end_date},
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
			dTable2.ajax.reload();
		}	
	//End client transaction details 
		function getDashboardData(startDate, endDate){
			$.ajax({
				type: "post",
				dataType: "json",
				data:{start_date:startDate, end_date:endDate},
				url: "dashboard_data.php",
				success: function(response){
					draw_bar_chart(response.lineBarChart);
					
					draw_line_chart(response.lineBarChart);
					//draw the pie chart
					draw_pie_chart(response.pieChart);
					//display the figures
					//var figures = ["no_members","total_scptions","total_shares","total_actv_loans","loan_payments","due_loans"];
					$.each(response.figures, function(key, value){
						$("#"+key).html(value);
					});
					//iterate over the percentages
					$.each(response.percents, function(key, value){
						var cur_ele = $("#"+key);
						if(parseFloat(value)>=0){
							$(cur_ele).removeClass("red fa-sort-desc").addClass("green fa-sort-asc").html(value+"%");
						}
						else{
							$(cur_ele).removeClass("green fa-sort-asc").addClass("red fa-sort-desc").html(value+"%");
						}
					});
					var elements = ["nploans","ploans","actvloans"];
					//draw the tables
					$.each(elements, function(key, value){
						$("#"+value).html(draw_loans_table(response.tables[value]));
					});
					//draw the income table
					$("#income").html(draw_income_table(response.tables.income));
					//draw the expenses table
					$("#expenses").html(draw_expense_table(response.tables.expenses));
				}
			});
		}
	//draw income table
	function draw_income_table(income_data){
		var total = 0;
		var html_data = "<thead>"+
					"<tr><th>#</th><th>Income type</th><th>Amount</th></tr>"+
				"</thead>"+
				  "<tbody>";
		$.each(income_data, function(key, value){
			html_data += "<tr>"+
						  "<td><a href='#"+value.id+"' title='View details'>"+value.id+"</a></td>"+
						  "<td>"+value.name+"</td>"+
						  "<td>"+format1(parseInt(value.amount))+"</td>"+
						"</tr>";
						total += parseInt(value.amount);
		});
		html_data += "</tbody>"+
				  "<tfoot>"+
					"<tr>"+
					  "<th scope='row'>Total</th>"+
					  "<th>&nbsp;</th>"+
					  "<th>"+format1(total)+"</th>"+
					"</tr>"+
				  "</tfoot>";
		return html_data;
	}
	//draw expense table
	function draw_expense_table(expense_data){
		var total = 0;
		var html_data = "<thead>"+
					"<tr><th>#</th><th>Description</th><th>Amount</th></tr>"+
				"</thead>"+
				  "<tbody>";
		$.each(expense_data, function(key, value){
			html_data += "<tr>"+
						  "<td><a href='#"+value.id+"' title='View details'>"+value.id+"</a></td>"+
						  "<td>"+value.amount_description+"</td>"+
						  "<td>"+format1(parseInt(value.amount_used))+"</td>"+
						"</tr>";
						total += parseInt(value.amount_used);
		});
		html_data += "</tbody>"+
				  "<tfoot>"+
					"<tr>"+
					  "<th scope='row'>Total</th>"+
					  "<th>&nbsp;</th>"+
					  "<th>"+format1(total)+"</th>"+
					"</tr>"+
				  "</tfoot>";
		return html_data;
	}
	//draw loans table
	function draw_loans_table(loans_data){
		var amount = balance = 0;
		var html_data = "<thead>"+
					"<tr><th>Loan No</th><th>Amount</th><th>Balance</th></tr>"+
				"</thead>"+
				  "<tbody>";
		$.each(loans_data, function(key, value){
			html_data += "<tr>"+
						  "<td><a href='#"+value.id+"' title='View details'>"+value.loan_number+"</a></td>"+
						  "<td>"+format1(parseInt(value.expected_payback))+"</td>"+
						  "<td>"+format1(parseInt(value.loan_amount))+"</td>"+
						"</tr>";
						amount += parseInt(value.expected_payback); 
						balance += parseInt(value.loan_amount);
		});
		html_data += "</tbody>"+
				  "<tfoot>"+
					"<tr>"+
					  "<th scope='row'>Total</th>"+
					  "<th>"+format1(amount)+"</th>"+
					  "<th>"+format1(balance)+"</th>"+
					"</tr>"+
				  "</tfoot>";
		return html_data;
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
			getDashboardData(moment().subtract(29, 'days').format('YYYY-MM-DD'), moment().format('YYYY-MM-DD'));
		}
		<?php if($show_table_js){?>
			//searchTable(start_date.subtract(29, 'days').format('YYYY-MM-DD'),end_date.format('YYYY-MM-DD'));
		<?php }?>
		
	//Clients transaction details
		<?php 
		if(isset($_GET['view']) && $_GET['view'] == "client_trasaction_history"){ ?>
			var handleDataTableButtons = function() {
			  if ($("#transactions_table").length) {
				dTable = $('#transactions_table').DataTable({
				  dom: "Bfrtip",
				  "processing": true,
				  "serverSide": true,
				  "deferRender": true,
				  "ajax": {
					  "url":"server_processing.php",
					  "type": "POST",
					  "data":  function(d){
						d.page = 'client_transactions';
						d.member_id = <?php echo $_GET['member_id']?>;
						d.start_date = getStartDate();
						d.end_date = getEndDate();
						}
				  },
				  "footerCallback": function (tfoot, data, start, end, display ) {
					var api = this.api(),
					total = api.column(3).data().sum();
					$(api.column(3).footer()).html( format1(total) );
				  },columns:[ { data: 'id', render: function ( data, type, full, meta ) {return '<input type="checkbox" value="'+data+'" class="flat" name="table_records">';}},
						{ data: 'account_number'},
						{ data: 'transaction_type' , render: function ( data, type, full, meta ) {
							var trans_type = "";
							switch(data){
								case "1":
								trans_type = "Deposit";
								break;
								case "2":
								trans_type = "Withdraw";
								break;
								case "3":
								trans_type = "Shares";
								break;
								case "4":
								trans_type = "Membership";
								break;
								default:
								break;
							}
							return trans_type;}},
						{ data: 'amount', render: function ( data, type, full, meta ) {return (parseFloat(data) < 0)?"("+format1(parseFloat(data) * -1)+")":format1(parseFloat(data));}},
						{ data: 'transaction_date', render: function ( data, type, full, meta ) {return moment(data, 'YYYY-MM-DD').format('LL');}},
						{ data: 'transacted_by'}
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
		<?php } ?>
  });
  $(document).on("click", ".open-AddBookDialog", function () {
	  alert($(this).data('id'));
		 var myBookId = $(this).data('id');
		 $(".modal-body #bookId").val( myBookId );
	});
	
</script>