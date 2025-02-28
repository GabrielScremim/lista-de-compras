<?php
$pagina = "Login";
include __DIR__ . '/include\header-inc.php';
require_once __DIR__ . "/classes/controllers/usuario-cont-class.php";
?>

<div class="container mt-5">
    <h2 class="text-center">Login</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Entrar</button>
    </form>
    <p class="text-center mt-3">Não tem conta? <a href="registrar.php">Cadastre-se</a></p>
</div>

<?php
include __DIR__ . '/include/footer-inc.php';
?>