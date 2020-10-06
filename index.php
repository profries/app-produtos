<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

include_once 'ProdutoDAO.php';
include_once 'Produto.php';


require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$app->get('/api/produtos', 
    function (Request $request, Response $response, $args) {
        
        $dao = new ProdutoDAO();        

        $data = $dao->listar();
        $payload = json_encode($data);
        
        $response->getBody()->write($payload);
        return $response
                  ->withHeader('Content-Type', 'application/json');
});


$app->post('/api/produtos', function (Request $request, Response $response, array $args) {
    //Adicione nome e preço no request (formato JSON)
    $data = $request->getParsedBody();
    $produto = new Produto(0,$data['nome'],$data['preco']);

    $dao = new ProdutoDAO;
    $produto = $dao->inserir($produto);
    $payload = json_encode($produto);
        
    $response->getBody()->write($payload);
    return $response
              ->withHeader('Content-Type', 'application/json')
              ->withStatus(201);

});

$app->get('/api/produtos/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    
    $dao= new ProdutoDAO;    
    $produto = $dao->buscarPorId($id);
    
    $payload = json_encode($produto);
        
    $response->getBody()->write($payload);
    return $response
              ->withHeader('Content-Type', 'application/json');
});

$app->put('/api/produtos/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $data = $request->getParsedBody();
    $produto = new Produto($id, $data['nome'], $data['preco']);

    $dao = new ProdutoDAO;
    $produto = $dao->atualizar($id,$produto);

    $payload = json_encode($produto);
        
    $response->getBody()->write($payload);
    return $response
              ->withHeader('Content-Type', 'application/json');
});

$app->delete('/api/produtos/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];

    $dao = new ProdutoDAO;
    $produto = $dao->deletar($id);

    $payload = json_encode($produto);
        
    $response->getBody()->write($payload);
    return $response
              ->withHeader('Content-Type', 'application/json');
});

$app->run();