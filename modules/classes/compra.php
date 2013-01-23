<?php

class Compra {

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

		if (!empty($args['datavalidade']))
			list($this->_args['validade_dia'], $this->_args['validade_mes'], $this->_args['validade_ano']) = explode('/', $args['datavalidade']);
		if (!empty($args['datapagamento']))
			list($this->_args['pagamento_dia'], $this->_args['pagamento_mes'], $this->_args['pagamento_ano']) = explode('/', $args['datapagamento']);

		$return = null;

		if (!isset($args['usr_id']) || empty($args['usr_id']))
			$return .= '<li>Sua sessão expirou! Faça <a href=\''.ABSPATH.'login\'>login</a> novamente</li>';
		else {
			// if (empty($args['grupoquimico']))
				// $return .= '<li>Selecione um Grupo Químico</li>';
			// if (empty($args['fabricante']) && empty($args['nomeFabricante']))
				// $return .= '<li>Selecione um fabricante ou informe um novo clicando em outro</li>';
			if (empty($args['pro_id']) && empty($args['nomeProduto']))
				$return .= '<li>Selecione um produto ou informe um nome clicando em outro</li>';
			// if (empty($args['valor']))
				// $return .= '<li>Digite o valor do produto</li>';
			if (empty($args['quantidade']))
				$return .= '<li>Informe a quantidade de produtos</li>';
			// if (empty($args['peso']))
				// $return .= '<li>Informe o peso do produto</li>';
			if (empty($args['peso_unidade_medida']) && empty($args['nomeEmbalagem']))
				$return .= '<li>Informe a unidade de medida do peso do produto</li>';
			// if (empty($args['datapagamento']))
				// $return .= '<li>Informe a data de pagamento</li>';
			/*
			if (empty($args['datavalidade']))
				$return .= '<li>Informe a data de validade do produto</li>';
			else */
			if (!empty($args['datavalidade']) && !validaData($this->_args['validade_ano'], $this->_args['validade_mes'], $this->_args['validade_dia']))
				$return .= '<li>Entre com uma data de compra válida!</li>';

			$this->_args['quantidade_minima_venda'] = isset($this->_args['quantidade_minima_venda']) ? $this->_args['quantidade_minima_venda'] : null;

			if (!is_numeric($this->_args['usr_id'])) {
				$usr_id = $hashids->decrypt($this->_args['usr_id']);
				$this->_args['usr_id'] = $usr_id[0];
			}
		}

