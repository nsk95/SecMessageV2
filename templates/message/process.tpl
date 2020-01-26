
		{include file='head.tpl'}
		<div class="container">
			<div class="row">
				<div class="col-lg-12 justify-content-center" id="mainbox">
                    <div class="card rounded-5">
                        <div class="card-body">
                            {if $textPanel != ''}
                            <div class="col-xs-12">
                                <div class="row justify-content-center">
                                    <div class="alert alert-danger" role="alert"><strong>Notice:</strong> {$textPanel}</div>
                                </div>
                            </div>
                            {/if}
                            {if $displayMessage}
                            <div class="row justify-content-center">
                                <div class="form-group">
                                    <div class="row">
                                        <textarea class="form-control col-xs-12" id="message" rows="5" readonly></textarea>
                                    </div>
                                </div>
                            </div>
                            {/if}
                        </div>
                    </div>
				</div>
			</div>
		</div>
		{include file='footer.tpl'}