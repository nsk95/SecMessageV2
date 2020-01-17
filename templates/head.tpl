<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
  		<title>SecMessage by Spyro / nsk95</title>
  		<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
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