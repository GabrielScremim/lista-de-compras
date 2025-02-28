<?php
require_once __DIR__ . '/../utils/conexao.php';

class UsuarioDao
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function addUsuario($nome, $email, $senha)
    {
        $comando = $this->pdo->prepare("INSERT INTO usuarios (nome_usuario, email, senha) VALUES(:nome, :email, :senha);");
        $comando->bindValue(':nome', $nome);
        $comando->bindValue(':email', $email);
        $comando->bindValue(':senha', $senha);
        $comando->execute();
    }

    // Método para verificar se o email já está registrado
    public function verificarEmailExistente($email)
    {
        $comando = $this->pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = :email");
        $comando->bindValue(':email', $email);
        $comando->execute();
        return $comando->fetchColumn() > 0;  // Retorna true se o email existe
    }

    // Método para verificar login do usuário
    public function loginUsuario($email, $senha)
    {
        $comando = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $comando->bindValue(':email', $email);
        $comando->execute();
        $usuario = $comando->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;  // Retorna os dados do usuário se login for bem-sucedido
        }
        return false;  // Se o login falhar
    }
}
