<?php
require_once 'conecta.php';
 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die();
}
 
// Campos de identificação e novos dados
$id = $_POST['id_contato'] ?? $_POST['ed_id'] ?? null;
$nome = $conn->quote($_POST['ed_nome'] ?? null);
$login = $conn->quote($_POST['ed_login'] ?? null);
$senha = $conn->quote($_POST['ed_senha'] ?? null);
$email = $conn->quote($_POST['ed_email'] ?? null);
$telefone = $conn->quote($_POST['ed_telefone'] ?? null);
$avatar_conteudo = null;
 
// Checagem de ID e campos obrigatórios (removendo aspas para checar se o valor é nulo)
$id_val = trim($id, "'");
$nome_val = trim($nome, "'");
$login_val = trim($login, "'");
 
if (empty($id_val) || empty($nome_val) || empty($login_val)) {
    http_response_code(400);
    die('ID ou campos obrigatórios (Nome, Login) incompletos.');
}
 
try {
    // 1. Lidar com o BLOB (Sem bindParam)
    if (isset($_FILES['ed_file']) && $_FILES['ed_file']['error'] === UPLOAD_ERR_OK) {
        $dados_binarios = file_get_contents($_FILES['ed_file']['tmp_name']);
        // Escapa e envolve o BLOB
        $avatar_conteudo = $conn->quote($dados_binarios);
        $avatar_sql = ", ds_avatar = $avatar_conteudo";
    } else {
        $avatar_sql = "";
    }
 
    // 2. Montar a Query de Atualização (INSEGURA)
    // Atualiza a senha APENAS se um novo valor foi fornecido
    $senha_sql = "";
    $senha_val = trim($senha, "'");
    if (!empty($senha_val)) {
        $senha_sql = ", ds_senha = $senha";
    }
 
    $sql_update = "UPDATE tb_contato SET
        nm_contato = $nome,
        ds_login = $login,
        ds_email = $email,
        cd_telefone = $telefone
        $senha_sql
        $avatar_sql
        WHERE cd_contato = '$id_val'";
                   
    $success = $conn->exec($sql_update);
 
    if ($success !== false) {
        echo 'Ok';
    } else {
        http_response_code(500);
        $errorInfo = $conn->errorInfo();
        die('Erro ao atualizar contato: ' . ($errorInfo[2] ?? 'Erro desconhecido.'));
    }
 
} catch (PDOException $e) {
    http_response_code(500);
    die('Erro de sistema (PDO): ' . $e->getMessage());
}