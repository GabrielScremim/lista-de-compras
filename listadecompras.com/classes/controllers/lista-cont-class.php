<?php
require_once __DIR__ . '/../dao/lista-dao-class.php';

class Lista_cont_class
{
    private $pdo;
    private $listaModel;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->listaModel = new ListaDao($pdo);
    }

    public function criarLista($usuario_id, $nome, $desc, $data_criacao)
    {
        $this->listaModel->criarLista($usuario_id, $nome, $desc, $data_criacao);
    }

    public function getLista($usuario_id)
    {
        return $this->listaModel->getLista($usuario_id);
    }
}

$lista = new Lista_cont_class($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['lista'])) {
        $usuario_id = $_SESSION['usuario_id'];
        $nome = $_POST['lista'];
        $desc = $_POST['descricao'];
        date_default_timezone_set('America/Sao_Paulo');
        $data_criacao = date('Y-m-d H:i:s');

        // Criar lista
        if ($lista->criarLista($usuario_id, $nome, $desc, $data_criacao)) {
            $_SESSION['mensagem'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        Lista criada com sucesso!
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>';
        } else {
            $_SESSION['mensagem'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        Erro ao criar a lista!
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>';
        };

        // Redirecionar para evitar reenvio do formulário
        header("Location: home.php");
        exit();
    }
}
?>

<!-- Exibir a mensagem na página (antes do formulário) -->
<?php if (isset($_SESSION['mensagem'])): ?>
    <?php echo $_SESSION['mensagem']; ?>
    <?php unset($_SESSION['mensagem']); // Remover mensagem após exibição 
    ?>
<?php endif; ?>