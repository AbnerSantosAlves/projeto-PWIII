<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    $_SESSION['login_error'] = "Você precisa estar logado para acessar a Agenda.";
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Agenda de Contatos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="jumbotron text-center p-5 mb-4 bg-light rounded-3">
        <h1>AGENDA</h1>
        <p>Bem-vindo(a), <?php echo $_SESSION['user_nome'] ?? 'Usuário'; ?> | 
        <a href="logout.php" class="btn btn-sm btn-outline-danger">Sair</a></p>
        
        <button type="button" class="btn btn-primary mb-3" 
            data-bs-toggle="modal" data-bs-target="#Modal-Add">
            Cadastrar Contato
        </button>
    </div>

    <div class="row" id="lista-contatos">
        <?php
            include "consulta.php";
            consulta();
        ?>
    </div>
    
    <?php 
        include "Modals/modal_add.php"; 
        include "Modals/modal_edit.php";
    ?>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    
    function refreshList() {
        $("#lista-contatos").load(location.href + " #lista-contatos > *");
    }

    $('#lista-contatos').on('click', '.delete-button', function() {
        var id = $(this).data('id');
        
        if (confirm("Tem certeza que deseja apagar o contato ID " + id + "?")) {
            $.ajax({
                type: 'POST',
                url: 'cadastrar.php', 
                dataType: 'json', 
                data: {
                    acao: 'deletar',
                    id_contato: id
                },
                success: function(response) {
                    alert(response.message); 
                    if(response.status === 'success') {
                        refreshList(); 
                    }
                },
                error: function(xhr) {
                    var err = xhr.responseJSON ? xhr.responseJSON.message : xhr.responseText;
                    alert('Erro ao excluir: ' + err);
                }
            });
        }
    });

    $('.container').on('click', '.edit-button', function() {
        var data = $(this).data();
        $('#ed_id').val(data.id);
        $('#ed_nome').val(data.nome);
        $('#ed_login').val(data.login);
        $('#ed_email').val(data.email);
        $('#ed_telefone').val(data.telefone);
        $('#ed_senha').val('');
    });

    $('#form-adicionar').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: 'cadastrar.php',
            data: formData,
            dataType: 'json', 
            processData: false, 
            contentType: false, 
            success: function(response) {
                alert(response.message);
                if(response.status === 'success') {
                    $('#Modal-Add').modal('hide'); 
                    $('#form-adicionar')[0].reset(); 
                    refreshList(); 
                }
            },
            error: function(xhr) {
                var err = xhr.responseJSON ? xhr.responseJSON.message : xhr.responseText;
                alert('Erro ao adicionar: ' + err);
            }
        });
    });

    $('#form-editar').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: 'cadastrar.php',
            data: formData,
            dataType: 'json', 
            processData: false,
            contentType: false,
            success: function(response) {
                alert(response.message);
                if(response.status === 'success') {
                    $('#Modal-Edit').modal('hide'); 
                    refreshList(); 
                }
            },
            error: function(xhr) {
                var err = xhr.responseJSON ? xhr.responseJSON.message : xhr.responseText;
                alert('Erro ao editar: ' + err);
            }
        });
    });

});
</script>

</body>
</html>