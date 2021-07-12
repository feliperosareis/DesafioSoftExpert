<?php

require_once "helpers/Router.php";
require_once "controllers/ProdutosController.php";
require_once "controllers/TiposController.php";
require_once "controllers/VendasController.php";

route('/', function () {
    include('views/login.php');
});

route('/tipos', function () {
    $tipos = new TiposController();
    $tipos->show();
});

route('/tipos/add', function () {
    $tipos = new TiposController();
    $tipos->save();
});

route('/produtos', function () {
    $produtos = new ProdutosController();
    $produtos->show();
});

route('/produtos/add', function () {
    $produtos = new ProdutosController();
    $produtos->save();
});

route('/vendas', function () {
    $vendas = new VendasController();
    $vendas->show();
});


route('/venda/close', function () {
    $vendas = new VendasController();
    $vendas->finishSell();
});


if (isset($_POST['codigo_venda']))
{
    route('/vendas/add', function () {
        $vendas = new VendasController();
        $vendas->save();
    });

}


if (isset($_GET['cod']))
{
    
    route('/venda/?cod='.$_GET['cod'], function () {
        $vendas = new VendasController();
        $vendas->show();
    });
    
    route('/venda/cancel/?cod='.$_GET['cod'], function(){
        $vendas = new VendasController();
        $vendas->cancel();
        
    });
}


if (isset($_GET['id']))
{

    route('tipos/find/?id='.$_GET['id'], function () {
        $tipos = new TiposController();
        $tipos->find($_GET['id']);
    });

    route('/tipos/delete/?id='.$_GET['id'] , function () {
        $tipos = new TiposController();
        $tipos->delete($_GET['id']);
    });

    route('produtos/find/?id='.$_GET['id'], function () {
        $produtos = new ProdutosController();
        $produtos->find($_GET['id']);
    });

    route('produtos/findjson/?id='.$_GET['id'], function () {
        $produtos = new ProdutosController();
        $produtos->findJson($_GET['id']);
    });

    route('/produtos/delete/?id='.$_GET['id'] , function () {
        $produtos = new ProdutosController();
        $produtos->delete($_GET['id']);
    });

    if (isset($_GET['cod_venda']))
    {
        route('/vendas/delete/?id='.$_GET['id'].'&cod_venda='.$_GET['cod_venda'] , function () {
            $vendas = new VendasController();
            $vendas->delete($_GET['id'], $_GET['cod_venda']);
        });
    }
}


$action = $_SERVER['REQUEST_URI'];
dispatch($action, function(){
    "erro";
});
