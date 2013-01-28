<?php

class Interesse {

	public function __construct()
	{
		$this->_cupom = null;
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

			if (empty($args['pro_id']) && empty($args['nomeProduto']))
				$return .= '<li>Selecione um produto ou informe um nome clicando em outro</li>';

			if (!is_numeric($this->_args['usr_id'])) {
				$usr_id = $hashids->decrypt($this->_args['usr_id']);
				$this->_args['usr_id'] = $usr_id[0];
			}
		}

		if (empty($return))
			return true;
		else return $return;
	}

	public function validaInteresseAjax($args)
	{
		$this->_args = $args;
		$return  = true;
		if (!$this->validaInteresse())
			$return = array('error'=>'Interesse já foi cadastrado!');

		return $return;
	}

	public function novoInteresse($args)
	{

		$this->_args = $args;
		$res = $this->validaParametros($args);

		$return = array();
		if ($res === true) {
			if ($this->validaInteresse()) {

				if ($this->gravaInteresse())
					$return['success'] = array('text'=>'Interesse registrado com sucesso!', 'cols'=>array('id'=>$this->getLastId()));
				else
					$return['error'] = array('text'=>'Houve algum problema!');

			} else $return['error'] = array('text'=>'Você já cadastrou esse interesse antes!');

		} else
			$return['error'] = array('text'=>$res, 'title'=>'Corrija o formulário abaixo');

		return $return;
	}

	/**
	 * Valida se cadastro [cpf] já existe
	 * @return bool
	 */
	private function validaInteresse()
	{
		global $conn, $hashids;

		$sufix = null;
		if (!empty($this->_args['id'])) {
			$id = $hashids->decrypt($this->_args['id']);
			$id = $id[0];
			$sufix = " AND `uin_id`<>".$id;
		}

		if (!empty($this->_args['pro_id']))
			$sql = "SELECT SQL_CACHE NULL FROM `".TP."_usuario_interesse` WHERE `uin_usr_id`=? AND `uin_pro_id`=? {$sufix}";
		else
			$sql = "SELECT SQL_CACHE NULL FROM `".TP."_usuario_interesse` WHERE `uin_usr_id`=? AND `uin_nomeProduto`=? {$sufix}";
		if (!$res = $conn->prepare($sql))
			echo __FUNCTION__.$conn->error;
		else {
			if (!empty($this->_args['pro_id']))
				$res->bind_param('ii', $this->_args['usr_id'], $this->_args['pro_id']);
			else
				$res->bind_param('is', $this->_args['usr_id'], $this->_args['nomeProduto']);
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
	public function interesseExiste($id)
	{
		global $conn, $hashids;

		if (!empty($id) && !is_numeric($id)) {
			$id = $hashids->decrypt($id);
			$id = isset($id[0]) ? $id[0] : null;
		}

		if (empty($id))
			return 'ID inválido!';

		$sql = "SELECT SQL_CACHE NULL FROM `".TP."_usuario_interesse` WHERE uin_status=1 AND `uin_id`=?";
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

	private function gravaInteresse()
	{
		global $conn;

		if ($this->validaInteresse()) {

			$sqlins = "INSERT INTO `".TP."_usuario_interesse`
							(
							 `uin_usr_id`,
							 `uin_pro_id`,
							 `uin_nomeProduto`,
							 `uin_observacao`,
							 `uin_ip`
							 ) VALUES (?, ?, ?, ?, ?)";
			if (!$qryins = $conn->prepare($sqlins))
				echo __FUNCTION__.$conn->error;
				// return false;
			else {

				$qryins->bind_param('iisss',
				                    	$this->_args['usr_id'],
				                    	$this->_args['pro_id'],
				                    	$this->_args['nomeProduto'],
				                    	$this->_args['observacao'],
				                    	$_SERVER['REMOTE_ADDR']
				                    );
				$qryins->execute();
				$qryins->close();

				return true;
			}

		} else return false;
	}

	public function exitemProdutosEmInteresse()
	{
		global $conn, $hashids, $usr;

		$cpr=array();
		$list= array();

		if (!is_numeric($usr['id'])) {
			$usr_id = $hashids->decrypt($usr['id']);
			$usr_id = isset($usr_id[0]) ? $usr_id[0] : null;
		} else
			$usr_id = $usr['id'];

		if (empty($usr_id))
			return false;

		$sql = "SELECT * FROM (
					SELECT
						COUNT(upr_id)
					FROM `".TP."_usuario_produto`
					INNER JOIN ".TP."_usuario_interesse
						ON upr_usr_id<>uin_usr_id
					INNER JOIN ".TP."_usuario
						ON upr_usr_id=usr_id
						AND usr_status=1
					LEFT JOIN ".TP."_address_book
						ON adb_usr_id=upr_usr_id
					LEFT JOIN `".TP."_produto`
						ON `pro_id`=`upr_pro_id`
					WHERE upr_status=1
						AND uin_usr_id=\"{$usr_id}\"
						AND (uin_pro_id=pro_id OR upr_nomeProduto LIKE CONCAT('%', uin_nomeProduto, '%'))
				) as `tmp`";
		if (!$res = $conn->prepare($sql))
			echo __FUNCTION__.$conn->error;
		else {

			$res->bind_result($num);
			$res->execute();
			$res->fetch();
			$res->close();

			return $num;
		}
	}

	public function listaPessoalByInteresse($filtro)
	{
		global $conn, $hashids, $urlParams, $catIdByTituloMin, $usr;

		$cpr=array();
		$list= array();

		$getFiltros = $this->getFiltros($filtro);
		$filtro = $getFiltros['filtro'];
		$whr = $getFiltros['whr'];

		if (!is_numeric($usr['id'])) {
			$usr_id = $hashids->decrypt($usr['id']);
			$usr_id = isset($usr_id[0]) ? $usr_id[0] : null;
		} else
			$usr_id = $usr['id'];

		if (empty($usr_id))
			return false;

		$sql = "SELECT * FROM (
					SELECT
						upr_id,
						pro_grupoquimico,
						pro_fabricante,
						upr_usr_id,
						adb_uf,
						upr_valor,
						COALESCE(NULLIF(pro_titulo,''), upr_nomeProduto) `produto`
					FROM `".TP."_usuario_produto`
					INNER JOIN ".TP."_usuario_interesse
						ON upr_usr_id<>uin_usr_id
					INNER JOIN ".TP."_usuario
						ON upr_usr_id=usr_id
						AND usr_status=1
					LEFT JOIN ".TP."_address_book
						ON adb_usr_id=upr_usr_id
					LEFT JOIN `".TP."_produto`
						ON `pro_id`=`upr_pro_id`
					WHERE upr_status=1
						AND uin_usr_id=\"{$usr_id}\"
						AND (uin_pro_id=pro_id OR upr_nomeProduto LIKE CONCAT('%', uin_nomeProduto, '%'))
				) as `tmp`
				WHERE 1
					{$whr}
				ORDER BY produto";
		if (!$res = $conn->prepare($sql))
			echo __FUNCTION__.$conn->error;
		else {
			$res->bind_result($upr_id, $grupoquimico, $fabricante, $usr_id, $uf, $valor, $produto);
			$res->execute();

			while ($res->fetch())
				array_push($list, $upr_id);

			$res->close();

			foreach ($list as $upr_id)
				$cpr[$upr_id]  = $this->getInfoById($upr_id);

			// $this->listaGeralByInteresse = $cpr;
			return $cpr;

		}
	}

	public function listaGeralByInteresse($filtro)
	{
		global $conn, $hashids, $urlParams, $catIdByTituloMin, $usr;

		$cpr=array();
		$list= array();

		$getFiltros = $this->getFiltros($filtro);
		$filtro = $getFiltros['filtro'];
		$whr = $getFiltros['whr'];

		if (!is_numeric($usr['id'])) {
			$usr_id = $hashids->decrypt($usr['id']);
			$usr_id = isset($usr_id[0]) ? $usr_id[0] : null;
		} else
			$usr_id = $usr['id'];

		if (empty($usr_id))
			return false;

		$sql = "SELECT * FROM (
					SELECT
						upr_id,
						pro_grupoquimico,
						pro_fabricante,
						upr_usr_id,
						adb_uf,
						upr_valor,
						COALESCE(NULLIF(pro_titulo,''), upr_nomeProduto) `produto`
					FROM `".TP."_usuario_produto`
					INNER JOIN ".TP."_usuario_interesse
						ON upr_usr_id<>uin_usr_id
					INNER JOIN ".TP."_usuario
						ON upr_usr_id=usr_id
						AND usr_status=1
					LEFT JOIN ".TP."_address_book
						ON adb_usr_id=upr_usr_id
					LEFT JOIN `".TP."_produto`
						ON `pro_id`=`upr_pro_id`
					WHERE upr_status=1
						AND uin_usr_id<>\"{$usr_id}\"
						AND (uin_pro_id=pro_id OR upr_nomeProduto LIKE CONCAT('%', uin_nomeProduto, '%'))
				) as `tmp`
				WHERE 1
					{$whr}
				ORDER BY produto";
		if (!$res = $conn->prepare($sql))
			echo __FUNCTION__.$conn->error;
		else {
			$res->bind_result($upr_id, $grupoquimico, $fabricante, $usr_id, $uf, $valor, $produto);
			$res->execute();

			while ($res->fetch())
				array_push($list, $upr_id);

			$res->close();

			foreach ($list as $upr_id)
				$cpr[$upr_id]  = $this->getInfoById($upr_id);

			// $this->listaGeralByInteresse = $cpr;
			return $cpr;

		}
	}

	/**
	 * Dados
	 * @return bool
	 */
	public function getSimpleInfoById($id)
	{
		global $conn, $hashids;

		if (!is_numeric($id)) {
			$id = $hashids->decrypt($id);
			$id = $id[0];
		}

		$list = array();
		$sql = "SELECT
					usr_nome,
					usr_nome_fantasia,
					uin_usr_id,
					uin_pro_id,
					COALESCE(NULLIF(pro_titulo,''), uin_nomeProduto) `produto`,
					uin_status,
					uin_observacao,
					DATE_FORMAT(uin_timestamp, '%d/%m/%Y')
					FROM `".TP."_usuario_interesse`
					LEFT JOIN `".TP."_usuario`
						ON usr_id=uin_usr_id
						AND usr_status=1
					LEFT JOIN `".TP."_produto`
						ON pro_id=uin_pro_id
						AND pro_status=1
					WHERE `uin_status`=1 AND`uin_id`=?;";
		if (!$res = $conn->prepare($sql))
			echo __FUNCTION__.$conn->error;
		else {

			$res->bind_param('i', $id);
			$res->bind_result($nome, $nomeFantasia, $usr_id, $pro_id, $produto, $status, $observacao, $timestamp);
			$res->execute();
			$res->store_result();
			$res->fetch();
			$res->close();

			if (!empty($id)) {

				$id_encrypted = $hashids->encrypt($id);
				$list = array(
			             'id'=>$id_encrypted,
			             'usr_id'=>$hashids->encrypt($usr_id),
			             'pro_id'=>$pro_id,
			             'empresa'=>mb_strtoupper($nomeFantasia, 'utf8'),
			             'produto'=>mb_strtoupper($produto, 'utf8'),
			             'observacao'=>$observacao,
			             'status'=>$status,
			             'timestamp'=>$timestamp
		             );

				return $list;

			} else
				return false;
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
					usr_nome,
					usr_nome_fantasia,
					upr_id,
					upr_usr_id,
					upr_pro_id,
					upr_grupoquimico,
					upr_fabricante,
					upr_nomeFabricante,
					upr_nomeProduto,
					pro_titulo,
					pro_codigo,
					(SELECT cat_titulo FROM ".TP."_categoria WHERE cat_id=pro_tipo),
					(SELECT cat_titulo FROM ".TP."_categoria WHERE cat_id=upr_fabricante),
					(SELECT cat_titulo FROM ".TP."_categoria WHERE cat_id=pro_fabricante),
					(SELECT cat_titulo FROM ".TP."_categoria WHERE cat_id=upr_grupoquimico),
					(SELECT cat_titulo FROM ".TP."_categoria WHERE cat_id=pro_grupoquimico),
					upr_valor,
					upr_valor_minimo,
					upr_quantidade,
					upr_quantidade_minima_venda,
					upr_peso,
					COALESCE(NULLIF(upr_peso_unidade_medida,''), upr_nomeEmbalagem) `embalagem`,
					upr_datavalidade,
					DATE_FORMAT(upr_datavalidade, '%d/%m/%Y'),
					upr_datapagamento,
					DATE_FORMAT(upr_datapagamento, '%d/%m/%Y'),
					upr_views,
					upr_status,
					upr_vendas,
					adb_cidade,
					adb_uf,
					upr_observacao,
					DATE_FORMAT(upr_timestamp, '%d/%m/%Y')
					FROM `".TP."_usuario_produto`
					LEFT JOIN `".TP."_usuario`
						ON usr_id=upr_usr_id
					LEFT JOIN `".TP."_produto`
						ON pro_id=upr_pro_id
					LEFT JOIN ".TP."_address_book
						ON adb_usr_id=upr_usr_id
					WHERE  `upr_status`=1
							AND`upr_id`=?;";
		if (!$res = $conn->prepare($sql))
			echo __FUNCTION__.$conn->error;
		else {

			$res->bind_param('i', $id);
			$res->bind_result($nome, $nomeFantasia, $upr_id, $usr_id, $pro_id, $grupoquimico_id, $fabricante_id, $nomeFabricante, $nomeProduto, $produto, $codigoProduto, $tipoProduto, $fabricanteProduto, $proFabricanteProduto, $grupoquimicoProduto, $proGrupoQuimicoProduto, $valor, $valor_minimo, $quantidade, $quantidade_minima_venda, $peso, $embalagem, $datavalidade, $datavalidadePt, $datapagamento, $datapagamentoPt, $views, $status, $vendas, $cidade, $uf, $observacao, $timestamp);
			$res->execute();
			$res->store_result();
			$res->fetch();
			$res->close();

			if (!empty($upr_id)) {

				$produto = empty($produto) ? $nomeProduto : $produto;
				$fabricanteProduto = empty($fabricanteProduto) ? $nomeFabricante : $fabricanteProduto;
				$fabricanteProduto = empty($fabricanteProduto) ? $proFabricanteProduto : $fabricanteProduto;
				$grupoquimicoProduto = empty($grupoquimicoProduto) && !empty($proGrupoQuimicoProduto) ? $proGrupoQuimicoProduto : $grupoquimicoProduto;
				$embalagem = is_numeric($embalagem) ? getCategoriaCol('titulo', 'id', $embalagem) : $embalagem;
				$empresa = empty($nomeFantasia) ? $nome : $nomeFantasia;
				$valor = empty($valor) || $valor=='0.00' ? 'Sob consulta' : 'R$ '.Currency2Decimal($valor);

				$id_encrypted = $hashids->encrypt($upr_id);
				$cpr = array(
			             'id'=>$id_encrypted,
			             'usr_id'=>$hashids->encrypt($usr_id),
			             'pro_id'=>$pro_id,
			             'empresa'=>mb_strtoupper($empresa, 'utf8'),
			             'grupoquimico_id'=>$grupoquimico_id,
			             'fabricante_id'=>$fabricante_id,
			             'nomeProduto'=>mb_strtoupper($nomeProduto, 'utf8'),
			             'nomeFabricante'=>$nomeFabricante,
			             'titulo'=>mb_strtoupper($produto, 'utf8'),
			             'codigo'=>$codigoProduto,
			             'tipo'=>$tipoProduto,
			             'fabricante'=>$fabricanteProduto,
			             'grupoquimico'=>$grupoquimicoProduto,
			             'valor'=>$valor,
			             'valor_minimo'=>'R$ '.Currency2Decimal($valor_minimo),
			             'quantidade'=>$quantidade,
			             'quantidade_minima_venda'=>$quantidade_minima_venda,
			             'peso'=>$peso,
			             'peso_unidade_medida'=>mb_strtoupper($embalagem, 'utf8'),
			             'datavalidadeEn'=>$datavalidade,
			             'datavalidade'=>$datavalidadePt,
			             'datapagamentoEn'=>$datapagamento,
			             'datapagamento'=>$datapagamentoPt,
			             'link'=>ABSPATH."ver/{$id_encrypted}/".linkfySmart($produto),
			             'cidade'=>$cidade,
			             'uf'=>(empty($uf) ? '--' : $uf),
			             'observacao'=>$observacao,
			             'estado'=>estadoFromUF($uf),
			             'views'=>$views,
			             'status'=>$status,
			             'vendas'=>$vendas,
			             'timestamp'=>$timestamp
		             );

				return $cpr;

			} else
				return false;
		}

	}

	public function getMyInsterests($usr_id)
	{
		global $conn, $hashids;

		if (empty($usr_id))
			return array();

		if (!is_numeric($usr_id)) {
			$usr_id = $hashids->decrypt($usr_id);
			$usr_id = $usr_id[0];
		}

		$cpr=array();
		$listMyPro = array();

		$sql = "
				SELECT * FROM (
					SELECT
						uin_id,
						COALESCE(NULLIF(pro_titulo,''), uin_nomeProduto) `produto`
					FROM `".TP."_usuario_interesse`
					INNER JOIN ".TP."_usuario
						ON uin_usr_id=usr_id
						AND usr_status=1
					LEFT JOIN `".TP."_produto`
						ON `pro_id`=`uin_pro_id`
					WHERE uin_status=1
						AND uin_usr_id=?
					) as `tmp`
				ORDER BY produto";
		if (!$res = $conn->prepare($sql))
			echo __FUNCTION__.$conn->error;
		else {
			$res->bind_param('i', $usr_id);
			$res->bind_result($uin_id, $produto);
			$res->execute();

			while ($res->fetch()) {
				array_push($listMyPro, $uin_id);
			}

			$res->close();

			foreach ($listMyPro as $uin_id)
				$cpr[$uin_id]  = $this->getSimpleInfoById($uin_id);

			return $cpr;

		}
	}


	/**
	 * Resgata último produto
	 * @return bool
	 */
	public function getLastId()
	{
		global $conn;

		$usr_id = $this->_args['usr_id'];
		$pro_id = $this->_args['pro_id'];
		$valor = $this->_args['valor'];

		$sql = "SELECT uin_id FROM `".TP."_usuario_interesse` WHERE `uin_usr_id`=? AND `uin_pro_id`=?;";
		if (!$res = $conn->prepare($sql))
			echo __FUNCTION__.$conn->error;
		else {
			$res->bind_param('ii', $usr_id, $pro_id);
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
	public function removerInteresse($args)
	{
		global $conn, $hashids, $usr;

		if (!isset($usr['id']) || empty($usr['id']))
			return 'Usuário não logado!';

		$uin_id = $hashids->decrypt($args['id']);
		$uin_id = $uin_id[0];
		$usr_id = $hashids->decrypt($usr['id']);
		$usr_id = $usr_id[0];

		$sql = "DELETE FROM `".TP."_usuario_interesse` WHERE `uin_id`=? AND `uin_usr_id`=?;";
		if (!$res = $conn->prepare($sql))
			return false;
		else {
			$res->bind_param('ii', $uin_id, $usr_id);
			$res->execute();
			$res->close();

			return true;
		}

	}

	public function filtroCategorias($filtro)
	{
		global $conn, $hashids, $usr;

		$listUf = $listPreco = array();
		$getFiltros = $this->getFiltros($filtro);
		$filtro = $getFiltros['filtro'];
		$whr = $getFiltros['whr'];

		if (!is_numeric($usr['id'])) {
			$usr_id = $hashids->decrypt($usr['id']);
			$usr_id = isset($usr_id[0]) ? $usr_id[0] : null;
		} else
			$usr_id = $usr['id'];

		if (empty($usr_id))
			return false;

		// filtra query apenas com as infos que nao pertencem ao filtro
		$whrFiltro = $getFiltros['whrFiltro'];
		unset($whrFiltro['uf']);
		unset($whrFiltro['faixapreco']);
		$whrFiltro = join(' ', $whrFiltro);
		$num = $this->howManyProductsInUF($whrFiltro);

		/**
		 * Query do Filtro de Localidade
		 * @var string
		 */
		$sqluf = "SELECT * FROM (
					SELECT
						pro_grupoquimico,
						pro_fabricante,
						upr_usr_id,
						adb_uf,
						upr_valor,
						COALESCE(NULLIF(pro_titulo,''), upr_nomeProduto) `produto`
					FROM `".TP."_usuario_produto`
					INNER JOIN ".TP."_usuario_interesse
						ON upr_usr_id<>uin_usr_id
					INNER JOIN ".TP."_usuario
						ON upr_usr_id=usr_id
						AND usr_status=1
					LEFT JOIN ".TP."_address_book
						ON adb_usr_id=upr_usr_id
					INNER JOIN ".TP."_produto
						ON pro_id=upr_pro_id
						AND pro_status=1
					WHERE upr_status=1
						AND uin_usr_id=\"{$usr_id}\"
						AND (uin_pro_id=pro_id OR upr_nomeProduto LIKE CONCAT('%', uin_nomeProduto, '%'))
					) as `tmp`
					WHERE 1
					{$whrFiltro}
					GROUP BY adb_uf
					ORDER BY adb_uf";
		if (!$resuf = $conn->prepare($sqluf))
			echo __FUNCTION__.$conn->error;
		else {

			$resuf->bind_result($grupoquimico, $fabricante, $usr_id, $uf, $valor, $produto);
			$resuf->execute();

			$i=0;
			while ($resuf->fetch()) {
				$ufmin = strtolower($uf);
				$estado = estadoFromUF($uf);
				$ufIndex = empty($uf) ? 'vazio' : $uf;

				$listUf[$i]['uf'] = $uf;
				$listUf[$i]['estado'] = $estado;
				$listUf[$i]['num'] = $num[$ufIndex];

				if (isset($filtro['filtroUF']) && $filtro['filtroUF']==$ufmin)
					$listUf[$i]['link'] = "{$estado} ({$num[$ufIndex]})";
				else
					$listUf[$i]['link'] = "<a href='".ABSPATH."lista-por-interesse/uf-{$ufmin}'>{$estado}</a> ({$num[$ufIndex]})";

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
				$whrProduto = " AND (produto LIKE \"%{$filtro['filtroProduto']}%\"";
				$whrProduto .= " OR produto LIKE \"%{$filtroProduto}%\") ";
				$whr .= $whrProduto;
				$whrFiltro['produto'] = $whrProduto;

			} if (isset($filtro['filtroRevenda']) && !empty($filtro['filtroRevenda'])) {
				$getUsuarios = getUsuarios(false);

				if (isset($getUsuarios[$filtro['filtroRevenda']])) {
					$filtro['filtroRevenda'] = $getUsuarios[$filtro['filtroRevenda']]['id_numeric'];
					$whrRevenda = " AND uin_usr_id=\"{$filtro['filtroRevenda']}\"";
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
					$whrFaixaPreco = " AND (uin_valor IS NULL OR uin_valor<=750) ";
				elseif ($faixaPreco=='750a2000')
					$whrFaixaPreco = " AND uin_valor BETWEEN 750.01 AND 2000";
				elseif ($faixaPreco=='mais2000')
					$whrFaixaPreco = " AND uin_valor>2000.01";

				$whr .= $whrFaixaPreco;
				$whrFiltro['faixapreco'] = $whrFaixaPreco;

			}
		}

		return array('filtro'=>$filtro, 'whrFiltro'=>$whrFiltro, 'whr'=>$whr);
	}

	private function howManyProductsInUF($whrFiltro)
	{
		global $conn, $hashids, $usr;

		if (!is_numeric($usr['id'])) {
			$usr_id = $hashids->decrypt($usr['id']);
			$usr_id = isset($usr_id[0]) ? $usr_id[0] : null;
		} else
			$usr_id = $usr['id'];

		if (empty($usr_id))
			return false;

		/**
		 * Query do Filtro de Localidade
		 * @var string
		 */
		$sql = "SELECT adb_uf, COUNT(upr_id) `num`
					FROM `".TP."_usuario_produto`
					INNER JOIN ".TP."_usuario_interesse
						ON upr_usr_id<>uin_usr_id
					INNER JOIN ".TP."_usuario
						ON upr_usr_id=usr_id
						AND usr_status=1
					LEFT JOIN ".TP."_address_book
						ON adb_usr_id=upr_usr_id
					LEFT JOIN ".TP."_produto
						ON pro_id=upr_pro_id
						AND pro_status=1
					WHERE upr_status=1
						AND uin_usr_id=\"{$usr_id}\"
						AND (uin_pro_id=pro_id OR upr_nomeProduto LIKE CONCAT('%', uin_nomeProduto, '%'))
					{$whrFiltro}
					GROUP BY adb_uf
					";
		if (!$res= $conn->prepare($sql))
			return false;
		else {

			$res->bind_result($uf, $num);
			$res->execute();

			$lst = array();
			while ($res->fetch()) {
				$uf = !empty($uf) ? $uf : 'vazio';
				$lst[$uf] = $num;
			}
			$res->close();

			return $lst;
		}
	}
}