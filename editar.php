<?php
require_once '../utils/connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die();
}

$id = $_POST['id_contato'] ?? $_POST['ed_id'] ?? null;
$nome = $conn->quote($_POST['ed_nome'] ?? null);
$login = $conn->quote($_POST['ed_login'] ?? null);
$senha = $conn->quote($_POST['ed_senha'] ?? null);
$email = $conn->quote($_POST['ed_email'] ?? null);
$telefone = $conn->quote($_POST['ed_telefone'] ?? null);
$avatar_conteudo = null; 

$id_val = trim($id, "'");
$nome_val = trim($nome, "'");
$login_val = trim($login, "'");

if (empty($id_val) || empty($nome_val) || empty($login_val)) {
    http_response_code(400);
    die('ID ou campos obrigatórios (Nome, Login) incompletos.');
}

try {
    $sql_check = "SELECT COUNT(*) AS count FROM tb_contato 
                  WHERE (ds_login = $login OR ds_email = $email) 
                  AND cd_contato != '$id_val'";

    $stmt_check = $conn->query($sql_check);
    
    if (!$stmt_check) {
        http_response_code(500);
        die('Erro ao preparar consulta de verificação.');
    }

    $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        http_response_code(409);
        die('Login ou e-mail já estão em uso por outro contato.');
    }

    if (isset($_FILES['ed_file']) && $_FILES['ed_file']['error'] === UPLOAD_ERR_OK) {
        $dados_binarios = file_get_contents($_FILES['ed_file']['tmp_name']);
        $avatar_conteudo = $conn->quote($dados_binarios); 
        $avatar_sql = ", ds_avatar = $avatar_conteudo";
    } else {
        $avatar_sql = "";
    }

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
