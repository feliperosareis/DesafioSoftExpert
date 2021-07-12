<?php

require_once("./helpers/DBConnection.php");

class VendasModel extends DBConnection
{
    protected $con;

    public function __construct()
    {
        $this->con = new DBConnection();
    }

    public function save($produto)
    {
        if (empty($produto['id']))
        {
            $result = pg_query("INSERT INTO vendas (cod_venda, id_produto, quantidade) VALUES (".$produto['codigo_venda'].", ".$produto['id_produto'].", ".$produto['quantidade'].")");
        }
        else
        {
            $result = pg_query("UPDATE vendas SET cod_venda=".$produto['codigo_venda'].", id_produto=".$produto['id_produto'].", quantidade=".$produto['quantidade']." WHERE id=".$produto['id']);                
        }

        if ($result) 
        {
            return true;
        } 
        else 
        {
            return false;
        }
    }

    public function getVendas($codigo_venda)
    {
        $query  = "SELECT v.id, p.id as id_produto, p.nome as produto, t.nome as tipo, v.quantidade, p.preco, t.aliquota FROM vendas v ";
        $query .= "INNER JOIN produtos p ON p.id = v.id_produto ";
        $query .= "INNER JOIN tipos t ON t.id = p.id_tipo ";
        $query .= "WHERE v.cod_venda = '".$codigo_venda. "'";

        $result = pg_query($query);
        $vendas = pg_fetch_all($result);
        return $vendas;
    }


    public function deleteSelling($id)
    {
        $result = pg_query("DELETE FROM vendas WHERE id=" . $id);
    }

    public function deleteSellingByIDProduto($id, $codigo_venda)
    {
        $result = pg_query("DELETE FROM vendas WHERE id_produto=" . $id. " AND cod_venda='".$codigo_venda."'");
    }
}