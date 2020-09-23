<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require_once 'Produto.php';
require_once 'ProdutoDAO.php';

$app = AppFactory::create();

$app->get('/produtos', 
    function (Request $request, Response $response, $args) {
        
        $dao = new ProdutoDAO();        

        $data = $dao->listar();
        $payload = json_encode($data);
        
        $response->getBody()->write($payload);
        return $response
                  ->withHeader('Content-Type', 'application/json');
});

$app->run();