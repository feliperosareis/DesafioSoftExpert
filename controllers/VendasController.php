<?php
session_start();

require_once("helpers/Helper.php");
require_once("./models/VendasModel.php");

class VendasController
{
    public $sell;
    public $products;

    
    public function __construct()
    {
        $this->sell = new VendasModel();
        $this->products = new ProdutosModel();

        
        if (!isset($_SESSION['codVenda']) || $_SESSION['codVenda'] == null)
        {
            $_SESSION['codVenda'] = str_replace(array("-", " ", ":", "pm", "am"), "", date('YmdHis'));
        }
        
    }

    public function show()
    {
        include('./views/vendas.php');
    }

    public function save()
    {
        $product['codigo_venda'] = $_POST['codigo_venda'];
        $product['id_produto']   = $_POST['id_produto'];
        $product['quantidade']   = $_POST['quantidade'];

        $this->products->updateStock($product['id_produto'], $product['quantidade']);
        
        $this->sell->save($product);
        
        header('location: ../venda/?cod='.$product['codigo_venda']);
        exit();
    }

    public function getVendas($codigo_venda)
    {
        $tmp = $this->sell->getVendas($codigo_venda);

        $subtotal = 0;
        $subtotal_impostos = 0;
        $total_compra = 0;

        $result = [];
        if (!empty($tmp))
        {
            for ($i = 0; $i < count($tmp); $i++)
            {
                $result[$i]['id']                = $tmp[$i]['id'];
                $result[$i]['id_produto']        = $tmp[$i]['id_produto'];
                $result[$i]['produto']           = $tmp[$i]['produto'];
                $result[$i]['tipo']              = $tmp[$i]['tipo'];
                $result[$i]['preco']             = $tmp[$i]['preco'];
                $result[$i]['quantidade']        = $tmp[$i]['quantidade'];
                $result[$i]['total_sem_imposto'] = $tmp[$i]['preco'] * $tmp[$i]['quantidade'];
                $result[$i]['aliquota']          = $tmp[$i]['aliquota'];
                $result[$i]['imposto']           = ($tmp[$i]['preco'] * $tmp[$i]['quantidade']) * ($tmp[$i]['aliquota'] / 100);
                $result[$i]['total_com_imposto'] = ($tmp[$i]['preco'] * $tmp[$i]['quantidade']) + ($tmp[$i]['preco'] * $tmp[$i]['quantidade']) * ($tmp[$i]['aliquota'] / 100);
    
                $subtotal           += $tmp[$i]['preco'] * $tmp[$i]['quantidade'];
                $subtotal_impostos  += ($tmp[$i]['preco'] * $tmp[$i]['quantidade']) * ($tmp[$i]['aliquota'] / 100);
                $total_compra       += ($tmp[$i]['preco'] * $tmp[$i]['quantidade']) + ($tmp[$i]['preco'] * $tmp[$i]['quantidade']) * ($tmp[$i]['aliquota'] / 100);
    
            }
        }
        
        $conta['itens'] = $result;

        $conta['subtotal'] = $subtotal;
        $conta['subtotal_impostos'] = $subtotal_impostos;
        $conta['total_compra'] = $total_compra;


        return $conta;
    }

    public function delete($id, $cod = null)
    {
        $this->sell->deleteSelling($id);

        header('location: ../../venda/?cod='.$cod);
        exit();
    }

    public function cancel()
    {
        
        $vendas = $this->getVendas($_GET['cod']);

        foreach($vendas['itens'] as $produto)
        {
            $id = $produto['id_produto'];
            $qtty['estoque'] = $produto['quantidade'];

            $this->products->devolution($id, $qtty);
            $this->sell->deleteSellingByIDProduto($id, $_GET['cod']);
        }

        session_destroy();
        header('location: /vendas');
    }

    public function finishSell()
    {
        session_destroy();
        header('location: /vendas');
    }
}
