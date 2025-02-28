<?php
require_once __DIR__ . '/../dao/usuario-dao-class.php';

class UsuarioCont
{
    private $pdo;
    private $usuarioModel;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->usuarioModel = new UsuarioDao($pdo);
    }

    // Método para adicionar o usuário
    public function addUsuario($nome, $email, $senha)
    {
        // Criptografa a senha antes de salvar
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $this->usuarioModel->addUsuario($nome, $email, $senhaHash);
    }

    // Método para verificar se o email já está registrado
    public function verificarUsuarioPorEmail($email)
    {
        return $this->usuarioModel->verificarEmailExistente($email);
    }

    // Método para realizar login
    public function loginUsuario($email, $senha)
    {
        return $this->usuarioModel->loginUsuario($email, $senha);
    }
}

$usuario = new UsuarioCont($pdo);

// Lógica de cadastro de usuário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Cadastro de usuário
    if (isset($_POST['registerEmail']) && isset($_POST['registerNome']) && isset($_POST['registerPassword'])) {
        $nome = trim($_POST['registerNome']);
        $email = trim($_POST['registerEmail']);
        $senha = trim($_POST['registerPassword']);

        // Verificar se o email já está registrado
        $usuarioExistente = $usuario->verificarUsuarioPorEmail($email);

        if ($usuarioExistente) {
            echo "Este email já está registrado.";
        } else {
            // Adicionar o novo usuário ao banco de dados
            $usuario->addUsuario($nome, $email, $senha);
            echo "Usuário cadastrado com sucesso!";
        }
    }

    // Lógica de login
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = trim($_POST['email']);
        $senha = trim($_POST['password']);

        // Tenta realizar o login do usuário
        $usuarioLogin = $usuario->loginUsuario($email, $senha);

        if ($usuarioLogin) {
            // Se o login for bem-sucedido, inicia uma sessão para o usuário
            session_start();
            $_SESSION['usuario_id'] = $usuarioLogin['usuarios_id'];  // Armazena o ID do usuário na sessão
            $_SESSION['usuario_nome'] = $usuarioLogin['nome_usuario'];  // Armazena o nome na sessão
            $_SESSION['usuario_email'] = $usuarioLogin['email'];  // Armazena o email na sessão
            session_start();

            header("Location: home.php");  // Redireciona para a página do painel (exemplo)
            exit();
        } else {
            echo "Email ou senha inválidos!";
        }
    }
}
