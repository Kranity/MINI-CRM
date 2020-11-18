<?php
    session_start();
    include_once "../Config/config.php";
    $conexao = new BDConexao();
    if (isset($_POST["cadastrar-empresa"]))
        $conexao->Cadastrar("empresas");
    elseif (isset($_POST["cadastrar-funcionario"]))
        $conexao->Cadastrar("funcionarios");
    if (isset($_GET["ide"]))
        $conexao->Editar("empresas");
    elseif (isset($_GET["idf"]))
        $conexao->Editar("funcionarios");
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" contet="width=device-width, initial-scale=1.0"/>
        <title>MINI - CRM</title>
        <link href="adicionar.css" type="text/css" rel="stylesheet"/>
    </head>
    <body>
        <div class="top">
            <h1 class="h1-top">MINI - CRM</h1>
            <a class="a-top" href="../Admin-Usuario/admin.php?admin=e">Empresas</a>
            <a class="a-top" href="../Admin-Usuario/admin.php?admin=f">Funcionário</a>
            <a class="a-top" href="../Login/login.php">Sair</a>
        </div>
        <div class="center">
            <?php
                if ($_SESSION["email"] == "admin@admin.com" && $_SESSION["senha"] == "password") {
                    if (isset($_GET["ide"]))
                        echo "<h2 class='h2-center'>Editar empresa</h2>";
                    elseif (!isset($_GET["ide"]))
                        echo "<h2 class='h2-center'>Adicionar nova empresa</h2>";
                    echo "<form class='form-center' method='POST'>";
                    if (isset($_GET["ide"])) {
                        $retorno = $conexao->BuscarEditar();
                        if (!empty($retorno)) {
                            echo "<input class='input-center' type='text' name='nome-empresa' placeholder='Nome' value='$retorno[nome]' autocomplete='off' required/>";
                            echo "<input class='input-center' type='email' name='email-empresa' placeholder='E-mail' value='$retorno[email]' autocomplete='off'/>";
                            echo "<input class='input-center' type='file' name='logotipo-empresa' value='$retorno[logotipo]' autocomplete='off'/>";
                            echo "<input class='input-center' type='text' name='site-empresa' placeholder='Site' value='$retorno[site]' autocomplete='off'/>";
                            if (isset($_POST["editar-empresa"]))
                                header("Location: ../Admin-Usuario/admin.php?admin=e");
                        }
                    } elseif (!isset($_GET["ide"])) {
                        echo "<input class='input-center' type='text' name='nome-empresa' placeholder='Nome' autocomplete='off' required/>";
                        echo "<input class='input-center' type='email' name='email-empresa' placeholder='E-mail' autocomplete='off'/>";
                        echo "<input class='input-center' type='file' name='logotipo-empresa' autocomplete='off'/>";
                        echo "<input class='input-center' type='text' name='site-empresa' placeholder='Site' autocomplete='off'/>";
                    }
                    if (isset($_GET["ide"]))
                        echo "<input class='input-center' type='submit' name='editar-empresa' value='Editar'/>";    
                    elseif (!isset($_GET["ide"]))
                        echo "<input class='input-center' type='submit' name='cadastrar-empresa' value='Cadastrar'/>";
                    echo "</form>";
                    echo "<hr class='hr-center'>";
                    if (isset($_GET["idf"]))
                        echo "<h2 class='h2-center'>Editar funcionário</h2>";
                    elseif (!isset($_GET["idf"]))
                        echo "<h2 class='h2-center'>Adicionar novo funcionário</h2>";
                    echo "<form class='form-center' method='POST'>";
                    if (isset($_GET["idf"])) {
                        $retorno = $conexao->BuscarEditar();
                        if (!empty($retorno)) {
                            echo "<input class='input-center' type='text' name='nome-funcionario' placeholder='Nome' value='$retorno[nome]' autocomplete='off' required/>";
                            echo "<input class='input-center' type='text' name='sobrenome-funcionario' placeholder='Sobrenome' value='$retorno[sobrenome]' autocomplete='off' required/>";
                            echo "<select class='input-center' name='empresa-funcionario'>";
                            echo "<option selected>$retorno[empresa]</option>";
                                $retorno1 = $conexao->Empresas();
                                if (!empty($retorno1)) {
                                    for ($contador = 0; $contador < count($retorno1); $contador++) {
                                        foreach ($retorno1[$contador] as $key => $value) {
                                            if ($retorno["empresa"] != $value)
                                                echo "<option>$value</option>";
                                        }
                                    }
                                }
                            echo "<select>";
                            echo "<input class='input-center' type='email' name='email-funcionario' placeholder='E-mail' value='$retorno[email]' autocomplete='off'/>";
                            echo "<input class='input-center' type='tel' name='telefone-funcionario' placeholder='Telefone' value='$retorno[telefone]' autocomplete='off'/>";
                            if (isset($_POST["editar-funcionario"]))
                                header("Location: ../Admin-Usuario/admin.php?admin=f");
                        }
                    } elseif (!isset($_GET["idf"])) {
                        echo "<input class='input-center' type='text' name='nome-funcionario' placeholder='Nome' autocomplete='off' required/>";
                        echo "<input class='input-center' type='text' name='sobrenome-funcionario' placeholder='Sobrenome' autocomplete='off' required/>";
                        echo "<select class='input-center' name='empresa-funcionario'>";
                        echo "<option disabled selected>Qual empresa?</option>";
                            $retorno1 = $conexao->Empresas();
                            if (!empty($retorno1)) {
                                for ($contador = 0; $contador < count($retorno1); $contador++) {
                                    foreach ($retorno1[$contador] as $key => $value)
                                        echo "<option>$value</option>";
                                }
                            }
                        echo "<select>";
                        echo "<input class='input-center' type='email' name='email-funcionario' placeholder='E-mail' autocomplete='off'/>";
                        echo "<input class='input-center' type='tel' name='telefone-funcionario' placeholder='Telefone' autocomplete='off'/>";
                    }
                    if (isset($_GET["idf"]))
                        echo "<input class='input-center' type='submit' name='editar-funcionario' value='Editar'/>";    
                    elseif (!isset($_GET["idf"]))
                        echo "<input class='input-center' type='submit' name='cadastrar-funcionario' value='Cadastrar'/>";
                    echo "</form>";
                } elseif ($_SESSION["email"] != "admin@admin.com" && $_SESSION["senha"] != "password") {
                    header("Location: ../Login/login.php");
                }
            ?>
        </div>
    </body>
</html>
