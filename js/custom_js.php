<script>

 $(document).ready(function() {
	saveData();
	
	removeRedBorderOnRequiredField();
	cancelFormFields();
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
		if(loan_amount.trim() != ""){
			if(interest_rate.trim() != ""){
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
		
	})
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
							}, 4000);
						}else{
							showStatusMessage(response  + "Could not add data,please try again. If the problem persisits contact the technical team for assistance!", "error");
							setTimeout(function(){
								
							}, 4000);
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
        //$.each(self.selectedGuarantors(), function() { total += parseInt(this.guarantor.shares) })
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
	
    /* self.dataToSave = $.map(self.selectedGuarantors(), function(selectedGuarantor) {
			var data = selectedGuarantor.guarantor() ? {
                person_number: selectedGuarantor.guarantor().person_number
            } : undefined;
            return data;
    }); */
 
    // Operations
    self.addGuarantor = function() { self.selectedGuarantors.push(new GuarantorSelection()) };
    self.removeGuarantor = function(selectedGuarantor) { self.selectedGuarantors.remove(selectedGuarantor) };
};
var guarantor = new Guarantor();
ko.applyBindings(guarantor);

//Date range picker
	var cb = function(start, end, label) {
		console.log(start.toISOString(), end.toISOString(), label);
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
		$('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
		
		$('#reportrange').daterangepicker(optionSet1, cb);
		
		
		
		$('#reportrange').on('show.daterangepicker', function() {
			console.log("show event fired");
		});
		$('#reportrange').on('hide.daterangepicker', function() {
		console.log("hide event fired");
		});
		$('#reportrange').on('apply.daterangepicker', function(ev, picker) {
			<?php 
			if(isset($_GET['member_id'])){ ?>
				findReportRange(<?php echo $_GET['member_id']; ?>, picker.startDate.format('MMMM D, YYYY'), picker.endDate.format('MMMM D, YYYY'));
			<?php
			}
			?>
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
		function findReportRange(member, start_date, end_date){
			$.ajax({
				type: "get",
				url: "client_transactions.php?member_id="+member+"&start_date="+start_date+"&end_date="+end_date,
				success: function(response){
					$("#report_data").html(response);
				}
			});
		}
	//End client transaction details 
  });
  
</script>