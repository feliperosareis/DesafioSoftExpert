<?php

require_once("./helpers/DBConnection.php");

class ProdutosModel extends DBConnection
{
    protected $con;

    public function __construct()
    {
        $this->con = new DBConnection();
    }

    public function getProducts($hasStock = false)
    {
        $query  = "SELECT p.id, p.nome as produto, p.preco, p.descricao, p.estoque, t.nome as tipo, t.aliquota FROM produtos p ";
        $query .= "INNER JOIN tipos t ON t.id = p.id_tipo ";

        if ($hasStock)
        {
            $query .= "WHERE p.estoque > 0";
        }

        $query .= "ORDER BY p.nome";

        $result = pg_query($query);
        $products = pg_fetch_all($result);

        return $products;
    }

    public function save($product)
    {
        if (empty($product['id']))
        {
            if ($this->hasProduct($product['nome']))
            {
                return false;               
            }
            else
            {
                $result = pg_query("INSERT INTO produtos (nome, preco, id_tipo, descricao, estoque) VALUES ('".$product['nome']."', '".$product['preco']."', '".$product['id_tipo']."', '".$product['descricao']."', ".$product['estoque'].")");
            }
        }
        else
        {
            $result = pg_query("UPDATE produtos SET nome='".$product['nome']."', preco=".$product['preco'].", id_tipo=".$product['id_tipo'].", descricao='".$product['descricao']."', estoque=".$product['estoque']." WHERE id=".$product['id']);                
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

    public function findProduct($id)
    {
        $query = "SELECT * FROM produtos WHERE id=" . $id;
        $result = pg_query($query);
        return pg_fetch_assoc($result);
        
    }

    public function findProductJson($id)
    {
        $query = "SELECT * FROM produtos WHERE id=" . $id;
        $result = pg_query($query);
        $product = pg_fetch_assoc($result);

        return $product;
    }

    public function hasProduct($nome)
    {
        $query = "SELECT * FROM produtos WHERE nome='" . $nome . "'";
        $result = pg_query($query);

        if (pg_num_rows($result)) {
            return true;
        }
        return false;
    }

    public function deleteProduct($id)
    {
        $result = pg_query("DELETE FROM produtos WHERE id=" . $id);
    }

    public function updateStock($id_product, $quantity)
    {
        $item = $this->findProduct($id_product);

        $newStock = $item['estoque'] - $quantity;

        $result = pg_query("UPDATE produtos SET estoque = ". $newStock . " WHERE id=". $id_product);

    }

    public function devolution($id, $qttyReturned)
    {

        $product = $this->findProduct($id);
        $product['estoque'] = $product['estoque'] + $qttyReturned['estoque'];

        $result = pg_query("UPDATE produtos SET estoque=".$product['estoque']." WHERE id=".$product['id']);                
    }
}