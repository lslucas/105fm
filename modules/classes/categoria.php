<?php
class Categoria {

	public function __construct()
	{
		$this->_args = null;
		$args = array();
	}

	/**
	 * Valida se produto existe
	 * @return bool
	 */
	public function categoriaExiste($id)
	{
		global $conn, $hashids;

		if (!empty($id)) {
			$id = $hashids->decrypt($id);
			$id = $id[0];
		}

		$sql = "SELECT SQL_CACHE NULL FROM `".TP."_categoria` WHERE `cat_id`=?";
		if (!$res = $conn->prepare($sql))
			echo __FUNCTION__.$conn->error;
		else {
			$res->bind_param('i', $id);
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
	public function catTituloFromId($id)
	{
		global $conn, $hashids;

		if (empty($id))
			return false;

		if (!is_numeric($id)) {
			$id = $hashids->decrypt($id);
			$id = $id[0];
		}

		$sql = "SELECT cat_titulo FROM `".TP."_categoria` WHERE `cat_id`=?;";
		if (!$res = $conn->prepare($sql))
			echo __FUNCTION__.$conn->error;
		else {

			$res->bind_param('i', $id);
			$res->bind_result($titulo);
			$res->execute();
			$res->fetch();
			$res->close();

			if (!empty($titulo))
				return $titulo;
			else
				return false;
		}

	}


	/** Dados
	 * @return bool
	 */
	public function listCategoriasFromArea($area, $idrel=null, $status=1)
	{
		global $conn, $hashids;

		$whr = null;
		if (!empty($idrel))
			$whr .= " AND cat_idrel=\"{$idrel}\"";

		$list = array();
		$sql = "SELECT cat_id, cat_titulo FROM `".TP."_categoria` WHERE `cat_area`=? AND cat_status=? {$whr};";
		if (!$res = $conn->prepare($sql))
			echo __FUNCTION__.$conn->error;
		else {

			$res->bind_param('si', $area, $status);
			$res->bind_result($id, $titulo);
			$res->execute();

			while ($res->fetch()) {
				$list[$id] = trim($titulo);
			}

			$res->close();

			if (count($list)>0)
				return $list;
			else
				return false;
		}

	}

}