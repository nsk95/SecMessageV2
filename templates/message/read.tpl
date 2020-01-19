
		{include file='head.tpl'}
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center" id="mainbox">
				{if $textPanel != ''}
                <div class="row justify-content-center">
                    <div class="alert alert-danger" role="alert"><strong>Notice:</strong> {$textPanel}</div>
                    {if $passRequired}
                        <form id="passform" method="post">
                            <div class="form-group">
                                <label for="pass">Password:</label>
                                <input type="password" class="form-control" id="pass" name="pass" placeholder="">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    {/if}
                </div>
                {/if}
                {if !$messageRead}
                    <div class="row">
                        <label class="col-sm-3" for="message">Message:</label>
                        <textarea class="form-control col-sm-9" id="message" rows="10">{if $decryptedMessage}{$decryptedMessage}{/if}</textarea>
                    </div>
                {/if}
				</div>
			</div>
		</div>
		{include file='footer.tpl'}