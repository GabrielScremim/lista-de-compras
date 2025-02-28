<?php
require_once __DIR__ . '/../utils/conexao.php';

class Itens_dao_class
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getItensPorLista($lista_id)
    {
        $sql = "SELECT * FROM itens WHERE lista_id = :lista_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':lista_id', $lista_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addItemLista($lista_id, $nome, $quantidade, $preco_estimado)
    {
        $comando = $this->pdo->prepare("INSERT INTO itens (lista_id, nome, quantidade, preco_estimado) VALUES(:lista_id, :nome, :quantidade, :preco_estimado);");
        $comando->bindValue(':lista_id', $lista_id);
        $comando->bindValue(':nome', $nome);
        $comando->bindValue(':quantidade', $quantidade);
        $comando->bindValue(':preco_estimado', $preco_estimado);
        $comando->execute();
    }
}
