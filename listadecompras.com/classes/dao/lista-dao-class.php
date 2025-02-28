<?php
require_once __DIR__ . '/../utils/conexao.php';

class ListaDao
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function criarLista($usuario_id, $nome, $desc, $data_criacao)
    {
        $comando = $this->pdo->prepare("INSERT INTO listas (usuario_id, nome, descricao, data_criacao) VALUES(:usuario_id, :nome, :descricao, :data_criacao);");
        $comando->bindValue(':usuario_id', $usuario_id);
        $comando->bindValue(':nome', $nome);
        $comando->bindValue(':descricao', $desc);
        $comando->bindValue(':data_criacao', $data_criacao);
        $comando->execute();
    }

    public function getlista($usuario_id)
    {
        $comando = $this->pdo->prepare("SELECT * FROM listas WHERE usuario_id = :usuario_id");
        $comando->bindValue(':usuario_id', $usuario_id);
        $comando->execute();
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
}
