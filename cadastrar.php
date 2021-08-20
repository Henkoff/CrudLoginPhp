
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/estilo.css">
    <title>Login</title>
</head>
<body>
    <div id="corpo-form">
    <h1>CADASTRO NO SISTEMA</h1>
    <form method="POST">
        <input type="text" name="nome" placeholder="nome" maxlength="255">
        <input type="email" name="email" placeholder="email" maxlength="40">
        <input type="password" name="senha" placeholder="senha" maxlength="40">
        <input type="password"  name="conf-senha"placeholder="senha confirmar" maxlength="40">
        <input type="submit" value="Cadastrar">

    </form>
</div>
<?php

require_once 'classes/usuarios.php';
$u = new Usuario;

//verificar se a pessoa clicou no botao cadastrar
if (isset($_POST['nome']))
{
    $nome =  addslashes($_POST['nome']);
    $email =  addslashes($_POST['email']);
    $senha =  addslashes($_POST['senha']);
    $confirmarSenha =  addslashes($_POST['conf-senha']);
    //verificar se esta preenchido ou não
    if(!empty($nome) && !empty($email) && !empty($senha) && !empty($confirmarSenha))
    {
        $u->conectar("projeto_usuarios_crud", "127.0.0.1", "root", "");
        if($u->msgErro == "")
        {
            if($senha == $confirmarSenha)
            {
                 if($u->cadastrar($nome, $email, $senha))
                 { 
                    echo "cadastrado com sucesso";
                 }
                 else
                 {
                     echo "email ja cadastrado";
                 }
            }
            else
            {
                echo "SENHA E CONFIRMAR SENHA NAO CORRESPONDEM";
            }
        }
        else
        {
            echo "Erro: ".$u->msgErro;
        }
    }
    else
    {
        echo "Preencha todos os campos antes de continuar!";
    }
}







?>
</body>
</html>