        <footer class="page-footer font-small bg-dark text-white">
			<div class="footer-copyright text-center py-3">© <?php echo date('Y') ?> Github: <a href="https://github.com/nsk95/SecMessage">Click me</a>
			</div>
	  	</footer>

		<script src="https://code.jquery.com/jquery-3.4.1.min.js"
		integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
		crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>
		{if !empty($js)}
			{foreach $js as $j}
				{literal}
					<script type="text/javascript">
				{/literal}
						{$j}
				{literal}
					</script>
				{/literal}
			{/foreach}
		{/if}
		{if !empty($jsUrl)}
			{foreach $jsUrl as $j2}
				<script src="{$j2}"></script>
			{/foreach}
		{/if}
		{if !empty($messages)}
			{literal}
				<script type="text/javascript">
					$(function() {
						$('.toast').toast('show');
					});
				</script>
			{/literal}
		{/if}
	</body>
</html>