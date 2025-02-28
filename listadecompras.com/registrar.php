<?php
$pagina = "Cadastrar Usuário";
include __DIR__ . '/include/header-inc.php';
require_once __DIR__ . "/classes/controllers/usuario-cont-class.php";
?>

<div class="container mt-5">
    <h2 class="text-center">Cadastro</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="registerNome" class="form-label">Nome</label>
            <input type="text" class="form-control" name="registerNome" required>
        </div>
        <div class="mb-3">
            <label for="registerEmail" class="form-label">E-mail</label>
            <input type="email" class="form-control" name="registerEmail" required>
        </div>
        <div class="mb-3">
            <label for="registerPassword" class="form-label">Senha</label>
            <input type="password" class="form-control" name="registerPassword" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Cadastrar</button>
    </form>
    <p class="text-center mt-3"><a href="index.php">Já tem uma conta? Faça login</a></p>
</div>

<?php
include __DIR__ . '/include/footer-inc.php';
?>