-- Criar banco `crud_produtos``
CREATE DATABASE IF NOT EXISTS crud_produtos;

--
-- Estrutura da tabela `produtos`
--
CREATE TABLE IF NOT EXISTS produtos (
  id int(11) NOT NULL AUTO_INCREMENT , 
  nome varchar(30) NOT NULL,
  preco decimal(10,2) NOT NULL,
  PRIMARY KEY (id)
) ;
