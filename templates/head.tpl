<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
  		<title>SecMessage by Spyro / nsk95</title>
  		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		{if !empty($css)}
			{foreach $css as $c}
				{literal}
					<style>
				{/literal}
					{$c}
				{literal}
					</style>
				{/literal}
			{/foreach}
		{/if}
		{if !empty($cssUrl)}
			{foreach $ccsUrl as $u}
				<link href="{$u}" rel="stylesheet">
			{/foreach}
		{/if}
	</head>
	<body>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
			<div class="container">
				<a class="navbar-brand" href="#">Sec Message - Start secure messaging</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarResponsive">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item active">
							<a class="nav-link" href="/">Start
								<span class="sr-only">(current)</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		{if !empty($messages)}
			<div class="position-absolute w-100 p-4 d-flex flex-column align-items-end">
				<div class="w-25">
					{foreach $messages as $m}
						<div class="toast ml-auto sysmsg-{$m.type}" role="alert" data-delay="1000" data-autohide="false">
							<div class="toast-header">
								<strong class="mr-auto text-primary">{if !empty($m.title)}{$m.title}{else}{$m.type|ucfirst}{/if}</strong>
								<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
									<span aria-hidden="true">×</span>
								</button>
							</div>
							<div class="toast-body">
								{$m.message}
							</div>
						</div>
					{/foreach}
				</div>
			</div>
			{literal}
				<script type="text/javascript">
					$(function() {
						$('.toast').toast('show');
					});
				</script>
			{/literal}
		{/if}