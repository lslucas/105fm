<?php

class Classificado {

	public function __construct()
	{
		$this->_args = null;
		$args = array();
	}

	private function validaParametros()
	{
		global $hashids;

		$args = $this->_args;
		if (!is_array($args))
			exit(__FUNCTION__.' Parâmetros inválidos!');

		$return = null;

		if (!isset($args['usr_id']) || empty($args['usr_id']))
			$return .= '<li>Sua sessão expirou! Faça <a href=\''.ABSPATH.'login\'>login</a> novamente</li>';
		else {

			if (empty($args['tipo']) && empty($args['nomeTipo']))
				$return .= '<li>Selecione um tipo ou informe um novo clicando em outro</li>';
			if (empty($args['titulo']))
				$return .= '<li>Informe o nome do produto de sua oferta</li>';
			// if (empty($args['valor']))
				// $return .= '<li>Digite o valor do produto</li>';
			if (empty($args['descricao']))
				$return .= '<li>Descreva seu produto no campo Descrição</li>';

			if (!is_numeric($this->_args['usr_id'])) {
				$usr_id = $hashids->decrypt($this->_args['usr_id']);
				$this->_args['usr_id'] = $usr_id[0];
			}

		}

		if (empty($return))
			return true;
		else return $return;
	}

	public function validaAjax($args)
	{
		$this->_args = $args;
		$return  = true;
		if (!$this->valida())
			$return = array('error'=>'Oferta já foi cadastrada!');

		return $return;
	}

	public function nova($args)
	{
		$this->_args = $args;
		$res = $this->validaParametros($args);
		$return = array();
		if ($res === true) {

			if ($this->valida()) {

				if ($this->grava())
					$return['success'] = array('text'=>'Classificado registrado com sucesso!', 'cols'=>array('id'=>$this->getLastId()));
				else
					$return['error'] = array('text'=>'Houve algum problema!');

			} else $return['error'] = array('text'=>'Você já cadastrou esse classificado antes!');

		} else
			$return['error'] = array('text'=>$res, 'title'=>'Corrija o formulário abaixo');

		return $return;
	}

	public function atualiza($args)
	{

		$this->_args = $args;
		$res = $this->validaParametros('atualiza');
		$return = array();
		if ($res === true) {

			if ($this->valida()) {

				if ($this->update())
					$return['success'] = array('text'=>'Atualizado com sucesso!', 'cols'=>array('id'=>$this->getLastId()));
				else
					$return['error'] = array('text'=>'Houve algum problema!');

			} else $return['error'] = array('text'=>'Oferta já foi cadastrada anteriormente!');

		} else
			$return['error'] = array('title'=>'Corrija o formulário abaixo', 'text'=>$res);

		return $return;
	}

	/**
	 * Valida se cadastro já existe
	 * @return bool
	 */
	private function valida()
	{
		global $conn, $hashids, $usr;

		$sufix = null;
		if (!empty($this->_args['id'])) {
			$id = $hashids->decrypt($this->_args['id']);
			$id = $id[0];
			$sufix = " AND `ucl_id`<>".$id;
		}

		$sql = "SELECT SQL_CACHE NULL FROM `".TP."_usuario_classificado`
					WHERE `ucl_usr_id`=?
							AND `ucl_tipo`=?
							AND `ucl_titulo`=?
							AND DATE(`ucl_timestamp`)=DATE(NOW())
							{$sufix}";
		if (!$res = $conn->prepare($sql))
			echo __FUNCTION__.$conn->error;
		else {
			$res->bind_param('iis', $usr['id'], $this->_args['tipo'], $this->_args['titulo']);
			$res->execute();
			$res->store_result();
			$num = $res->num_rows;
			$res->close();
		}

		if ($num>0) return false;
		else return true;
	}

	/**
	 * Compra existe
	 * @return bool
	 */
	public function existe($id)
	{
		global $conn, $hashids;

		if (!empty($id) && !is_numeric($id)) {
			$id = $hashids->decrypt($id);
			$id = isset($id[0]) ? $id[0] : null;
		}

		if (empty($id))
			return 'ID inválido!';

		$sql = "SELECT SQL_CACHE NULL FROM `".TP."_usuario_classificado` WHERE ucl_status=1 AND `ucl_id`=?";
		if (!$res = $conn->prepare($sql))
			echo __FUNCTION__.$conn->error;
		else {
			$res->bind_param('i', $id);
			$res->execute();
			$res->store_result();
			$num = $res->num_rows;
			$res->close();
		}

		if ($num>0) return true;
		else return false;
	}

