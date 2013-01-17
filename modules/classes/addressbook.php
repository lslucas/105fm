<?php

class AddressBook {

	public function __construct()
	{
		//
	}

	private function validaParametros($action)
	{
		global $usr, $hashids;

		if (!isset($usr) || empty($usr['id']))
			exit('Usuário não logado! Impossível continuar.');

		$args = $this->_args;
		if (!is_array($args))
			exit(__FUNCTION__.' Parâmetros inválidos!');

		$return = null;

		// if (!isset($args['endereco']) || empty($args['endereco']))
			// $return .= '<li>Informe um endereço!</li>';
		// if (!isset($args['complemento']) || empty($args['complemento']))
			// $return .= '<li>Informe um complemento!</li>';
		if (!isset($args['cidade']) || empty($args['cidade']))
			$return .= '<li>Informe a Cidade!</li>';
		if (!isset($args['uf']) || empty($args['uf']))
			$return .= '<li>Informe o UF!</li>';
		if (!isset($args['cep']) || empty($args['cep']))
			$return .= '<li>Informe o CEP!</li>';
		if (!isset($args['tipo']) || empty($args['tipo']))
			$return .= '<li>Informe o Tipo!</li>';

		if (isset($this->_args['id']) && !empty($this->_args['id']) && !is_numeric($this->_args['id'])) {
			$id = $hashids->decrypt($this->_args['id']);
			$this->_args['id'] = $id[0];
		}

		if (empty($return))
			return true;
		else return $this->trataHtmlErros($return);
	}

	private function trataHtmlErros($return)
	{
		$html = "<ul class='unstyled'>";
		$html .= $return;
		$html .= "</ul>";
		return $html;
	}

	public function validaCadastroAjax($args)
	{
		$this->_args = $args;
		$return  = true;
		if ($this->addressExists($args['cep']))
			$return = array('email'=>'CEP já está cadatrado!');
		return $return;
	}

	public function novoCadastro($args)
	{

		$this->_args = $args;
		$res = $this->validaParametros('insere');
		if ($res === true) {

			if ($this->validaCadastro()) {

				if ($this->gravaCadastro())
					$return['success'] = array('text'=>'Cadastrado com sucesso!', 'cols'=>array('id'=>$this->getIdByCEP($this->_args['cep'])));
				else
					$return['error'] = array('text'=>'Houve algum problema!');

			} else $return['error'] = array('text'=>'CEP já está cadatrado!');

		} else
			$return['error'] = array('text'=>$res);

		return $return;
	}

	public function atualizaCadastro($args)
	{

		$this->_args = $args;
		$res = $this->validaParametros('atualiza');
		if ($res === true) {

			if ($this->validaCadastro()) {

				if ($this->updateCadastro())
					$return['success'] = array('text'=>'Atualizado com sucesso!', 'cols'=>array('id'=>$this->getIdByCEP($this->_args['cep'])));
				else
					$return['error'] = array('text'=>'Houve algum problema!');

			} else $return['error'] = array('text'=>'CEP já existe cadastrado!');

		} else
			$return['error'] = array('text'=>$res);

		return $return;
	}

	/**
	 * Valida se cep existe
	 * @return bool
	 */
	public function addressExists($cep)
	{
		global $conn, $usr, $hashids;

		$sufix = null;
		if (!empty($this->_args['id'])) {
			if (!is_numeric($this->_args['id'])) {
				$id = $hashids->decrypt($this->_args['id']);
				$id = $id[0];
			} else
				$id = $this->_args['id'];

			$sufix .= " AND `adb_id`<>".$id;
		}

		if (!empty($usr['id'])) {
			if (!is_numeric($usr['id'])) {
				$usr_id = $hashids->decrypt($usr['id']);
				$usr_id = $usr_id[0];
			} else
				$usr_id = $usr['id'];

			$sufix .= " OR `adb_usr_id`=".$usr_id;
		}

		$sql = "SELECT SQL_CACHE NULL FROM `".TP."_address_book` WHERE `adb_cep`=\"{$cep}\" {$sufix}";
		$res = $conn->query($sql);
		$num = $res->num_rows;

		if ($num>0) return true;
		else return false;
	}

	/**
	 * Valida se cadastro [cpf] já existe
	 * @return bool
	 */
	private function validaCadastro()
	{
		global $conn, $hashids, $usr;


		$sufix = null;
		if (!empty($this->_args['id'])) {
			if (!is_numeric($this->_args['id'])) {
				$id = $hashids->decrypt($this->_args['id']);
				$id = $id[0];
			} else
				$id = $this->_args['id'];

			$sufix = " AND `adb_id`<>".$id;
		}

		if (!empty($usr['id'])) {
			if (!is_numeric($usr['id'])) {
				$usr_id = $hashids->decrypt($usr['id']);
				$usr_id = $usr_id[0];
			} else
				$usr_id = $usr['id'];

			$sufix .= " AND `adb_usr_id`=".$usr_id;
		}

		$sql = "SELECT SQL_CACHE NULL FROM `".TP."_address_book` WHERE `adb_cep`=\"{$this->_args['cep']}\"  {$sufix}";
		echo $sql;
		$res = $conn->query($sql);
		$num = $res->num_rows;

		if ($num>0) return false;
		else return true;
	}

