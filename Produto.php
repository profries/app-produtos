<?php 
class Produto{
    private $id, $nome, $preco;

    public function __construct($id, $nome, $preco){
        $this->id = $id;
        $this->nome = $nome;
        $this->preco = $preco;
    }

    public function getId(){
        return $this->id;
    }

    public function getNome(){
        return $this->nome;
    }

    public function getPreco(){
        return $this->preco;
    }

    public function setNome($nome){
        $this->nome = $nome;
    }

    public function setPreco($preco){
        $this->preco = $preco;
    }
}
?>