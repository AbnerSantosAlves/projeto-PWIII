<?php
include 'conecta.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die();
}

$nome = $conn->quote($_POST['nm_contato'] ?? null);
$login = $conn->quote($_POST['ds_login'] ?? null);
$senha = $conn->quote($_POST['ds_senha'] ?? null);
$email = $conn->quote($_POST['ds_email'] ?? null);
$telefone = $conn->quote($_POST['cd_telefone'] ?? null);
$avatar_conteudo = "NULL"; 

$login_val = trim($login, "'"); 
$senha_val = trim($senha, "'"); 
$nome_val = trim($nome, "'"); 

if (empty($nome_val) || empty($login_val) || empty($senha_val)) {
    http_response_code(400);
    die('Dados incompletos');
}

if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $dados_binarios = file_get_contents($_FILES['file']['tmp_name']);
    $avatar_conteudo = $conn->quote($dados_binarios); 
}

try {
    $sql_check = "SELECT COUNT(*) AS count FROM tb_contato WHERE ds_login = $login OR ds_email = $email";
    $stmt = $conn->query($sql_check);

    if (!$stmt) {
        http_response_code(500);
        die('Erro ao preparar consulta de verificação');
    }

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result === false) {
        http_response_code(500);
        die('Erro ao verificar dados');
    }

    if ($result['count'] > 0) {
        http_response_code(409);
        die('Login ou e-mail já estão em uso');
    }

    $success = $conn->query(
        "INSERT INTO tb_contato (nm_contato, ds_login, ds_senha, ds_email, cd_telefone, ds_avatar)
        VALUES ($nome, $login, $senha, $email, $telefone, $avatar_conteudo)"
    );

    if (!$success) {
        http_response_code(500);
        $errorInfo = $conn->errorInfo();
        die('Erro ao criar contato: ' . ($errorInfo[2] ?? 'Erro desconhecido.')); 
    }

    echo 'Ok';

} catch (PDOException $e) {
    http_response_code(500);
    die('Erro de sistema (PDO): ' . $e->getMessage());
}
