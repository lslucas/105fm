		<div class="column grid_2">
			<?php if (empty($usr['id'])) { ?>
			<aside class="cat">
				<section>
					<h4>Login</h4>
					<form name='login' method='post'>
						<input type='hidden' name='from' value='login'>
						<input type="text" name="email" value="" placeholder="Email" />
						<br/>
						<small class='pull-left'><a href="<?=ABSPATH?>esqueci-senha">esqueceu a senha?</a></small>
						<input type="password" name="senha" value="" placeholder="Senha" />
						<input type="submit" name="login" value="Login" />
					</form>
				</section>
			</aside>

			<?php } ?>

			<aside class="ads">
				<section>
					<?=bannerLaterial($banners, 1)?>
				</section>

				<section>
					<?=bannerLaterial($banners, 2)?>
				</section>
			</aside>
		</div>