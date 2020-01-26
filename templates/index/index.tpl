
		{include file='head.tpl'}
		<div class="container">
			<div class="row">
				<div class="col-lg-12 justify-content-center" id="mainbox">
					<div id="placeholder"></div>
					<div class="card rounded-5">
						<div class="card-header">
							<h1 class="mb-0">New message</h1>
						</div>
						<div class="card-body">
							<form id="newMessageForm" method="post" autocomplete="off" enctype="multipart/form-data">
								<div class="form-group">
									<div class="col-xs-12">
										<div class="row">
											<label for="message" class="form-control col-sm-3">Message:</label>
											<textarea class="form-control col-sm-9" id="message" aria-describedby="message" required="required" rows="5" name="message"></textarea>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-xs-12">
										<div class="row">
											<label for="file" class="form-control col-sm-3">File:</label>
											<input class="form-control form-control-file col-sm-9" type="file" name="file[]" id="file">
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-xs-12">
										<div class="row">
											<label for="deleteAfterRead" class="form-control col-sm-3">Delete after read?</label>
											<select id="deleteAfterRead" class="form-control col-sm-9" name="deleteAfterRead">
												<option value="1" checked="checked">Yes</option>
												<option value="0">No</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-xs-12">
										<div class="row">
											<label for="pass1" class="form-control col-sm-3">Password (optional):</label>
											<input type="password" class="form-control col-sm-9" id="pass1" aria-describedby="password" name="pass1"></input>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-xs-12">
										<div class="row">
											<label for="pass1" class="form-control col-sm-3">Password repeat:</label>
											<input type="password" class="form-control col-sm-9" id="pass2" aria-describedby="password" name="pass2"></input>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-xs-12">
										<div class="row">
											<label for="sbtbtn" class="col-sm-3"></label>
											<button type ="submit" class="form-control btn btn-primary col-sm-9" id="sbtbtn">Submit</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		{include file='footer.tpl'}