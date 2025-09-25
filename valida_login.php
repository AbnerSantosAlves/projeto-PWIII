<?php
// valida_login.php

// Adicionado para debug (pode ser removido em produção)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'conecta.php'; // Inclui conexão e inicia a sessão

$login_digitado = $_POST['login'] ?? '';
$senha_digitada = $_POST['senha'] ?? '';

if (empty($login_digitado) || empty($senha_digitada)) {
    $_SESSION['login_error'] = "Preencha o login e a senha.";
    header("Location: index.php");
    exit;
}

try {
    // 1. Busca o usuário
    $sql = "SELECT cd_contato, nm_contato, ds_login, ds_senha FROM tb_contato WHERE ds_login = :login";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':login', $login_digitado);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // 2. Verifica se o usuário existe e se a senha está correta
    // CORREÇÃO: Comparação de texto simples (Senha Digitada === Senha do Banco)
    if ($usuario && $senha_digitada === $usuario['ds_senha']) {
        
        // Login bem-sucedido! Cria variáveis de sessão
        $_SESSION['logado'] = true;
        $_SESSION['user_id'] = $usuario['cd_contato'];
        $_SESSION['user_nome'] = $usuario['nm_contato'];
        
        // Redireciona para a página protegida
        header("Location: dashboard.php");
        exit;

    } else {
        // Falha no login
        $_SESSION['login_error'] = "Login ou senha inválidos.";
        header("Location: index.php");
        exit;
    }

} catch (PDOException $e) {
    $_SESSION['login_error'] = "Erro no servidor ao tentar logar: " . $e->getMessage();
    header("Location: index.php");
    exit;
}