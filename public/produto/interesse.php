	<!-- <div class="row novo-produto"> -->
	<div class="column grid_10">
		<div class="column">
			<h1>Meus Interesses</h1>
			<p><em>Todos os campos com - <span class="color-red">*</span> - são obrigatórios.</em></p>
			<p><br /></p>
		</div>

		<div class="column">
			<form name="interesse" class="form-horizontal" method="post">
				<input type="hidden" name="from" value="interesse">
				<input type="hidden" name="usr_id" value="<?=$usr['id']?>">

				<div class="control-group">
					<label class="control-label" for="pro_id"><span class="color-red">*</span> Produto</label>
					<div class="controls">
					<select name="pro_id" id="pro_id" class="required filtroProduto">
						<?=convertCatList2Option(getTodosProdutos(null, 'Produto'))?>
					</select> <small><a href="javascript:void(0);" class='showOnClick' data-target='#outroProduto'>outro?</a></small>
					</div>

					<div id='outroProduto' class='hide'>
						<br/><label class="control-label" for="nomeProduto"><span class="color-red">*</span> Nome do Produto</label>
						<div class="controls">
							<input type="text" class="input-xlarge" placeholder='Nome do produto' name='nomeProduto' id='nomeProduto' disabled=disabled>
						</div>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="observacao">Observação</label>
					<div class="controls">
						<textarea name='observacao' id='observacao' class='input-xlarge' cols='90' rows='3'></textarea>
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
					      <button type="submit" class="btn-agro">Atualizar lista de interesse</button>
					</div>
				</div>
			</form>
		</div>

		<div class="span10">
			<div class="row lista">
				<table class="lista-produtos" id="alternatecolor" width="100%">
						<tr>
							<th align="left"></th>
							<th width="20px">--</th>
						</tr>
						<tbody>
						<?php
							if (count($listaInteresses)==0)
								echo "<tr><td colspan=6>Você ainda não possui nenhum produto na sua lista de interesses!</td></tr>";
							foreach ($listaInteresses as $id => $lista) {
						?>
							<div class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="rm-<?=$lista['id']?>">
								<div class="modal-header">
									<a class="close" data-dismiss="modal">×</a>
									<h3>Remover</h3>
								</div>
								<div class="modal-body">
								<p>Deseja remover <b><?=$lista['produto']?></b>?<div class='alert alert-warning small'>Você não poderá recuperar esse ítem!</div></p>
								</div>
								<div class="modal-footer">
									<a class="btn" data-dismiss='modal'>Cancelar</a>
									<a id='<?=$lista['id']?>' class="btn-rmInteresse btn btn-danger btn-primary">Remover</a>
								</div>
							</div>
							<tr id='tr<?=$lista['id']?>'>
								<td><?=$lista['produto']?><blockquote><?=$lista['observacao']?></blockquote></td>
								<td align=center>
									<a href='#rm-<?=$lista['id']?>' role='button' data-toggle='modal'  title='Remover item'><i class='icon-remove '></i></a>
								</td>
							</tr>
							<?php } ?>
					</tbody>
				</table>
			</div>
		</div>

	</div>