		if (empty($return))
			return true;
		else return $return;
	}

	public function validaCompraAjax($args)
	{
		$this->_args = $args;
		$return  = true;
		if (!$this->validaCompra())
			$return = array('error'=>'Compra já foi cadastrada!');

		return $return;
	}

	public function novaCompra($args)
	{
		$this->_args = $args;
		$res = $this->validaParametros($args);
		$return = array();
		if ($res === true) {

			if ($this->validaCompra()) {

				if ($this->gravaCompra())
					$return['success'] = array('text'=>'Compra registrada com sucesso!', 'cols'=>array('id'=>$this->getLastId()));
				else
					$return['error'] = array('text'=>'Houve algum problema!');

			} else $return['error'] = array('text'=>'Você já cadastrou essa compra antes!');

		} else
			$return['error'] = array('text'=>$res, 'title'=>'Corrija o formulário abaixo');

		return $return;
	}

	public function atualizaCompra($args)
	{

		$this->_args = $args;
		$res = $this->validaParametros('atualiza');
		$return = array();
		if ($res === true) {

			if ($this->validaCompra()) {

				if ($this->updateCompra())
					$return['success'] = array('text'=>'Atualizado com sucesso!', 'cols'=>array('id'=>$this->getLastId()));
				else
					$return['error'] = array('text'=>'Houve algum problema!');

			} else $return['error'] = array('text'=>'Compra foi cadastrada anteriormente!');

		} else
			$return['error'] = array('title'=>'Corrija o formulário abaixo', 'text'=>$res);

		return $return;
	}

	/**
	 * Valida se cadastro [cpf] já existe
	 * @return bool
	 */
	private function validaCompra()
	{
		global $conn, $hashids;

		$sufix = null;
		if (!empty($this->_args['id'])) {
			$id = $hashids->decrypt($this->_args['id']);
			$id = $id[0];
			$sufix = " AND `upr_id`<>".$id;
		}

		$sql = "SELECT SQL_CACHE NULL FROM `".TP."_usuario_produto`
					WHERE `upr_usr_id`=?
							AND `upr_pro_id`=?
							AND `upr_datavalidade`=?
							AND DATE(`upr_timestamp`)=DATE(NOW())
							{$sufix}";
		if (!$res = $conn->prepare($sql))
			echo __FUNCTION__.$conn->error;
		else {
			$res->bind_param('iis', $this->_args['usr_id'], $this->_args['pro_id'], $this->_args['datavalidade']);
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
	public function compraExiste($id)
	{
		global $conn, $hashids;

		if (!empty($id) && !is_numeric($id)) {
			$id = $hashids->decrypt($id);
			$id = isset($id[0]) ? $id[0] : null;
		}

		if (empty($id))
			return 'ID inválido!';

		$sql = "SELECT SQL_CACHE NULL FROM `".TP."_usuario_produto` WHERE upr_status=1 AND `upr_id`=?";
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

	private function gravaCompra()
	{
		global $conn;

		if ($this->validaCompra()) {

			$sqlins = "INSERT INTO `".TP."_usuario_produto`
							(
							 `upr_usr_id`,
							 `upr_grupoquimico`,
							 `upr_fabricante`,
							 `upr_pro_id`,
							 `upr_nomeFabricante`,
							 `upr_nomeProduto`,
							 `upr_valor`,
							 `upr_valor_minimo`,
							 `upr_quantidade`,
							 `upr_quantidade_minima_venda`,
							 `upr_peso`,
							 `upr_peso_unidade_medida`,
							 `upr_nomeEmbalagem`,
							 `upr_datavalidade`,
							 `upr_datapagamento`,
							 `upr_observacao`,
							 `upr_ip`
							 ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			if (!$qryins = $conn->prepare($sqlins))
				echo __FUNCTION__.$conn->error;
				// return false;
			else {

				$this->_args['valor'] = Currency2Decimal($this->_args['valor'], 1);
				$this->_args['valor_minimo'] = isset($this->_args['valor_minimo']) ? Currency2Decimal($this->_args['valor_minimo'], 1) : 0;
				$this->_args['datavalidade'] = datept2en('/',$this->_args['datavalidade']);
				$this->_args['datapagamento'] = datept2en('/',$this->_args['datapagamento']);

				$qryins->bind_param('isiissddiidisssss',
				                    	$this->_args['usr_id'],
				                    	$this->_args['grupoquimico'],
				                    	$this->_args['fabricante'],
				                    	$this->_args['pro_id'],
				                    	$this->_args['nomeFabricante'],
				                    	$this->_args['nomeProduto'],
				                    	$this->_args['valor'],
				                    	$this->_args['valor_minimo'],
				                    	$this->_args['quantidade'],
				                    	$this->_args['quantidade_minima_venda'],
				                    	$this->_args['peso'],
				                    	$this->_args['peso_unidade_medida'],
				                    	$this->_args['nomeEmbalagem'],
				                    	$this->_args['datavalidade'],
				                    	$this->_args['datapagamento'],
				                    	$this->_args['observacao'],
				                    	$_SERVER['REMOTE_ADDR']
				                    );
				$qryins->execute();
				$qryins->close();

				return true;
			}

		} else return false;
	}

	private function updateCompra()
	{
		global $conn, $hashids, $usr;

		$upr_id = $this->_args['upr_id'];
		if (!is_numeric($upr_id)) {
			$upr_id = $hashids->decrypt($upr_id);
			$upr_id = $upr_id[0];
		}

		$sqlupd = "UPDATE `".TP."_usuario_produto`
						SET
						 `upr_grupoquimico`=?,
						 `upr_fabricante`=?,
						 `upr_pro_id`=?,
						 `upr_nomeFabricante`=?,
						 `upr_nomeProduto`=?,
						 `upr_valor`=?,
						 `upr_valor_minimo`=?,
						 `upr_quantidade`=?,
						 `upr_quantidade_minima_venda`=?,
						 `upr_peso`=?,
						 `upr_peso_unidade_medida`=?,
						 `upr_nomeEmbalagem`=?,
						 `upr_datavalidade`=?,
						 `upr_datapagamento`=?,
						 `upr_observacao`=?,
						 `upr_ip`=?
						 WHERE `upr_id`=? AND `upr_usr_id`=?";
		if (!$qryupd = $conn->prepare($sqlupd))
			echo __FUNCTION__.$conn->error;
			// return false;

		else {
			$this->_args['valor'] = Currency2Decimal($this->_args['valor'], 1);
			$this->_args['valor_minimo'] = isset($this->_args['valor_minimo']) ? Currency2Decimal($this->_args['valor_minimo'], 1) : 0;
			$this->_args['datavalidade'] = datept2en('/',$this->_args['datavalidade']);
			$this->_args['datapagamento'] = datept2en('/',$this->_args['datapagamento']);

			$qryupd->bind_param('iiissddiidisssssii',
			                    	$this->_args['grupoquimico'],
			                    	$this->_args['fabricante'],
			                    	$this->_args['pro_id'],
			                    	$this->_args['nomeFabricante'],
			                    	$this->_args['nomeProduto'],
			                    	$this->_args['valor'],
			                    	$this->_args['valor_minimo'],
			                    	$this->_args['quantidade'],
			                    	$this->_args['quantidade_minima_venda'],
			                    	$this->_args['peso'],
			                    	$this->_args['peso_unidade_medida'],
			                    	$this->_args['nomeEmbalagem'],
			                    	$this->_args['datavalidade'],
			                    	$this->_args['datapagamento'],
			                    	$this->_args['observacao'],
			                    	$_SERVER['REMOTE_ADDR'],
			                    	$upr_id,
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

	public function getMyProducts($usr_id)
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
						upr_id,
						COALESCE(NULLIF(pro_titulo,''), upr_nomeProduto) `produto`
					FROM `".TP."_usuario_produto`
					INNER JOIN ".TP."_usuario
						ON upr_usr_id=usr_id
						AND usr_status=1
					LEFT JOIN `".TP."_produto`
						ON `pro_id`=`upr_pro_id`
					WHERE upr_status=1
						AND upr_usr_id=?
					) as `tmp`
				ORDER BY produto";
		if (!$res = $conn->prepare($sql))
			echo __FUNCTION__.$conn->error;
		else {
			$res->bind_param('i', $usr_id);
			$res->bind_result($upr_id, $produto);
			$res->execute();

			while ($res->fetch()) {
				array_push($listMyPro, $upr_id);
			}

			$res->close();

			foreach ($listMyPro as $upr_id)
				$cpr[$upr_id]  = $this->getInfoById($upr_id);

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
						upr_id,
						pro_grupoquimico,
						pro_fabricante,
						upr_usr_id,
						adb_uf,
						upr_valor,
						COALESCE(NULLIF(pro_titulo,''), upr_nomeProduto) `produto`
					FROM `".TP."_usuario_produto`
					INNER JOIN ".TP."_usuario
						ON upr_usr_id=usr_id
						AND usr_status=1
					LEFT JOIN ".TP."_address_book
						ON adb_usr_id=upr_usr_id
					LEFT JOIN `".TP."_produto`
						ON `pro_id`=`upr_pro_id`
					WHERE upr_status=1
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

			return $cpr;

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
						COALESCE(NULLIF(pro_titulo,''), upr_nomeProduto) `produto`,
						COUNT(upr_id) `num`
					FROM `".TP."_usuario_produto`
					LEFT JOIN ".TP."_address_book
						ON adb_usr_id=upr_usr_id
					INNER JOIN ".TP."_produto
						ON pro_id=upr_pro_id
					WHERE upr_status=1
					) as `tmp`
					WHERE 1
					{$whrFiltro}
					GROUP BY adb_uf
					ORDER BY adb_uf";
		if (!$resuf = $conn->prepare($sqluf))
			echo __FUNCTION__.$conn->error;
		else {

			$resuf->bind_result($grupoquimico, $fabricante, $usr_id, $uf, $valor, $produto, $num);
			$resuf->execute();

			$i=0;
			while ($resuf->fetch()) {
				$ufmin = strtolower($uf);
				$estado = estadoFromUF($uf);

				$listUf[$i]['uf'] = $uf;
				$listUf[$i]['estado'] = $estado;
				$listUf[$i]['num'] = $num;

				if (isset($filtro['filtroUF']) && $filtro['filtroUF']==$ufmin)
					$listUf[$i]['link'] = "{$estado} ({$num})";
				else
					$listUf[$i]['link'] = "<a href='".ABSPATH."lista/uf-{$ufmin}'>{$estado}</a> ({$num})";

				$i++;
			}

			$resuf->close();
		}


		/**
		 * Query do Filtro de FaixaPreco
		 * @var string
		 */
		/*
		$sqlval = "SELECT upr_valor, COUNT(upr_id) `num`
					FROM `".TP."_usuario_produto`
					LEFT JOIN ".TP."_address_book
						ON adb_usr_id=upr_usr_id
					INNER JOIN ".TP."_produto
						ON pro_id=upr_pro_id
					WHERE upr_status=1
					{$whrFiltro}
					GROUP BY upr_valor
					ORDER BY upr_timestamp DESC";
					*/
		$sqlval = "SELECT * FROM (
					SELECT
						pro_grupoquimico,
						pro_fabricante,
						upr_usr_id,
						adb_uf,
						upr_valor,
						COALESCE(NULLIF(pro_titulo,''), upr_nomeProduto) `produto`,
						COUNT(upr_id) `num`
					FROM `".TP."_usuario_produto`
					LEFT JOIN ".TP."_address_book
						ON adb_usr_id=upr_usr_id
					INNER JOIN ".TP."_produto
						ON pro_id=upr_pro_id
					WHERE upr_status=1
					) as `tmp`
					WHERE 1
					{$whrFiltro}
					GROUP BY upr_valor";
		if (!$resval = $conn->prepare($sqlval))
			echo __FUNCTION__.$conn->error;
		else {

			$resval->bind_result($grupoquimico, $fabricante, $usr_id, $uf, $decimal, $produto, $num);
			$resval->execute();

			$i=0;
			while ($resval->fetch()) {
				$decimal = empty($decimal) ? 1 : $decimal;
				$listPreco[$i]['decimal'] = $decimal;
				$listPreco[$i]['num'] = $num;
				$i++;
			}


			$listFaixaPreco = array();
			$num = array('750'=>0, '750-2000'=>0, '+2000'=>0);
			asort($listPreco);
			foreach ($listPreco as $int=>$lstPreco) {
				$preco = $lstPreco['decimal'];
				if ($preco<=750) {
					$num['750'] = $num['750']+$lstPreco['num'];
					$listFaixaPreco[750]['num'] = $num['750'];

					if (isset($filtro['filtroFaixaPreco']) && $filtro['filtroFaixaPreco']=='750')
						$listFaixaPreco[750]['link'] = "Até R$750 ({$num['750']})";
					else
						$listFaixaPreco[750]['link'] = "<a href='".ABSPATH."lista/faixapreco-750'>Até R$750</a> ({$num['750']})";

				} elseif ($preco>750 && $preco<=2000) {
					$num['750-2000'] = $num['750-2000']+$lstPreco['num'];
					$listFaixaPreco['750-2000']['num'] = $num['750-2000'];

					if (isset($filtro['filtroFaixaPreco']) && $filtro['filtroFaixaPreco']=='750a2000')
						$listFaixaPreco['750-2000']['link'] = "R$750 a R$2.000 ({$num['750-2000']})";
					else
						$listFaixaPreco['750-2000']['link'] = "<a href='".ABSPATH."lista/faixapreco-750a2000'>R$750 a R$2.000</a> ({$num['750-2000']})";

				} else {
					$num['+2000'] = $num['+2000']+$lstPreco['num'];
					$listFaixaPreco['+2000']['num'] = $num['+2000'];

					if (isset($filtro['filtroFaixaPreco']) && $filtro['filtroFaixaPreco']=='mais2000')
						$listFaixaPreco['+2000']['link'] = "Mais de R$2.000 ({$num['+2000']})";
					else
						$listFaixaPreco['+2000']['link'] = "<a href='".ABSPATH."lista/faixapreco-mais2000'>Mais de R$2.000</a> ({$num['+2000']})";
				}

			}

			$resval->close();
		}

		$list = array('localizacao'=>$listUf, 'faixaPreco'=>$listFaixaPreco);
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
			if (isset($filtro['filtroGrupoQuimico']) && !empty($filtro['filtroGrupoQuimico'])) {
				$whrGrupoQuimico = " AND pro_grupoquimico=\"{$filtro['filtroGrupoQuimico']}\"";
				$whr .= $whrGrupoQuimico;
				$whrFiltro['grupoquimico'] = $whrGrupoQuimico;

			} if (isset($filtro['filtroFabricante']) && !empty($filtro['filtroFabricante'])) {
				$filtro['filtroFabricante'] = urldecode($filtro['filtroFabricante']);
				$whrFabricante = " AND pro_fabricante=\"{$filtro['filtroFabricante']}\"";
				$whr .= $whrFabricante;
				$whrFiltro['fabricante'] = $whrFabricante;

			} if (isset($filtro['filtroProduto']) && !empty($filtro['filtroProduto'])) {
				$filtroProduto = urldecode($filtro['filtroProduto']);
				$whrProduto = " AND (produto LIKE \"%{$filtro['filtroProduto']}%\"";
				$whrProduto .= " OR produto LIKE \"%{$filtroProduto}%\") ";
				$whr .= $whrProduto;
				$whrFiltro['produto'] = $whrProduto;
				/*
				$getTodosProdutos = getTodosProdutos(null, null, false);

				if (isset($getTodosProdutos[$filtro['filtroProduto']])) {
					$filtro['filtroProduto'] = $getTodosProdutos[$filtro['filtroProduto']]['id'];
					$whrProduto = " AND pro_id=\"{$filtro['filtroProduto']}\"";
					$whr .= $whrProduto;
					$whrFiltro['produto'] = $whrProduto;
				}
				 */

			} if (isset($filtro['filtroRevenda']) && !empty($filtro['filtroRevenda'])) {
				$getUsuarios = getUsuarios(false);

				if (isset($getUsuarios[$filtro['filtroRevenda']])) {
					$filtro['filtroRevenda'] = $getUsuarios[$filtro['filtroRevenda']]['id_numeric'];
					$whrRevenda = " AND upr_usr_id=\"{$filtro['filtroRevenda']}\"";
					$whr .= $whrRevenda;
					$whrFiltro['revenda'] = $whrRevenda;
				}

			} if (isset($filtro['filtroUF']) && !empty($filtro['filtroUF'])) {
				$whrUF = " AND LOWER(adb_uf)=\"{$filtro['filtroUF']}\"";
				$whr .= $whrUF;
				$whrFiltro['uf'] = $whrUF;

			} if (isset($filtro['filtroFaixaPreco']) && !empty($filtro['filtroFaixaPreco'])) {
				$faixaPreco = $filtro['filtroFaixaPreco'];

				if ($faixaPreco=='750')
					$whrFaixaPreco = " AND (upr_valor IS NULL OR upr_valor<=750) ";
				elseif ($faixaPreco=='750a2000')
					$whrFaixaPreco = " AND upr_valor BETWEEN 750.01 AND 2000";
				elseif ($faixaPreco=='mais2000')
					$whrFaixaPreco = " AND upr_valor>2000.01";

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
		$pro_id = $this->_args['pro_id'];
		$valor = $this->_args['valor'];

		$sql = "SELECT upr_id FROM `".TP."_usuario_produto` WHERE `upr_usr_id`=? AND `upr_pro_id`=? AND upr_valor=?;";
		if (!$res = $conn->prepare($sql))
			echo __FUNCTION__.$conn->error;
		else {
			$res->bind_param('iid', $usr_id, $pro_id, $valor);
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
	public function removerCompra($args)
	{
		global $conn, $hashids, $usr;

		if (!isset($usr['id']) || empty($usr['id']))
			return 'Usuário não logado!';

		$upr_id = $hashids->decrypt($args['id']);
		$upr_id = $upr_id[0];
		$usr_id = $hashids->decrypt($usr['id']);
		$usr_id = $usr_id[0];

		$sql = "UPDATE `".TP."_usuario_produto` SET `upr_status`=0 WHERE `upr_id`=? AND `upr_usr_id`=?;";
		if (!$res = $conn->prepare($sql))
			return false;
		else {
			$res->bind_param('ii', $upr_id, $usr_id);
			$res->execute();
			$res->close();

			return true;
		}

	}

}