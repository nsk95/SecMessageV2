
		{include file='head.tpl'}
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center" id="mainbox">
				{if $textPanel != ''}
                <div class="row justify-content-center">
                    <div class="alert alert-danger" role="alert"><strong>Notice:</strong> {$textPanel}</div>
                    {if !$noForm}
                </div>
                    <div class="row justify-content-center">
                        <form id="passform" method="post">
                            {if $passRequired}
                            <div class="form-group">
                                <label for="pass">Password:</label>
                                <input type="password" class="form-control" id="pass" name="pass" placeholder="">
                            </div>
                            {/if}
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="row">
                                        <button type="submit" class="btn btn-primary col-sm-12">Read message</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    {/if}
                </div>
                {/if}
				</div>
			</div>
		</div>
		{include file='footer.tpl'}