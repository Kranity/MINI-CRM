<?php
    session_start();
    include_once "../Config/config.php";
    $conexao = new BDConexao();
    if (isset($_GET["ide"]))
        $conexao->Excluir("empresas");
    if (isset($_GET["idf"]))
        $conexao->Excluir("funcionarios");
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" contet="width=device-width, initial-scale=1.0"/>
        <title>MINI - CRM</title>
        <link href="admin-usuario.css" type="text/css" rel="stylesheet"/>
    </head>
    <body>
        <div class="top">
            <h1 class="h1-top">MINI - CRM</h1>
            <a class="a-top" href="admin.php?admin=e">Empresas</a>
            <a class="a-top" href="admin.php?admin=f">Funcionário</a>
            <a class="a-top" href="../Login/login.php">Sair</a>
        </div>
        <?php
            if ($_SESSION["email"] == "admin@admin.com" && $_SESSION["senha"] == "password") {
                if ($_GET["admin"] == "e") {
                    echo "<div class='center'>";
                        echo "<div class='center1'>";
                            echo "<a href='../Adicionar/adicionar.php'><input class='input-center1' type='submit' value='Sistema de Cadastro'/></a>";
                            echo "<div class='center2'>";
                                echo "<h2 class='h2-center2'>Lista de empresas</h2>";
                                echo "<table class='table-center2'>";
                                    echo "<tr class='tr-center2'>";
                                        echo "<th class='th-center2'>Nome</th>";
                                        echo "<th class='th-center2'>Email</th>";
                                        echo "<th class='th-center2'>Logotipo</th>";
                                        echo "<th class='th-center2'>Site</th>";
                                        echo "<th class='th-center2' colspan='2'>Extra</th>";
                                    echo "</tr>";
                                        $retorno = $conexao->Buscar("empresas");
                                        if (!empty($retorno)) {
                                            $paginaAtual = isset($_GET["pagina"])?$_GET["pagina"]:1;
                                            $totalPagina = ceil(count($retorno) / 10);
                                            for ($contador = $paginaAtual * 10 - 10; $contador < $paginaAtual * 10; $contador++) {
                                                if (isset($retorno[$contador])) {
                                                    echo "<tr class='tr-center2'>";
                                                    foreach ($retorno[$contador] as $key => $value) {
                                                        if ($key != "id")
                                                            echo "<td class='td-center2'>$value</td>";
                                                    }
                                                ?>
                                                    <th class='td-center2'><a class='td-center2-extra' href='../Adicionar/adicionar.php?ide=<?php echo $retorno[$contador]['id'] ?>'>Editar</a></th>
                                                    <th class='td-center2'><a class='td-center2-extra' href='../Admin-Usuario/admin.php?admin=e&ide=<?php echo $retorno[$contador]['id'] ?>'>Excluir</a></th>
                                                <?php
                                                echo "</tr>";
                                                }
                                            }
                                        } 
                                    echo "</table>";
                                    for ($contador = 1; $contador <= $totalPagina; $contador++)
                                        echo "<a href='admin.php?admin=e&pagina=$contador'><input class='input-center2' type='submit' value='$contador'/></a>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    echo "<div class='bottom'></div>";
                } elseif ($_GET["admin"] == "f") {
                    echo "<div class='center'>";
                        echo "<div class='center1'>";
                            echo "<a href='../Adicionar/adicionar.php'><input class='input-center1' type='submit' value='Sistema de Cadastro'/></a>";
                            echo "<div class='center2'>";
                                echo "<h2 class='h2-center2'>Lista de funcionários</h2>";
                                echo "<table class='table-center2'>";
                                    echo "<tr class='tr-center2'>";
                                        echo "<th class='th-center2'>Nome</th>";
                                        echo "<th class='th-center2'>Sobrenome</th>";
                                        echo "<th class='th-center2'>Empresa</th>";
                                        echo "<th class='th-center2'>Email</th>";
                                        echo "<th class='th-center2'>Telefone</th>";
                                        echo "<th class='th-center2' colspan='2'>Extra</th>";
                                    echo "</tr>";
                                        $retorno = $conexao->Buscar("funcionarios");
                                        if (!empty($retorno)) {
                                            $paginaAtual = isset($_GET["pagina"])?$_GET["pagina"]:1;
                                            $totalPagina = ceil(count($retorno) / 10);
                                            for ($contador = $paginaAtual * 10 - 10; $contador < $paginaAtual * 10; $contador++) {
                                                if (isset($retorno[$contador])) {
                                                    echo "<tr class='tr-center2'>";
                                                    foreach ($retorno[$contador] as $key => $value) {
                                                        if ($key != "id")
                                                            echo "<td class='td-center2'>$value</td>";
                                                    }
                                                ?>
                                                    <th class='td-center2'><a class='td-center2-extra' href='../Adicionar/adicionar.php?idf=<?php echo $retorno[$contador]['id'] ?>'>Editar</a></th>
                                                    <th class='td-center2'><a class='td-center2-extra' href='../Admin-Usuario/admin.php?admin=f&idf=<?php echo $retorno[$contador]['id'] ?>'>Excluir</a></th>
                                                <?php
                                                echo "</tr>";
                                                }
                                            }
                                        }  
                                echo "</table>";
                                for ($contador = 1; $contador <= $totalPagina; $contador++)
                                    echo "<a href='admin.php?admin=f&pagina=$contador'><input class='input-center2' type='submit' value='$contador'/></a>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                    echo "<div class='bottom'></div>";
                }
            } elseif ($_SESSION["email"] != "admin@admin.com" && $_SESSION["senha"] != "password") {
                header("Location: ../Login/login.php");
            }
        ?>
    </body>
</html>
