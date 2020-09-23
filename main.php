<?php 
require_once('Produto.php');
require_once('ProdutoDAO.php');



$dao = new ProdutoDAO();
$dao->inserir(new Produto(0,"ProdX",310));
$dao->atualizar(1,new Produto(1,"Prod1",35));
$dao->deletar(5);
print_r($dao->buscarPorId(1));
 print_r($dao->listar());
?>