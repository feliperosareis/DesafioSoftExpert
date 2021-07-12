<?php

require_once "./models/ProdutosModel.php";

class ProdutosController
{
    public $products;

    public function __construct() 
    {
        $this->products = new ProdutosModel();
        
    }

    public function show()
    {
        include('./views/produtos.php');
    }

    public function getProducts()
    {
        $result = $this->products->getProducts();
        return $result;
    }

    public function getProdutosDisponiveis()
    {
        $result = $this->products->getProducts(true);
        return $result;
    }

    public function save()
    {
        $product['id']        = $_POST['id'];
        $product['nome']      = $_POST['nome'];
        $product['id_tipo']   = $_POST['id_tipo'];
        $product['preco']     = formatCurrency($_POST['preco']);
        $product['descricao'] = $_POST['descricao'];
        $product['estoque']   = $_POST['estoque'];

        $msg = '';
        if ( $this->products->save($product) )
        {
            $msg = 1;
        }
        else
        {
            $msg = 2;
        }
        
        header('location: /produtos');
        exit();
    }

    public function find($id)
    {
        return $this->products->findProduct($id);
    } 

    public function findJson($id)
    {
        die(json_encode($this->products->findProduct($id)));
    } 

    public function delete($id)
    {
        $this->products->deleteProduct($id);

        header('location: /produtos');
        exit();
    }
}

