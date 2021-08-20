<?php

require_once 'classes/pessoa.php';
$p = new Pessoa("projeto_usuarios_crud", "127.0.0.1", "root", "");

session_start();

if(!isset($_SESSION['id_usuario']))
{
    header("location: index.php");
    exit;
}



?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/estilo2.css">
    <title>Login</title>
</head>
<body>
    <?php

    if(isset($_GET['id_up']))
    {
        $p->conectar("projeto_usuarios_crud", "127.0.0.1", "root", "");
        $id_update = addslashes($_GET['id_up']);
        $res = $p->buscarDadosPessoa($id_update);
    }
    ?>
    <section id="esquerda">
            <div id="corpo-form">
            <form method="POST">
                <h1>CADASTRO NO SISTEMA</h1>
                <label for="nome">Nome:</label>
                <input type="text" name="nome" placeholder=" Nome" maxlength="255"
                value="<?php  if(isset($res)){echo $res['nome'];} ?>"
                >
                <label for="nome">Email:</label>
                <input type="email" name="email" placeholder="  Email" maxlength="40"
                value="<?php  if(isset($res)){echo $res['email'];}?>">
                <label for="nome">Senha:</label>
                <input type="password" name="senha" placeholder="  Senha" maxlength="40"
                value="<?php  if(isset($res)){echo $res['senha'];}?>">
                <label for="nome">Confirmar Senha:</label>
                <input type="password"  name="conf-senha"placeholder="  Confirmar Senha" maxlength="40"
                value="<?php  if(isset($res)){echo $res['senha'];}?>">
                <input type="submit" value="<?php if(isset($res)){echo "Atualizar";}else{echo "Cadastrar";}?>">
            </form>
        </div>
    </section>
    <section id="direita">
        <table>
        <tr id="titulo">
                    <td>Nome</td>
                    <td>Email</td>
                    <td colspan="2">Senha</td>
                </tr>
        <?php
            $p->conectar("projeto_usuarios_crud", "127.0.0.1", "root", "");
            $dados = $p->buscarDados();
            if(count($dados) > 0)
            {
                for ($i=0; $i < count($dados); $i++)
                { 
                    echo "<tr>";
                    foreach ($dados[$i] as $key => $value) 
                    {
                        if($key != "id_usuario")
                        {
                            echo "<td>".$value."</td>";
                        
                        }
                    }
                    ?>
                    <td>
                        <a href="areaPrivada.php?id_up=<?php
                        echo $dados[$i]['id_usuario']; 
                    ?>">Editar</a>
                    <a href="areaPrivada.php?id_usu=<?php
                        echo $dados[$i]['id_usuario']; 
                    ?>">Excluir</a></td>
                    <?php
                    echo "</tr>";
                }
        
                
    }
            ?>
            </table>
            <?php
            if (isset($_POST['nome']))//clicou no botao cadastrar ou editar
            {
                if(isset($_GET['id_up']) && !empty($_GET['id_up']))
                {
                    $id_upd = addslashes($_GET['id_up']);
                    $nome =  addslashes($_POST['nome']);
                    $email =  addslashes($_POST['email']);
                    $senha =  addslashes($_POST['senha']);
                    $confirmarSenha =  addslashes($_POST['conf-senha']);
                    //verificar se esta preenchido ou não
                    if(!empty($nome) && !empty($email) && !empty($senha) && !empty($confirmarSenha))
                    {
                        $p->conectar("projeto_usuarios_crud", "127.0.0.1", "root", "");

                        {
                            if($senha == $confirmarSenha)
                            {
                                $p->conectar("projeto_usuarios_crud", "127.0.0.1", "root", "");
                                 if($p->atualizarDados($id_upd, $nome, $email, $senha));
                                 header("location: areaPrivada.php");

                            }
                            else
                            {
                                echo "Preencha todos os campos antes de continuar!";
                            }
                        }
                    }
            
                

                }else 
                    {
                        $nome =  addslashes($_POST['nome']);
                        $email =  addslashes($_POST['email']);
                        $senha =  addslashes($_POST['senha']);
                        $confirmarSenha =  addslashes($_POST['conf-senha']);
                        //verificar se esta preenchido ou não
                        if(!empty($nome) && !empty($email) && !empty($senha) && !empty($confirmarSenha))
                        {
                            $p->conectar("projeto_usuarios_crud", "127.0.0.1", "root", "");
                            if($p->msgErro == "")
                            {
                                if($senha == $confirmarSenha)
                                {
                                     if($p->cadastrar($nome, $email, $senha))
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
                                echo "Erro: ".$p->msgErro;
                            }
                        }
                        else
                        {
                            echo "Preencha todos os campos antes de continuar!";
                        }
                    }

                

            }
        ?>  

        
    </section>
</body>
</html>

<?php
            
            if(isset($_GET['id_usu']))
            {   
                $idp = addslashes($_GET['id_usu']);
                $p->excluirPessoa($idp);
                header("location: areaPrivada.php");
            }


?>