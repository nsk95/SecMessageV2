
		{include file='head.tpl'}
		<div class="container">
			<div class="row">
				<div class="col-lg-12 justify-content-center" id="mainbox">
                    {if $textPanel != ''}
                    <br /> <br />
                    <div class="col-xs-12">
                        <div class="row justify-content-center">
                            <div class="alert alert-danger" role="alert"><strong>Notice:</strong> {$textPanel}</div>
                        </div>
                    </div>
                    {if !$noForm}
                    <div class="col-xs-12">
                        <div class="row justify-content-center">
                            <form id="passform" method="post" action="/message/process">
                                <input type="hidden" id="idMessage" name="idMessage" value="{$idMessage}">
                                {if $passRequired}
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="row">
                                            <label for="pass" class="form-control col-sm-4">Password:</label>
                                            <input type="password" class="form-control col-sm-8" id="pass" name="pass" placeholder="" required="required">
                                        </div>
                                    </div>
                                </div>
                                {/if}
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="row">
                                            <button type="submit" id="sbtbtn" class="form-control btn btn-primary col-sm-12">Read message</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    {/if}
                {/if}
				</div>
			</div>
		</div>
		{include file='footer.tpl'}