<?php
require_once __DIR__ . '/../dao/itens-dao-class.php';

class ItensCont
{
    private $pdo;
    private $itensModel;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->itensModel = new Itens_dao_class($pdo);
    }

    public function addItemLista($lista_id, $nome, $quantidade, $preco_estimado)
    {
        $this->itensModel->addItemLista($lista_id, $nome, $quantidade, $preco_estimado);
    }
    public function getItensPorLista($lista_id)
    {
        return $this->itensModel->getItensPorLista($lista_id);
    }
}

$itens = new ItensCont($pdo);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['nome_item'])) {
        $lista_id = $_POST['lista_id'];
        $nome = $_POST['nome_item'];
        $quantidade = $_POST['qtd'];
        $preco_estimado = $_POST['preco'];
        $itens->addItemLista($lista_id, $nome, $quantidade, $preco_estimado);
    }
}
if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['acao']) && $_GET['acao'] == "getItens") {
    if (isset($_GET['lista_id'])) {
        $lista_id = $_GET['lista_id'];
        $itensLista = $itens->getItensPorLista($lista_id);

        // Retorna os dados em JSON
        header('Content-Type: application/json');
        echo json_encode($itensLista);
        exit();
    }
}
