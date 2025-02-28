<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    // Redireciona para a página de login se o usuário não estiver autenticado
    header("Location: index.php");
    exit();
}

// Código da página protegida
echo "Bem-vindo, " . $_SESSION['usuario_nome'];
