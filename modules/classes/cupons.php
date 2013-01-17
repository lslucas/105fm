<?php

class GeraCupons {

	public function __construct()
	{
		$this->_timestart = microtime(true); //benchmark
		$this->_cupom = null;
	}

	private function validaParametros()
	{
		if (empty($this->_usrid))
			exit(__FUNCTION__.'Usuário inválido!');
		if (empty($this->_compraid))
			exit(__FUNCTION__.'ID da compra inválido!');
	}

	public function novoCupom($usrid, $compraid)
	{

		$this->_usrid = apenasNumeros($usrid);
		$this->_compraid = apenasNumeros($compraid);

		$this->resgataCupom();
		return $this->gravaCupom();
	}

	public function novoCupomBuffer()
	{
		$this->geraCupomBuffer();
		if ($this->limiteMaximo()===false)
			return $this->gravaCupomBuffer();
	}

	/**
	 * Gera cupom único de até N caracteres
	 * @return int _cupom Número do cupom
	 */
	private function geraCupomBuffer()
	{
		//gera o código e verifica se ele já existe antes de continuar
		do {
			$random = rand(1, 99999);
			$cupomcode = sprintf("%05d", (int)$random);

			//lenght do cupomcode tem de ser identico a 6
			if (strlen($cupomcode)==6)
				$result = $this->validaCupomBuffer($cupomcode);
		} while ($result===false);

		$this->_cupom = $cupomcode;
	}

	/**
	 * Resgata cupom
	 * @return bool
	 */
	private function resgataCupom()
	{
		global $conn;

		do {

			$sql = "SELECT cpm_codigo FROM `".TABLE_PREFIX."_cupom_buffer` WHERE `cpm_usado`=0 LIMIT 1;";
			$res = $conn->query($sql);
			$res = $res->fetch_array();
			$cupomcode = $res['cpm_codigo'];

			if (!$result = $this->validaCupom($cupomcode))
				$this->cupomUsado($cupomcode);

		} while ($result===false);

		$this->_cupom = $cupomcode;
	}

	/**
	 * Valida se cupom já existe
	 * @return bool
	 */
	private function validaCupom($cupomcode)
	{
		global $conn;

		$sql = "SELECT SQL_CACHE NULL FROM `".TABLE_PREFIX."_cupom` WHERE `cpm_codigo`=\"{$cupomcode}\"";
		$res = $conn->query($sql);
		$num = $res->num_rows;

		if ($num>0) return false;
		else return true;
	}

	/**
	 * Valida se cupom já existe
	 * @return bool
	 */
	private function validaCupomBuffer($cupomcode)
	{
		global $conn;

		$sql = "SELECT SQL_CACHE NULL FROM `".TABLE_PREFIX."_cupom_buffer` WHERE `cpm_codigo`=\"{$cupomcode}\"";
		$res = $conn->query($sql);
		$num = $res->num_rows;

		if ($num>0) return false;
		else return true;
	}

	private function gravaCupom()
	{
		global $conn;

		if ($this->validaCupom($this->_cupom)!==false) {
			$sqlins = "INSERT INTO `".TP."_cupom` (`cpm_codigo`, `cpm_cad_id`, `cpm_cpr_id`) VALUES (?,  ?,  ?)";
			if (!$qryins = $conn->prepare($sqlins))
				echo $conn->error;
				// return false;

			else {
				$qryins->bind_param('sii', $this->_cupom, $this->_usrid, $this->_compraid);
				$qryins->execute();
				$qryins->close();

				//diz a tabela de buffers que cupom já está usado
				$this->cupomUsado($this->_cupom);
				return $this->_cupom;
			}

		} else
			return false;
	}

	private function gravaCupomBuffer()
	{
		global $conn;

		if ($this->validaCupomBuffer($this->_cupom)!==false) {
			$sqlins = "INSERT INTO `".TP."_cupom_buffer` (`cpm_codigo`) VALUES (?)";
			if (!$qryins = $conn->prepare($sqlins))
				echo $conn->error;
				// return false;

			else {
				$qryins->bind_param('s', $this->_cupom);
				$qryins->execute();
				$qryins->close();

				//debug
				$this->_timeend = microtime(true); //benchmark
				$this->benchmark = round(($this->_timeend-$this->_timestart), 3);
				echo " |".$this->_cupom;
				$this->_cupom = null;
			}
		}
	}

	private function cupomUsado($cupom)
	{
		global $conn;

		$sqlupd = "UPDATE `".TP."_cupom_buffer` SET `cpm_usado`=1 WHERE `cpm_codigo`=?";
		if (!$qryupd = $conn->prepare($sqlupd))
			echo $conn->error; // return false;

		else {
			$qryupd->bind_param('s', $cupom);
			$qryupd->execute();
			$qryupd->close();
			return true;
		}
	}

	/**
	 * Calcula quantos faltam para o fim de cupons
	 * @return bool
	 */
	public function limiteMaximo($limit=99999)
	{
		global $conn;

		$sql = "SELECT COUNT(cpm_codigo) `total` FROM `".TP."_cupom_buffer`";
		$res = $conn->query($sql);
		$res = $res->fetch_array();
		$total = $res['total'];

		$resto = ($limit-$res['total']);

		if ($resto>0) return false;
		else return true;
	}

	/**
	 * Lista cupons de um usuário
	 * @return bool
	 */
	public function listCupons($usrid)
	{
		global $conn, $hashids;

		$usrid = $hashids->decrypt($usrid);
		$usrid = $usrid[0];

		if (empty($usrid))
			return __FUNCTION__.' Usuário inválido!';
		else {

			$compras = array();

			$sql = "SELECT
						cpr_id,
						cpr_coo,
						cpr_cnpj,
						cpr_estabelecimento,
						DATE_FORMAT(cpr_datacompra, '%d/%m/%Y'),
						prod.cat_titulo `produto`,
						cat.cat_titulo `categoria`,
						cpm_codigo

						FROM `".TP."_compra`
							INNER JOIN `".TP."_categoria` `prod`
								ON cat_id=cpr_prod_id
							INNER JOIN `".TP."_categoria` `cat`
								ON `cat`.cat_id=`prod`.`cat_idrel`
							INNER JOIN `".TP."_cupom`
								ON cpm_cpr_id=cpr_id
						WHERE `cpm_cad_id`=?
						ORDER BY cpr_timestamp DESC ";
			if (!$res = $conn->prepare($sql))
				return false;
			else {

				$res->bind_param('i', $usrid);
				$res->bind_result($id, $coo, $cnpj, $estabelecimento, $datacompra, $produto, $categoria, $codigo);
				$res->execute();

				while ($res->fetch()) {
					$compras[$id]['id'] = $hashids->encrypt($id);
					$compras[$id]['coo'] = $coo;
					$compras[$id]['cnpj'] = $cnpj;
					$compras[$id]['estabelecimento'] = $estabelecimento;
					$compras[$id]['data'] = $datacompra;
					$compras[$id]['produto'] = $categoria.' - '.$produto;
					$compras[$id]['cupom'] = $codigo;
				}

				$res->close();
			}

		return $compras;

		}
	}

}