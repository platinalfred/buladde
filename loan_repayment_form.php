<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
		  <div class="x_title">
			<h2>Add new Payement <small></small></h2>
			<ul class="nav navbar-right panel_toolbox">
			  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
			</ul>
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">
			<form class="form-horizontal form-label-left" novalidate>
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Loan Being Repaid<span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <select class="form-control" name="member_type">
					<option value="1" >Development</option>
					<option value="2">Member</option>
				  </select>
				</div>
			  </div>
								
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Amount<span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <input type="money"  name="amount" data-validate-linked="email" required="required" readonly = "readonly"  class="form-control col-md-7 col-xs-12">
				</div>
			  </div>
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Justification <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <textarea id="textarea" required="required" name="textarea" class="form-control col-md-7 col-xs-12"></textarea>
				</div>
			  </div>
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Added By <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <input type="tel" id="telephone" readonly = "readonly" name="phone" required="required" data-validate-length-range="8,20" class="form-control col-md-7 col-xs-12">
				</div>
			  </div>
			  <div class="ln_solid"></div>
			  <div class="form-group">
				<div class="col-md-6 col-md-offset-3">
				  <button type="submit" class="btn btn-primary">Cancel</button>
				  <button id="send" type="submit" class="btn btn-success loginbtn">Submit</button>
				</div>
			  </div>
			</form>
		  </div>
		</div>
	</div>
</div>
			
