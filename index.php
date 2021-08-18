<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/estilo.css">
    <title>Login</title>
</head>
<body>
    <div id="corpo-form">
    <h1>ENTRAR NO SISTEMA</h1>
    <form method="POST">
        <input type="email" name="email" placeholder="usuario">
        <input type="password" name="senha" placeholder="senha">
        <input  type="submit" value="Acessar">
        <a href="cadastrar.php"> ainda nao é inscrito?<strong> INSCREVA-SE</strong></a>
    </form>
</div>
<?php

require_once 'classes/usuarios.php';
$u = new Usuario;

//verificar se a pessoa cliclo no botao cadastrar
if (isset($_POST['email']))
{
    $email =  addslashes($_POST['email']);
    $senha =  addslashes($_POST['senha']);
    //verificar se esta preenchido ou não
    if(!empty($email) && !empty($senha))
    {  
        $u->conectar("projeto_usuarios_crud", "127.0.0.1", "root", "");
        if($u->msgErro == "")
        {
            if($u->logar($email, $senha))
            {
                header("location: AreaPrivada.php");
            }
            else
            {
                echo "email e/ou senha incorretos";
            }
        }
      else
        {
            echo "Erro: ".$u->msgErro;
        }
    }
}
else
    {
        echo "Preencha todos os campos!";
    }
        



?>
</body>
</html>