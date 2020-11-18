<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8"/>
        <title>MINI - CRM</title>
        <link href="login.css" type="text/css" rel="stylesheet"/>
        <meta name="viewport" contet="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
        <div class="login">
            <h1 class="h1-login">FAÇA SEU LOGIN</h1>
            <form method="POST">
                <?php
                    include_once "../Config/config.php";    
                    $conexao = new BDConexao();
                    if (isset($_POST["logar"])) {
                        session_start();
                        $_SESSION["email"] = $_POST["email"];
                        $_SESSION["senha"] = $_POST["senha"];
                        $retorno = $conexao->Login();
                        if (!empty($retorno))
                            echo "<p class='p-login'>$retorno</p>";
                    }
                ?>
                <input class="input-login" type="email" name="email" placeholder="E-mail" autocomplete='off' required/>
                <input class="input-login" type="password" name="senha" placeholder="Senha" autocomplete='off' required/>
                <div class="login1">
                    <input class="input-login1" type="checkbox" name="lembrar"/>Lembrar-me    
                    <a class="a-login1" href="">Recuperar senha</a>
                </div>
                <input class="input-login" type="submit" name="logar" value="Login"/>
            </form>
        </div>
    </body>
</html>
