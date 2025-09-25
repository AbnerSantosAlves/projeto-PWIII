<?php
function consulta() {
    if (!isset($conn)) {
        include "conecta.php";
    }

    $sql = "SELECT cd_contato, nm_contato, ds_login, ds_email, cd_telefone, ds_avatar FROM tb_contato ORDER BY nm_contato ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch()) {
?>
        <div class="col-sm-4 mb-4">
            <div class="card">
                <div class="card-header text-center">
                    CÓDIGO: <?php echo $row['cd_contato']; ?>
                </div>
                <div class="card-body text-center">
                    <?php 
                        $avatar_blob = $row['ds_avatar'];
                        $avatar_src = 'uploads/default.png'; 
                        
                        if ($avatar_blob) {
                            $avatar_src = 'data:image/jpeg;base64,' . base64_encode($avatar_blob); 
                        }
                    ?>
                    <img src="<?php echo $avatar_src; ?>" 
                        class="img-fluid rounded-circle" 
                        alt="<?php echo $row['nm_contato']; ?>" 
                        style="width:100px; height:100px; object-fit: cover;">
                    
                    <hr>
                    
                    <strong>Nome:</strong> <?php echo $row['nm_contato']; ?> <br>
                    <strong>Login:</strong> <?php echo $row['ds_login']; ?> <br>
                    <strong>E-mail:</strong> <?php echo $row['ds_email']; ?> <br>
                    <strong>Telefone:</strong> <?php echo $row['cd_telefone']; ?> <br>
                </div>
                
                <div class="card-footer d-flex justify-content-between">
                    <button type="button" 
                        class="btn btn-sm btn-danger delete-button" 
                        data-id="<?php echo $row['cd_contato']; ?>">
                        Apagar
                    </button>
                    
                    <button type="button" 
                        class="btn btn-sm btn-warning edit-button" 
                        data-bs-toggle="modal" 
                        data-bs-target="#Modal-Edit"
                        data-id="<?php echo $row['cd_contato']; ?>"
                        data-nome="<?php echo $row['nm_contato']; ?>"
                        data-login="<?php echo $row['ds_login']; ?>"
                        data-email="<?php echo $row['ds_email']; ?>"
                        data-telefone="<?php echo $row['cd_telefone']; ?>">
                        Editar
                    </button>
                </div>
            </div>
        </div>
<?php
    }
}
