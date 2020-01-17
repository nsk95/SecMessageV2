        <footer class="page-footer font-small bg-dark text-white">
			<div class="footer-copyright text-center py-3">© <?php echo date('Y') ?> Github: <a href="https://github.com/nsk95/SecMessage">Click me</a>
			</div>
	  </footer>

		<script src="https://code.jquery.com/jquery-3.4.1.min.js"
		integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
		crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
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
	</body>
</html>