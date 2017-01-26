<?php
require_once("lib/IncomeSource.php");
$income_source = new IncomeSource();
$member = new Member();
$all_income_source = $income_source->findAll();
?>
<!-- page content -->
<div class="left_col" role="main" style="background:none;">
	<div class="x_panel">
		<div class="x_content">
			<!-- Smart Wizard -->
			<!--<p>This is a basic form wizard example that inherits the colors from the selected scheme.</p>-->
			<div id="" class="col-md-10">
				<form class="form-horizontal form-label-left" novalidate>
					<div id="step-2">
						<div class="item form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="firstname">Income Source<span class="required">*</span>
							</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<select class="form-control" name="title">
									<option value="">Please select</option>
									<?php 
									if($all_income_source){
										foreach($all_income_source as $single){ 
											if($single['name'] !="Shares" && $single['name'] != "Subscription"){
												?>
												<option value="<?php echo $single['id']; ?>" ><?php echo $single['name']; ?></option>
												<?php
											}
										}
									}
									?>
								</select>
							</div>
						</div>
						<div class="item form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="amount">Amount <span class="required">*</span>
							</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
							  <input id="amount" class="form-control col-md-7 col-xs-12 required_f"    name="amount"  required="required" type="number">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12">Added By</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							 <?php echo $member->findMemberNames($_SESSION['person_number']); ?>
							</div>
							 <input type="hidden" class="form-control" name="added_by" value="<?php echo $_SESSION['person_number']; ?>" readonly="readonly" placeholder="Read-Only Input">
						</div>
					</div>
					<input type="hidden" name="update_member" value="update_member">
				</form>
			<!-- End SmartWizard Content -->
			</div>
		</div>
	</div>
</div>