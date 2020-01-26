
		{include file='head.tpl'}
		<div class="container">
			<div class="row">
				<div class="col-lg-12 justify-content-center" id="mainbox">
                    {if $textPanel != ''}
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="alert alert-danger" role="alert"><strong>Notice:</strong> {$textPanel}</div>
                            </div>
                        </div>
                    {/if}
                    {if $displayMessage}
                    <div class="row justify-content-center">
                        <div class="form-group">
                            <label for="message"></label>
                            <textarea class="form-control" id="message" rows="5" readonly></textarea>
                        </div>
                    </div>
                    {/if}
				</div>
			</div>
		</div>
		{include file='footer.tpl'}