	private function grava()
	{
		global $conn, $usr;

		if ($this->valida()) {

			$sqlins = "INSERT INTO `".TP."_usuario_classificado`
							(
							 `ucl_usr_id`,
							 `ucl_tipo`,
							 `ucl_nomeTipo`,
							 `ucl_titulo`,
							 `ucl_modelo`,
							 `ucl_valor`,
							 `ucl_descricao`,
							 `ucl_observacao`,
							 `ucl_ip`
							 ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
			if (!$qryins = $conn->prepare($sqlins))
				echo __FUNCTION__.$conn->error;
				// return false;
			else {

				$this->_args['valor'] = Currency2Decimal($this->_args['valor'], 1);
				$qryins->bind_param('iisssdsss',
				                    	$this->_args['usr_id'],
				                    	$this->_args['tipo'],
				                    	$this->_args['nomeTipo'],
				                    	$this->_args['titulo'],
				                    	$this->_args['modelo'],
				                    	$this->_args['valor'],
				                    	$this->_args['descricao'],
				                    	$this->_args['observacao'],
				                    	$_SERVER['REMOTE_ADDR']
				                    );
				$qryins->execute();
				$qryins->close();

				return true;
			}

		} else return false;
	}

	private function update()
	{
		global $conn, $hashids, $usr;

		$ucl_id = $this->_args['id'];
		if (!is_numeric($ucl_id)) {
			$ucl_id = $hashids->decrypt($ucl_id);
			$ucl_id = $ucl_id[0];
		}

		$sqlupd = "UPDATE `".TP."_usuario_classificado`
						SET
						 `ucl_tipo`=?,
						 `ucl_nomeTipo`=?,
						 `ucl_titulo`=?,
						 `ucl_modelo`=?,
						 `ucl_valor`=?,
						 `ucl_descricao`=?,
						 `ucl_observacao`=?,
						 `ucl_ip`=?
						 WHERE `ucl_id`=? AND `ucl_usr_id`=?";
		if (!$qryupd = $conn->prepare($sqlupd))
			echo __FUNCTION__.$conn->error;
			// return false;

		else {

			$this->_args['valor'] = Currency2Decimal($this->_args['valor'], 1);
			$qryupd->bind_param('isssdsssii',
			                    	$this->_args['tipo'],
			                    	$this->_args['nomeTipo'],
			                    	$this->_args['titulo'],
			                    	$this->_args['modelo'],
			                    	$this->_args['valor'],
			                    	$this->_args['descricao'],
			                    	$this->_args['observacao'],
			                    	$_SERVER['REMOTE_ADDR'],
			                    	$ucl_id,
			                    	$this->_args['usr_id']
			                    );
			$qryupd->execute();
			$qryupd->close();

			return true;
		}

	}

	/**
	 * Dados
	 * @return bool
	 */
	public function getInfoById($id)
	{
		global $conn, $hashids;

		if (!is_numeric($id)) {
			$id = $hashids->decrypt($id);
			$id = $id[0];
		}
		$cpr=array();

		$sql = "SELECT
					COALESCE(NULLIF(usr_nome_fantasia,''), usr_nome) `embalagem`,
					ucl_id,
					ucl_usr_id,
					ucl_tipo,
					COALESCE(NULLIF((SELECT cat_titulo FROM ".TP."_categoria WHERE cat_id=ucl_tipo),''), ucl_nomeTipo) `embalagem`,
					ucl_titulo `titulo`,
					ucl_modelo,
					ucl_valor,
					ucl_descricao,
					ucl_observacao,
					ucl_views,
					ucl_status,
					adb_cidade,
					adb_uf,
					DATE_FORMAT(ucl_timestamp, '%d/%m/%Y')
					FROM `".TP."_usuario_classificado`
					LEFT JOIN `".TP."_usuario`
						ON usr_id=ucl_usr_id
					LEFT JOIN ".TP."_address_book
						ON adb_usr_id=ucl_usr_id
					WHERE  `ucl_status`=1
							AND`ucl_id`=?;";
		if (!$res = $conn->prepare($sql))
			echo __FUNCTION__.$conn->error;
		else {

			$res->bind_param('i', $id);
			$res->bind_result($empresa, $ucl_id, $usr_id, $tipo_id, $tipo, $titulo, $modelo, $valor, $descricao, $observacao, $views, $status, $cidade, $uf, $timestamp);
			$res->execute();
			$res->store_result();
			$res->fetch();
			$res->close();

			if (!empty($ucl_id)) {

				$valor = empty($valor) || $valor=='0.00' ? 'Sob consulta' : 'R$ '.Currency2Decimal($valor);
				$id_encrypted = $hashids->encrypt($ucl_id);
				$cpr = array(
			             'id'=>$id_encrypted,
			             'usr_id'=>$hashids->encrypt($usr_id),
			             'empresa'=>mb_strtoupper($empresa, 'utf8'),
			             'tipo_id'=>$tipo_id,
			             'tipo'=>$tipo,
			             'titulo'=>mb_strtoupper($titulo, 'utf8'),
			             'modelo'=>$modelo,
			             'valor'=>$valor,
			             'descricao'=>$descricao,
			             'observacao'=>$observacao,
			             'link'=>ABSPATH."ver-oferta/{$id_encrypted}/".linkfySmart($titulo),
			             'cidade'=>$cidade,
			             'uf'=>(empty($uf) ? '--' : $uf),
			             'observacao'=>$observacao,
			             'estado'=>estadoFromUF($uf),
			             'views'=>$views,
			             'status'=>$status,
			             'timestamp'=>$timestamp
		             );

				return $cpr;

			} else
				return false;
		}

	}

	public function getMyItens($usr_id)
	{
		global $conn, $hashids;

		if (empty($usr_id))
			return array();

		if (!is_numeric($usr_id)) {
			$usr_id = $hashids->decrypt($usr_id);
			$usr_id = $usr_id[0];
		}

		$cpr=array();
		$listMyItens = array();

		$sql = "
				SELECT * FROM (
					SELECT
						ucl_id,
						ucl_titulo `titulo`
					FROM `".TP."_usuario_classificado`
					INNER JOIN ".TP."_usuario
						ON ucl_usr_id=usr_id
						AND usr_status=1
					WHERE ucl_status=1
						AND ucl_usr_id=?
					) as `tmp`
				ORDER BY titulo";
		if (!$res = $conn->prepare($sql))
			echo __FUNCTION__.$conn->error;
		else {
			$res->bind_param('i', $usr_id);
			$res->bind_result($ucl_id, $titulo);
			$res->execute();

			while ($res->fetch()) {
				array_push($listMyItens, $ucl_id);
			}

			$res->close();

			foreach ($listMyItens as $ucl_id)
				$cpr[$ucl_id]  = $this->getInfoById($ucl_id);

			return $cpr;

		}
	}

	public function listaGeral($filtro)
	{
		global $conn, $hashids, $urlParams, $catIdByTituloMin;

		$cpr=array();
		$list= array();

		$getFiltros = $this->getFiltros($filtro);
		$filtro = $getFiltros['filtro'];
		$whr = $getFiltros['whr'];

		$sql = "SELECT * FROM (
					SELECT
						ucl_id,
						ucl_usr_id,
						adb_uf,
						ucl_valor,
						ucl_titulo `titulo`
					FROM `".TP."_usuario_classificado`
					INNER JOIN ".TP."_usuario
						ON ucl_usr_id=usr_id
						AND usr_status=1
					LEFT JOIN ".TP."_address_book
						ON adb_usr_id=ucl_usr_id
					WHERE ucl_status=1
				) as `tmp`
				WHERE 1
					{$whr}
				ORDER BY ucl_titulo";
		if (!$res = $conn->prepare($sql))
			echo __FUNCTION__.$conn->error;
		else {
			$res->bind_result($ucl_id, $usr_id, $uf, $valor, $titulo);
			$res->execute();

			while ($res->fetch())
				array_push($list, $ucl_id);

			$res->close();

			foreach ($list as $ucl_id)
				$cpr[$ucl_id]  = $this->getInfoById($ucl_id);

			return $cpr;

		}
	}

