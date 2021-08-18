<?php 

Class Usuario
{
    private $pdo;
    public $msgErro = "";

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
    public function logar($email, $senha)
    {
        global $pdo;
        //verificar se email e sneha estao cadastrados

        $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e AND senha = :s");
        $sql->bindValue(":e", $email);
        $sql->bindValue(":s", md5($senha));
        $sql->execute();
        if($sql->rowCount() > 0)
        {
            //entrar no sistema(caso estiver cadastrado)
            $dado = $sql->fetch();
            session_start();
            $_SESSION['id_usuario'] = $dado['id_usuario'];
            return true; //se estiver cadastrado
        }
        else
        {

            return false;// se nao foi possivel logar-se nao foi localixada no BD

        }

        
    }

}



?>