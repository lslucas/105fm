<div class="column grid_10">
	<center>
		<form class="form-signin" name='login' method='post'>
			<input type='hidden' name='from' value='<?=$basename?>'>
			<h2 class="form-signin-heading">Login</h2>
			<input type="text" name='email' class="input-xlarge" placeholder="Email" value='<?=isset($val['email']) ? $val['email'] : null?>'>
			<small class='pull-right'><a href="<?=ABSPATH?>esqueci-senha">esqueceu a senha?</a></small>
			<input type="password" name='senha' class="input-xlarge" placeholder="Senha">

			<label class="checkbox">
				<input type="checkbox" name="remember-me" value='1'<?=isset($val['remember-me']) ? ' checked' : null?>> Lembrar
			</label>
			<button class="btn-agro" type="submit">Login</button>
		</form>
	</center>
</div>