<?php

    class BDConexao {

        private $pdo;
        private $login;
        private $retorno;
        private $buscar;
        private $excluir;
        private $cadastrar;
        private $editar;
        private $buscareditar;
        private $empresas;

        function __construct() {
            try {
                $this->pdo = new PDO("mysql:dbname=minicrm;host=localhost;charset=utf8", "root", "");
            } catch (Exception $e) {
                echo "Erro ao conectar com o banco de dados";
            }
        }

        function Login() {
            $this->login = $this->pdo->prepare("SELECT id FROM contas WHERE email = ? AND senha = ?");
            $this->login->execute(array($_POST["email"], $_POST["senha"]));
            $this->retorno = $this->login->fetchALL(PDO::FETCH_ASSOC);
            if (empty($this->retorno)) {
                return "E-mail ou senha incorretos";
            } elseif ($this->retorno[0]["id"] == 1) {
                header("Location: ../Admin-Usuario/admin.php?admin=e");
            } elseif ($this->retorno[0]["id"] != 1) {
                header("Location: ../Admin-Usuario/usuario.php?usuario=e");
            }
        }

        function Editar($tabela) {
            if ($tabela == "empresas") {
                $this->editar = $this->pdo->prepare("UPDATE empresas SET nome = ?, email = ?, logotipo = ?, site = ? WHERE id = ?");
                if (isset($_POST["nome-empresa"], $_POST["email-empresa"], $_POST["logotipo-empresa"], $_POST["site-empresa"])) {
                    $this->editar->execute(array($_POST["nome-empresa"], $_POST["email-empresa"], $_POST["logotipo-empresa"], $_POST["site-empresa"], $_GET["ide"]));
                }
            } elseif ($tabela == "funcionarios") {
                $this->editar = $this->pdo->prepare("UPDATE funcionarios SET nome = ?, sobrenome = ?, empresa = ?, email = ?, telefone = ? WHERE id = ?");
                if (isset($_POST["nome-funcionario"], $_POST["sobrenome-funcionario"], $_POST["empresa-funcionario"], $_POST["email-funcionario"], $_POST["telefone-funcionario"])) {
                    $this->editar->execute(array($_POST["nome-funcionario"], $_POST["sobrenome-funcionario"], $_POST["empresa-funcionario"], $_POST["email-funcionario"], $_POST["telefone-funcionario"], $_GET["idf"]));
                }    
            }
        }

        function Cadastrar($tabela) {
            if ($tabela == "empresas") {
                $this->cadastrar = $this->pdo->prepare("INSERT INTO empresas VALUES (null, ?, ?, ?, ?)");
                $this->cadastrar->execute(array($_POST["nome-empresa"], $_POST["email-empresa"], $_POST["logotipo-empresa"], $_POST["site-empresa"]));
            } elseif ($tabela == "funcionarios") {
                $this->cadastrar = $this->pdo->prepare("INSERT INTO funcionarios VALUES (null, ?, ?, ?, ?, ?)");
                $this->cadastrar->execute(array($_POST["nome-funcionario"], $_POST["sobrenome-funcionario"], $_POST["empresa-funcionario"], $_POST["email-funcionario"], $_POST["telefone-funcionario"]));
            }
        }

        function Buscar($tabela) {
            $this->buscar = $this->pdo->prepare("SELECT * FROM $tabela");
            $this->buscar->execute();
            $this->retorno = $this->buscar->fetchAll(PDO::FETCH_ASSOC);
            return $this->retorno;
        }

        function BuscarEditar() {
            if (isset($_GET["ide"])) {
                $this->buscareditar = $this->pdo->prepare("SELECT * FROM empresas WHERE id = ?");
                $this->buscareditar->execute(array($_GET["ide"]));
                $this->retorno = $this->buscareditar->fetchAll(PDO::FETCH_ASSOC);
                return $this->retorno[0];
            } elseif (isset($_GET["idf"])) {
                $this->buscareditar = $this->pdo->prepare("SELECT * FROM funcionarios WHERE id = ?");
                $this->buscareditar->execute(array($_GET["idf"]));
                $this->retorno = $this->buscareditar->fetchAll(PDO::FETCH_ASSOC);
                return $this->retorno[0];
            }
        }

        function Excluir($tabela) {
            if ($tabela == "empresas") {
                $this->excluir = $this->pdo->prepare("DELETE FROM empresas WHERE id = ?");
                $this->excluir->execute(array($_GET["ide"]));
            } elseif ($tabela == "funcionarios") {
                $this->excluir = $this->pdo->prepare("DELETE FROM funcionarios WHERE id = ?");
                $this->excluir->execute(array($_GET["idf"]));
            }
        }

        function Empresas() {
            $this->empresas = $this->pdo->prepare("SELECT nome FROM empresas");
            $this->empresas->execute();
            $this->retorno = $this->empresas->fetchAll(PDO::FETCH_ASSOC);
            return $this->retorno;
        }

    }

?>