	private function howManyItensInUF($whrFiltro)
	{
		global $conn;

		/**
		 * Conta o numero de produtos por estado
		 * @var string
		 */
		$sql = "SELECT * FROM (
					SELECT
						ucl_usr_id,
						adb_uf,
						ucl_valor,
						ucl_id,
						ucl_titulo `titulo`
					FROM `".TP."_usuario_produto`
					INNER JOIN ".TP."_usuario
						ON ucl_usr_id=usr_id
						AND usr_status=1
					LEFT JOIN ".TP."_address_book
						ON adb_usr_id=ucl_usr_id
					WHERE ucl_status=1
					) as `tmp`
					WHERE 1
					{$whrFiltro}
					ORDER BY adb_uf";
		if (!$res= $conn->prepare($sql))
			return false;
		else {

			$res->bind_result($usr_id, $uf, $valor, $ucl_id, $titulo);
			$res->execute();

			$lst = array();
			while ($res->fetch()) {
				$uf = !empty($uf) ? $uf : 'vazio';
				$lst[$uf][$ucl_id] = $titulo;
			}
			$res->close();

			//conta qts itens tem em cada estado
			$listaUF = array();
			foreach ($lst as $key=>$lista)
				$listaUF[$key] = count($lista);

			return $listaUF;
		}
	}

	public function filtroCategorias($filtro)
	{
		global $conn, $hashids;

		$listUf = $listPreco = array();
		$getFiltros = $this->getFiltros($filtro);
		$filtro = $getFiltros['filtro'];
		$whr = $getFiltros['whr'];


		// filtra query apenas com as infos que nao pertencem ao filtro
		$whrFiltro = $getFiltros['whrFiltro'];
		unset($whrFiltro['uf']);
		unset($whrFiltro['faixapreco']);
		$whrFiltro = join(' ', $whrFiltro);
		$num = $this->howManyItensInUF($whrFiltro);

		/**
		 * Query do Filtro de Localidade
		 * @var string
		 */
		$sqluf = "SELECT * FROM (
					SELECT
						ucl_usr_id,
						adb_uf,
						ucl_valor,
						ucl_titulo `titulo`
					FROM `".TP."_usuario_produto`
					INNER JOIN ".TP."_usuario
						ON ucl_usr_id=usr_id
						AND usr_status=1
					LEFT JOIN ".TP."_address_book
						ON adb_usr_id=ucl_usr_id
					WHERE ucl_status=1
					) as `tmp`
					WHERE 1
					{$whrFiltro}
					GROUP BY adb_uf
					ORDER BY adb_uf";
		if (!$resuf = $conn->prepare($sqluf))
			echo __FUNCTION__.$conn->error;
		else {

			$resuf->bind_result($usr_id, $uf, $valor, $titulo);
			$resuf->execute();

			$i=0;
			while ($resuf->fetch()) {
				$ufmin = strtolower($uf);
				$estado = estadoFromUF($uf);
				$ufIndex = empty($uf) ? 'vazio' : $uf;
				$numUF = isset($num[$ufIndex]) ? $num[$ufIndex] : '-';

				$listUf[$i]['uf'] = $uf;
				$listUf[$i]['estado'] = $estado;
				$listUf[$i]['num'] = $numUF;

				if (isset($filtro['filtroUF']) && $filtro['filtroUF']==$ufmin)
					$listUf[$i]['link'] = "{$estado} ({$numUF})";
				else
					$listUf[$i]['link'] = "<a href='".ABSPATH."lista/uf-{$ufmin}'>{$estado}</a> ({$numUF})";

				$i++;
			}

			$resuf->close();
		}


		$list = array('localizacao'=>$listUf);
		return $list;

	}

	private function getFiltros($filtro)
	{
		global $urlParams, $catIdByTituloMin;

		$whr = null;
		$whrFiltro = array();
		$filtro = array();
		$lstFiltros = array('fabricante'=>'Fabricante', 'grupoquimico'=>'GrupoQuimico', 'produto'=>'Produto', 'faixapreco'=>'FaixaPreco', 'tipo'=>'Tipo', 'uf'=>'UF', 'preco'=>'Preco', 'revenda'=>'Revenda');
		foreach ($urlParams as $params) {
			list($filtroName, $valParam) = explode('-', $params, 2);
			if (in_array($filtroName, array('fabricante', 'grupoquimico', 'tipo')) && isset($catIdByTituloMin[$valParam]))
				$filtro['filtro'.$lstFiltros[$filtroName]] = $catIdByTituloMin[$valParam];
			else
				$filtro['filtro'.$lstFiltros[$filtroName]] = trim($valParam);
		}

		if (is_array($filtro) && count($filtro)>0) {
			if (isset($filtro['filtroProduto']) && !empty($filtro['filtroProduto'])) {
				$filtroProduto = urldecode($filtro['filtroProduto']);
				$whrProduto = " AND (titulo LIKE \"%{$filtro['filtroProduto']}%\"";
				$whrProduto .= " OR titulo LIKE \"%{$filtroProduto}%\") ";
				$whr .= $whrProduto;
				$whrFiltro['produto'] = $whrProduto;

			} if (isset($filtro['filtroRevenda']) && !empty($filtro['filtroRevenda'])) {
				$getUsuarios = getUsuarios(false);

				if (isset($getUsuarios[$filtro['filtroRevenda']])) {
					$filtro['filtroRevenda'] = $getUsuarios[$filtro['filtroRevenda']]['id_numeric'];
					$whrRevenda = " AND ucl_usr_id=\"{$filtro['filtroRevenda']}\"";
					$whr .= $whrRevenda;
					$whrFiltro['revenda'] = $whrRevenda;
				}

			} if (isset($filtro['filtroUF'])) {
				$whrUF = " AND LOWER(adb_uf)=\"{$filtro['filtroUF']}\"";
				$whr .= $whrUF;
				$whrFiltro['uf'] = $whrUF;

			} if (isset($filtro['filtroFaixaPreco']) && !empty($filtro['filtroFaixaPreco'])) {
				$faixaPreco = $filtro['filtroFaixaPreco'];

				if ($faixaPreco=='750')
					$whrFaixaPreco = " AND (ucl_valor IS NULL OR ucl_valor<=750) ";
				elseif ($faixaPreco=='750a2000')
					$whrFaixaPreco = " AND ucl_valor BETWEEN 750.01 AND 2000";
				elseif ($faixaPreco=='mais2000')
					$whrFaixaPreco = " AND ucl_valor>2000.01";

				$whr .= $whrFaixaPreco;
				$whrFiltro['faixapreco'] = $whrFaixaPreco;

			}
		}

		return array('filtro'=>$filtro, 'whrFiltro'=>$whrFiltro, 'whr'=>$whr);
	}

	/**
	 * Resgata último produto
	 * @return bool
	 */
	public function getLastId()
	{
		global $conn;

		$usr_id = $this->_args['usr_id'];
		$titulo = $this->_args['titulo'];
		$valor = $this->_args['valor'];

		$sql = "SELECT ucl_id FROM `".TP."_usuario_classificado` WHERE `ucl_usr_id`=? AND `ucl_titulo`=? AND ucl_valor=?;";
		if (!$res = $conn->prepare($sql))
			echo __FUNCTION__.$conn->error;
		else {
			$res->bind_param('isd', $usr_id, $titulo, $valor);
			$res->bind_result($id);
			$res->execute();
			$res->fetch();
			$res->close();
		}

		if (!empty($id)) return $id;
		else return false;
	}

	/**
	 * Remove compra do usuario
	 * @return bool
	 */
	public function remover($args)
	{
		global $conn, $hashids, $usr;

		if (!isset($usr['id']) || empty($usr['id']))
			return 'Usuário não logado!';

		$ucl_id = $hashids->decrypt($args['id']);
		$ucl_id = $ucl_id[0];
		$usr_id = $hashids->decrypt($usr['id']);
		$usr_id = $usr_id[0];

		$sql = "UPDATE `".TP."_usuario_classificado` SET `ucl_status`=0 WHERE `ucl_id`=? AND `ucl_usr_id`=?;";
		if (!$res = $conn->prepare($sql))
			return false;
		else {
			$res->bind_param('ii', $ucl_id, $usr_id);
			$res->execute();
			$res->close();

			return true;
		}

	}

	/**
	 * Adiciona +1 view
	 * @return bool
	 */
	public function plusView($ucl_id)
	{
		global $conn, $hashids;

		if (!isset($ucl_id) || empty($ucl_id))
			return 'ID inválido!';

		if (!is_numeric($ucl_id)) {
			$ucl_id = $hashids->decrypt($ucl_id);
			$ucl_id = isset($ucl_id[0]) ? $ucl_id[0] : null;
		}

		if (empty($ucl_id))
			return 'ID inválido';

		$sql = "UPDATE `".TP."_usuario_classificado` SET `ucl_views`=`ucl_views`+1 WHERE `ucl_id`=?;";
		if (!$res = $conn->prepare($sql))
			return false;
		else {
			$res->bind_param('i', $ucl_id);
			$res->execute();
			$res->close();

			return true;
		}

	}
}