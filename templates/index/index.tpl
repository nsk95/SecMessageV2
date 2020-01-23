
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
						<div class="form-group">
							<div class="col-xs-12">
								<div class="row">
									<label for="file" class="col-sm-3">File:</label>
									{* <div class="container" > *}
										<input class="form-control col-sm-9" type="file" name="file[]" id="file">
										
										<!-- Drag and Drop container-->
										<div class="upload-area"  id="uploadfile">
											<h1 id="file_h1">Drag and Drop file here<br/>Or<br/>Click to select file</h1>
										</div>
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