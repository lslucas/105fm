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
				$cpr[$uin_id]  = $this->getInfoById($uin_id);

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

}