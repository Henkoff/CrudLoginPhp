<?php

Class Pessoa 
{

    private $pdo;
    public $msgErro = "";
    //conexao com bd
    public function conectar($nome, $host, $usuario, $senha)
    {
        global $pdo;
        global $msgErro;
        try
        {
            $pdo = new PDO("mysql:dbname=".$nome."; host=".$host, $usuario, $senha);
        }
        catch (PDOException $e)
        {
            $msgErro = $e->getMessage();
        }
    }
    //função buscar para preencher tabela do lado direito da tela

    public function buscarDados()
    {  
        global $pdo;
        $res = array();
        $cmd = $pdo->query("SELECT * FROM usuarios ORDER BY nome DESC");
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function cadastrar($nome, $email, $senha)
    {
        global $pdo;
        //verificar se ja existe email cadastrado- se nao- permite cadastro
        $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e");
        $sql->bindValue(":e", $email);
        $sql->execute();
        if($sql->rowCount() > 0)
        {
            return false; //pessoa ja esta cadastrada
        }
        else
        {
            //nao cadastrado, cadastrar...
            $sql = $pdo->prepare("INSERT INTO usuarios(nome, email, senha) VALUES (:n, :e, :s)");
            $sql->bindValue(":n", $nome);
            $sql->bindValue(":e", $email);
            $sql->bindValue(":s", md5($senha));
            $sql->execute();
            return true;

        }

    }

    public function excluirPessoa($id)
    
    {
        global $pdo;
        $cmd = $pdo->prepare("DELETE FROM usuarios WHERE id_usuario = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }


    public function buscarDadosPessoa($id)
    {
        global $pdo;
        $res = array();
        $cmd = $pdo->prepare("SELECT * FROM usuarios WHERE id_usuario = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    public function atualizarDados($id, $nome, $email, $senha)
    {
        global $pdo;

            $cmd = $pdo->prepare("UPDATE usuarios SET nome = :n, email = :e, senha = :s WHERE id_usuario = :id");
            $cmd->bindValue(":n", $nome);
            $cmd->bindValue(":e", $email);
            $cmd->bindValue(":s", $senha);
            $cmd->bindValue(":id", $id);
            $cmd->execute();
            
    
    }

}

?>