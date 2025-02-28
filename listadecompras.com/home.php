<?php
$pagina = "Login";
include __DIR__ . '/include/header-inc.php';
require_once __DIR__ . '/classes/utils/verificar_login.php';
require_once __DIR__ . '/classes/controllers/lista-cont-class.php';
require_once __DIR__ . '/classes/controllers/itens-cont-class.php';
$dados_lista = $lista->getLista($_SESSION['usuario_id']);
?>

<div class="container py-4">
    <h1 class="mb-4">Minhas Listas de Compras</h1>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalLista">Criar Nova Lista</button>
    <div class="list-group">
        <?php
        if (!empty($dados_lista)) {
            foreach ($dados_lista as $listas):
        ?>
                <a href="#" class="list-group-item list-group-item-action" onclick="mostrarItens(<?= $listas['id'] ?>, '<?= $listas['nome'] ?>')">
                    <?= $listas['nome'] ?>
                </a>
            <?php
            endforeach;
        } else {
            ?>
            <p>Você não possui nenhuma lista ativa!</p>
        <?php
        }
        ?>
    </div>
    <div class="modal fade" id="modalLista" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Criar/Editar Lista</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <label>Nome da Lista:</label>
                        <input type="text" name="lista" class="form-control">
                    </div>
                    <div class="modal-body">
                        <label>Descrição da Lista:</label>
                        <input type="text" name="descricao" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Tela de Itens da Lista -->
    <div id="itensLista" class="mt-4 d-none">
        <h2 id="nomeLista"></h2>
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalItem">Adicionar Item</button>
        <table class="table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantidade</th>
                    <th>Preço Estimado</th>
                </tr>
            </thead>
            <tbody id="tabelaItens">
                <tr>
                    <td colspan="3" class="text-center">Selecione uma lista para ver os itens.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="modalItem" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar/Editar Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="lista_id" name="lista_id"> <!-- Campo Hidden Atualizado -->
                        <label>Nome do Item:</label>
                        <label>Nome do Item:</label>
                        <input type="text" name="nome_item" class="form-control mb-2" required>
                        <label>Quantidade:</label>
                        <input type="number" name="qtd" class="form-control mb-2" required>
                        <label>Preço Estimado:</label>
                        <input type="text" name="preco" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function mostrarItens(listaId, nomeLista) {
        document.getElementById('nomeLista').innerText = nomeLista;
        document.getElementById('itensLista').classList.remove('d-none');

        // Define o ID da lista no campo hidden do modal
        document.getElementById('lista_id').value = listaId;

        fetch(`classes/controllers/itens-cont-class.php?acao=getItens&lista_id=${listaId}`)
            .then(response => response.json())
            .then(data => {
                let tabelaItens = document.getElementById('tabelaItens');
                tabelaItens.innerHTML = ""; // Limpa os itens anteriores

                if (data.length > 0) {
                    data.forEach(item => {
                        tabelaItens.innerHTML += `
                    <tr>
                        <td>${item.nome}</td>
                        <td>${item.quantidade}</td>
                        <td>R$ ${item.preco}</td>
                    </tr>
                `;
                    });
                } else {
                    tabelaItens.innerHTML = "<tr><td colspan='3' class='text-center'>Nenhum item nesta lista.</td></tr>";
                }
            })
            .catch(error => console.error('Erro ao buscar itens:', error));
    }
</script>

<?php
include __DIR__ . '/include/footer-inc.php';
?>