	private function gravaCadastro()
	{
		global $conn, $aes, $hashids, $usr;

		if ($this->validaCadastro()) {

			if (!is_numeric($usr['id'])) {
				$usr_id = $hashids->decrypt($usr['id']);
				$usr_id = $usr_id[0];
			} else
				$usr_id = $usr['id'];

			$sqlins = "INSERT INTO `".TP."_address_book`
							(
							 `adb_usr_id`,
							 `adb_tipo`,
							 `adb_endereco`,
							 `adb_complemento`,
							 `adb_cidade`,
							 `adb_uf`,
							 `adb_cep`
							 ) VALUES (?, ?, ?, ?, ?, ?, ?)";
			if (!$qryins = $conn->prepare($sqlins))
				return false;

			else {
				$qryins->bind_param('issssss',
				                    	$usr_id,
				                    	$this->_args['tipo'],
				                    	$this->_args['endereco'],
				                    	$this->_args['complemento'],
				                    	$this->_args['cidade'],
				                    	$this->_args['uf'],
				                    	$this->_args['cep']
				                    );
				$qryins->execute();
				$qryins->close();

				return true;
			}

		} else return false;
	}

	private function updateCadastro()
	{
		global $conn, $aes, $hashids, $usr;

		if (!is_numeric($this->_args['id'])) {
			$id = $hashids->decrypt($this->_args['id']);
			$id = $id[0];
		} else
			$id = $this->_args['id'];

		$sqlupd = "UPDATE `".TP."_address_book`
						SET
						 `adb_tipo`=?,
						 `adb_endereco`=?,
						 `adb_complemento`=?,
						 `adb_cidade`=?,
						 `adb_uf`=?,
						 `adb_cep`=?
						 WHERE `adb_id`=?";
		if (!$qryupd = $conn->prepare($sqlupd))
			return false;

		else {

			$qryupd->bind_param('ssssssi',
			                    	$this->_args['tipo'],
			                    	$this->_args['endereco'],
			                    	$this->_args['complemento'],
			                    	$this->_args['cidade'],
			                    	$this->_args['uf'],
			                    	$this->_args['cep'],
			                    	$id
			                    );
			$qryupd->execute();
			$qryupd->close();

			return true;
		}
	}

	/**
	 * Resgata id do usuário
	 * @return bool
	 */
	public function getIdByUser($usr_id)
	{
		global $conn, $hashids;

		if (!is_numeric($usr_id)) {
			$usr_id = $hashids->decrypt($usr_id);
			$usr_id = $usr_id[0];
		}

		$sql = "SELECT adb_id FROM `".TP."_address_book` WHERE `adb_usr_id`=?;";
		if (!$res = $conn->prepare($sql))
			echo __FUNCTION__.$conn->error;
		else {
			$res->bind_param('i', $usr_id);
			$res->bind_result($id);
			$res->execute();
			$res->fetch();
			$res->close();
		}

		if (!empty($id)) return $id;
		else return false;
	}

	/**
	 * Resgata id do usuário
	 * @return bool
	 */
	public function getIdByCEP($cep)
	{
		global $conn;

		$sql = "SELECT adb_id FROM `".TP."_address_book` WHERE `adb_cep`=?;";
		if (!$res = $conn->prepare($sql))
			echo __FUNCTION__.$conn->error;
		else {
			$res->bind_param('s', $cep);
			$res->bind_result($id);
			$res->execute();
			$res->fetch();
			$res->close();
		}

		if (!empty($id)) return $id;
		else return false;
	}

	/**
	 * Dados básico do usuário
	 * @return bool
	 */
	public function getBasicInfoById($id)
	{
		global $conn, $hashids;

		if (!is_numeric($id)) {
			$id = $hashids->decrypt($id);
			$id = $id[0];
		}

		$sql = "SELECT
					 `adb_usr_id`,
					 `adb_tipo`,
					 `adb_endereco`,
					 `adb_complemento`,
					 `adb_cidade`,
					 `adb_uf`,
					 `adb_cep`
					FROM `".TP."_address_book`
					WHERE `adb_id`=?;";
		if (!$res = $conn->prepare($sql))
			echo __FUNCTION__.$conn->error;
		else {

			$res->bind_param('i', $id);
			$res->bind_result($usr_id, $tipo, $endereco, $complemento, $cidade, $uf, $cep);
			$res->execute();
			$res->fetch();
			$res->close();

			if (!empty($id)) {

				$addr = array(
			             'id'=>$hashids->encrypt($id),
			             'usr_id'=>$hashids->encrypt($usr_id),
			             'tipo'=>$tipo,
			             'endereco'=>$endereco,
			             'complemento'=>$complemento,
			             'cidade'=>$cidade,
			             'uf'=>$uf,
			             'cep'=>$cep
		             );

				return $addr;

			} else
				return false;
		}

	}

	/**
	 * Atualiza ultimo login
	 * @return bool
	 */
	public function removeAddress($id)
	{
		global $conn, $hashids, $aes;

		if (!is_numeric($id)) {
			$id = $hashids->decrypt($id);
			$id = $id[0];
		}

		$sql = "DELETE FROM `".TP."_address_book` WHERE `adb_id`=?;";
		if (!$res = $conn->prepare($sql))
			echo __FUNCTION__.$conn->error;
		else {
			$qry->bind_param('i', $id);
			$qry->execute();
			$qry->close();

			return true;
		}

	}

}