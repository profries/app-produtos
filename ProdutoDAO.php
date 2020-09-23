<?php
require_once('Produto.php');

class ProdutoDAO {
    private $pdo;

    public function __construct(){ 
        $servername = "127.0.0.1";//ou "localhost"
        $username = "root";
        $password = "";
        $databasename = "crud_produtos";       
        try{
            $this->pdo = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password);
            // set the PDO error mode to exception
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);        
        }
        catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    function inserir(Produto $produto){
        try{
            $stmt = $this->pdo->prepare("INSERT INTO produtos (nome, preco)
            VALUES (:nome, :preco)");
            $stmt->bindParam(':nome', $produto->getNome());
            $stmt->bindParam(':preco', $produto->getPreco());
            $stmt->execute();
        } 
        catch(PDOException $e)
        {
            echo "Statement failed: " . $e->getMessage();
        }
    
    }
    
    function listar(){
        $listaProdutos = array();
        try{
            $stmt = $this->pdo->prepare("SELECT * FROM produtos");
            $stmt->execute();
            //Para construtores com parâmetros, deve-se passar valores iniciais para 
            //o fetch iniciar.
            //E o fetch_props_late serve para chamar o construtor e depois atribuir 
            //os dados - do contrário, o PDO faz o inverso (ou seja, os valores seriam os do array)
            $listaProdutos = $stmt->fetchAll(
                PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Produto', [0,'',0]);
            return $listaProdutos;
        }
        catch(PDOException $e)
        {
            echo "Statement failed: " . $e->getMessage();
        }
    }
    
    function buscarPorId($id){
        $q = "SELECT * FROM produtos WHERE id=:id";
        $comando = $this->pdo->prepare($q);
        $comando->bindParam(":id", $id);
        $comando->execute();
        $comando->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Produto', [0,'',0]);
        $obj = $comando->fetch();
        return($obj);
    
    }
    
    function deletar($id)
    {
        $qdeletar = "DELETE FROM produtos WHERE id=:id";
        $comando = $this->pdo->prepare($qdeletar);
    
        $comando->bindParam(':id',$id);
    
        $comando->execute();
    }
    
    function atualizar($id,Produto $produtoAlterado)
    {    
        $qAtualizar = "UPDATE produtos SET nome=:nome, preco=:preco WHERE id=:id";            
        $comando = $this->pdo->prepare($qAtualizar);
    
        $comando->bindValue(":nome",$produtoAlterado->getNome());
        $comando->bindValue(":preco",$produtoAlterado->getPreco());
        $comando->bindParam(":id",$id);
        $comando->execute();       
    }
}
?>
