<?php
include_once 'categoria.php';
class Produto extends Categoria {

	public function __construct()
	{
		$this->_cupom = null;
		$this->_args = null;
		$args = array();
	}

	/**
	 * Valida se produto existe
	 * @return bool
	 */
	public function produtoExiste($pro_id)
	{
		global $conn, $hashids;

		if (!empty($pro_id)) {
			$pro_id = $hashids->decrypt($pro_id);
			$pro_id = $pro_id[0];
		}

		$sql = "SELECT SQL_CACHE NULL FROM `".TP."_produto` WHERE `pro_id`=?";
		if (!$res = $conn->prepare($sql))
			echo __FUNCTION__.$conn->error;
		else {
			$res->bind_param('i', $pro_id);
			$res->execute();
			$res->store_result();
			$num = $res->num_rows;
			$res->close();
		}

		if ($num>0) return false;
		else return true;
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
		$pro=array();


		$sql = "SELECT
					pro_id,
					pro_tipo,
					pro_fabricante,
					pro_grupoquimico,
					pro_codigo,
					pro_titulo,
					pro_descricao,
					pro_valor,
					pro_valor_unidade,
					pro_peso_unidade,
					pro_unidade_medida,
					pro_status,
					DATE_FORMAT(pro_data_cadastro, '%d/%m/%Y')
					FROM `".TP."_produto`
					WHERE `pro_id`=?;";
		if (!$res = $conn->prepare($sql))
			echo __FUNCTION__.$conn->error;
		else {

			$res->bind_param('i', $id);
			$res->bind_result($id, $tipo, $fabricante, $grupoquimico, $codigo, $titulo, $descricao, $valor, $valor_unidade, $peso_unidade, $unidade_medida, $status, $datacadastro);
			$res->execute();
			$res->fetch();
			$res->close();

			if (!empty($id)) {

				$gal = $this->getGaleriaProduto($id);
				$pro = array(
			             'id'=>$hashids->encrypt($id),
			             'tipo'=>$this->catTituloFromId($tipo),
			             'fabricante'=>$this->catTituloFromId($fabricante),
			             'grupoquimico'=>$this->catTituloFromId($grupoquimico),
			             'codigo'=>$codigo,
			             'titulo'=>$titulo,
			             'descricao'=>$descricao,
			             'valor'=>'R$ '.Currency2Decimal($valor),
			             'valor_unidade'=>'R$ '.Currency2Decimal($valor_unidade),
			             'peso_unidade'=>$peso_unidade,
			             'unidade_medida'=>$unidade_medida,
			             'galeria'=>$gal,
			             'status'=>$status,
			             'datacadastro'=>$datacadastro,
		             );

				return $pro;

			} else
				return false;
		}

	}

	private function getGaleriaProduto($pro_id)
	{
		global $conn;

		$gal=array();
		$sql = "SELECT
					rpg_imagem,
					rpg_legenda,
					rpg_pos
					FROM `".TP."_produto_galeria`
					WHERE `rpg_pro_id`=?
					ORDER BY rpg_pos;";
		if (!$res = $conn->prepare($sql))
			echo __FUNCTION__.$conn->error;
		else {

			$res->bind_param('i', $pro_id);
			$res->bind_result($imagem, $legenda, $pos);
			$res->execute();

			$i=0;
			while($res->fetch()) {
				$gal[$i] = array(
			             'img'=>$imagem,
			             'imagem'=>STATIC_PATH.'produto/'.$imagem,
			             'thumb'=>STATIC_PATH.'produto/thumb/'.$imagem,
			             'original'=>STATIC_PATH.'produto/original/'.$imagem,
			             'legenda'=>$legenda,
			             'position'=>$pos,
		             );
				$i++;
			}

			$res->close();

			return $gal;
		}

	}


}