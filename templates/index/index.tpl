
		{include file='head.tpl'}
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center" id="mainbox">
					<div id="placeholder"></div>
					<h1 class="mt-5">New message</h1>
					<form id="newMessageForm" method="post" autocomplete="off" enctype="multipart/form-data">
						<div class="form-group">
							<div class="col-xs-12">
								<div class="row">
									<label for="message" class="col-sm-3">Message:</label>
									<textarea class="form-control col-sm-9" id="message" aria-describedby="message" required="required" rows="5" name="message"></textarea>
								</div>
							</div>
						</div>
						<div class="form-group box">
							<div class="col-xs-12">
								<div class="row">
									<div class="box__input">
										<input class="box__file" type="file" name="files[]" id="file"/>
										<label for="file" id="label_file"><strong>Choose a file</strong><span class="box__dragndrop"> or drag it here</span>.</label>
									</div>
									<div class="box__uploading">Uploading&hellip;</div>
									<div class="box__success">Done!</div>
									<div class="box__error">Error! <span></span>.</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12">
								<div class="row">
									<label for="deleteAfterRead" class="col-sm-3">Delete after read?</label>
									<select id="deleteAfterRead" name="deleteAfterRead">
										<option value="1" checked="checked">Yes</option>
										<option value="0">No</option>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12">
								<div class="row">
									<label for="pass1" class="col-sm-3">Password (optional):</label>
									<input type="password" class="form-control col-sm-9" id="pass1" aria-describedby="password" name="pass1"></input>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12">
								<div class="row">
									<label for="pass1" class="col-sm-3">Password repeat:</label>
									<input type="password" class="form-control col-sm-9" id="pass2" aria-describedby="password" name="pass2"></input>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12">
								<div class="row">
									<label for="sbtbtn" class="col-sm-3"></label>
									<button class="btn btn-primary col-sm-9" id="sbtbtn">Submit</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		{include file='footer.tpl'}