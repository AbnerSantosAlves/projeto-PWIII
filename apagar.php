
<?php
include 'conecta.php';
 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die();
}
 
$id = $_POST['id_contato'] ?? null;
 
// Checagem do ID
$id_val = trim($id, "'");
 
if (empty($id_val)) {
    http_response_code(400);
    die('ID do contato não fornecido.');
}
 
try {
    // Query de Exclusão (INSEGURA)
    $sql_delete = "DELETE FROM tb_contato WHERE cd_contato = '$id_val'";
                   
    $success = $conn->exec($sql_delete);
 
    if ($success !== false && $success > 0) {
        echo 'Ok';
    } elseif ($success === 0) {
        http_response_code(404);
        die('Contato não encontrado.');
    } else {
        http_response_code(500);
        $errorInfo = $conn->errorInfo();
        die('Erro ao apagar contato: ' . ($errorInfo[2] ?? 'Erro desconhecido.')); 
    }
 
} catch (PDOException $e) {
    http_response_code(500);
    die('Erro de sistema (PDO): ' . $e->getMessage());
}
 