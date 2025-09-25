<div class="modal fade" id="Modal-Edit" tabindex="-1" aria-labelledby="ModalEditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-editar" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalEditLabel">Editar Cadastro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="acao" value="editar">
                    <input type="hidden" name="cd_contato" id="ed_id"> 
                    
                    <div class="mb-3">
                        <label for="ed_nome" class="form-label">Nome:</label>
                        <input type="text" class="form-control" id="ed_nome" name="nm_contato" required>
                    </div>
                    <div class="mb-3">
                        <label for="ed_login" class="form-label">Login:</label>
                        <input type="text" class="form-control" id="ed_login" name="ds_login" required>
                    </div>
                    <div class="mb-3">
                        <label for="ed_email" class="form-label">E-mail:</label>
                        <input type="email" class="form-control" id="ed_email" name="ds_email">
                    </div>
                    <div class="mb-3">
                        <label for="ed_telefone" class="form-label">Telefone:</label>
                        <input type="text" class="form-control" id="ed_telefone" name="cd_telefone">
                    </div>
                    <div class="mb-3">
                        <label for="ed_senha" class="form-label">Nova Senha (deixe em branco para manter a atual):</label>
                        <input type="password" class="form-control" id="ed_senha" name="ds_senha">
                    </div>
                    <div class="mb-3">
                        <label for="ed_avatar" class="form-label">Atualizar Avatar:</label>
                        <input type="file" class="form-control" id="ed_avatar" name="file">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-warning">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>