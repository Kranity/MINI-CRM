<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8"/>
        <title>MINI - CRM</title>
        <link href="admin-usuario.css" type="text/css" rel="stylesheet"/>
        <meta name="viewport" contet="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
        <div class="top">
            <h1 class="h1-top">MINI - CRM</h1>
            <a class="a-top" href="../Admin-Usuario/usuario.php?usuario=e">Empresas</a>
            <a class="a-top" href="../Admin-Usuario/usuario.php?usuario=f">Funcionário</a>
            <a class="a-top" href="../Login/login.php">Sair</a>
        </div>
        <?php
            include_once "../Config/config.php";
            $conexao = new BDConexao();
            if ($_SESSION["email"] == "user@user.com" && $_SESSION["senha"] == "password") {
                if ($_GET["usuario"] == "e") {
                    echo "<div class='center'>";
                        echo "<div class='center1'>";
                            echo "<div class='center2'>";
                                echo "<h2 class='h2-center2'>Lista de empresas</h2>";
                                echo "<table class='table-center2'>";
                                    echo "<tr class='tr-center2'>";
                                        echo "<th class='th-center2'>Nome</th>";
                                        echo "<th class='th-center2'>Email</th>";
                                        echo "<th class='th-center2'>Logotipo</th>";
                                        echo "<th class='th-center2'>Site</th>";
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
                                                echo "</tr>";
                                                }
                                            }
                                        }  
                                echo "</table>";
                                for ($contador = 1; $contador <= $totalPagina; $contador++)
                                    echo "<a href='usuario.php?usuario=e&pagina=$contador'><input class='input-center2' type='submit' value='$contador'/></a>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                } elseif($_GET["usuario"] == "f") {
                    echo "<div class='center'>";
                        echo "<div class='center1'>";
                            echo "<div class='center2'>";
                                echo "<h2 class='h2-center2'>Lista de funcionários</h2>";
                                echo "<table class='table-center2'>";
                                    echo "<tr class='tr-center2'>";
                                        echo "<th class='th-center2'>Nome</th>";
                                        echo "<th class='th-center2'>Sobrenome</th>";
                                        echo "<th class='th-center2'>Empresa</th>";
                                        echo "<th class='th-center2'>Email</th>";
                                        echo "<th class='th-center2'>Telefone</th>";
                                    echo "</tr>";
                                        $retorno = $conexao->Buscar("funcionarios");
                                        $paginaAtual = isset($_GET["pagina"])?$_GET["pagina"]:1;
                                        $porPagina = 10;
                                        $totalPagina = ceil(count($retorno) / 10);
                                        if (!empty($retorno)) {
                                            for ($contador = $paginaAtual * 10 - 10; $contador < $paginaAtual * 10; $contador++) {
                                                if (isset($retorno[$contador])) {
                                                    echo "<tr class='tr-center2'>";
                                                    foreach ($retorno[$contador] as $key => $value) {
                                                        if ($key != "id")
                                                            echo "<td class='td-center2'>$value</td>";
                                                    }
                                                echo "</tr>";
                                                }
                                            }
                                        }
                                echo "</table>";
                                for ($contador = 1; $contador <= $totalPagina; $contador++)
                                    echo "<a href='usuario.php?usuario=f&pagina=$contador'><input class='input-center2' type='submit' value='$contador'/></a>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                }
            } elseif ($_SESSION["email"] != "user@user.com" && $_SESSION["senha"] != "password") {
                header("Location: ../Login/login.php");
            }
        ?>
    </body>
</html>