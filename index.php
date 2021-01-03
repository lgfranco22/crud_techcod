<?php

require_once 'Pessoa.php';

$p = new Pessoa("techcod","localhost","root","root");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Pessoa</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <?php

    if(isset($_POST['nome']))//clicou em cadastrar ou editar
    {
        //------------editar----------------
        if(isset($_GET['id_up']) && !empty($_GET['id_up']))
        {
            $id_upd = addslashes($_GET['id_up']);
            $nome = addslashes(htmlspecialchars($_POST['nome']));
            $telefone = addslashes($_POST['telefone']);
            $email = addslashes($_POST['email']);
            if(!empty($nome) && !empty($telefone) && !empty($email))
            {
                $p->atualizarDados($id_upd, $nome ,$telefone ,$email);
                header("Location:index.php");
            }
            else
            {
    ?>
                <div class="aviso">
                    <img src="aviso.png" alt="aviso">
                   <h4>Preencha todos os campos</h4>
                </div> 
            <?php
            }
        }
        //------------cadastrar----------------
        else
        {
            $nome = addslashes(htmlspecialchars ($_POST['nome']));
            $telefone = addslashes($_POST['telefone']);
            $email = addslashes($_POST['email']);
            if(!empty($nome) && !empty($telefone) && !empty($email))
            {
                if(!$p->cadastrarPessoa($nome ,$telefone ,$email))
                {
                    ?>
                <div class="aviso">
                    <img src="aviso.png" alt="aviso">
                   <h4>Email ja cadastrado</h4>
                </div> 
               <?php
                }
            }
            else
            {
                ?>
                    <div class="aviso">
                        <img src="aviso.png" alt="aviso">
                        <h4>Preencha todos os campos</h4>
                    </div> 
               <?php
            }
        }
    }
    ?>
    <?php
        if(isset($_GET['id_up'])) //se a pessoa clicou no editar
        {
            $id_update = addslashes($_GET['id_up']);
            $res = $p->buscarDadosPessoa($id_update);
        }
    ?>
    <section id="esquerda">
        <form method="POST">
            <h2>Cadastrar Pessoa</h2>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" 
		value="<?php if(isset($res)){echo $res['nome'];}?>">
            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" id="telefone" 
		value="<?php if(isset($res)){echo $res['telefone'];}?>">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" 
		value="<?php if(isset($res)){echo $res['email'];}?>">
            <input type="submit" 
		value="<?php if(isset($res)){echo 'Atualizar';}else{echo 'Cadastrar';}?>">
        </form>
    </section>
    <section id="direita">
        <table>
                <tr id="titulo">
                    <td>Nome</td>
                    <td>Telefone</td>
                    <td colspan="2">Email</td>
                </tr>
        <?php

        $dados = $p->buscarDados();
        if(count($dados) > 0)
        {
            for ($i=0; $i < count($dados); $i++) {
                 echo "<tr>";
                foreach ($dados[$i] as $k => $v) {
                    if($k != "id")
                    {
                        echo "<td>".$v."</td>";
                    }
                }
                ?>
                    <td>
                        <a href="index.php?id_up=<?php echo $dados[$i]['id']; ?>">Editar</a> 
                        <a href="index.php?id=<?php echo $dados[$i]['id']; ?>">Excluir</a>
                    </td>
                <?php
                echo "</tr>";
            }
        }
        else{
            ?>
            </table>
                <div class="aviso">
                    <h4>Não ha pessoas cadastradas</h4>
                </div> 
            <?php
        }
        ?>
    </section>
</body>
</html>

<?php
if(isset($_GET['id']))
{
    $id_pessoa = addslashes($_GET['id']);
    $p->excluirPessoa($id_pessoa);
    header("Location:index.php");
}
?>
