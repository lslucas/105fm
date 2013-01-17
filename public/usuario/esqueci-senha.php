<div class="column grid_10">
	<center>
		<form class="form-signin" name='login' method='post'>
			<input type='hidden' name='from' value='<?=$basename?>'>
			<h2 class="form-signin-heading">Esqueci a senha</h2>
			<input type="text" name='email' class="input-xlarge" placeholder="Email" value='<?=isset($val['email']) ? $val['email'] : null?>'>

			<button class="btn-agro" type="submit">Gerar nova senha</button>
		</form>
	</center>
</div>