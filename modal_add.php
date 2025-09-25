<div class="modal fade" id="Modal-Add" tabindex="-1" aria-labelledby="ModalAddLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-adicionar" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalAddLabel">Cadastro de Novo Contato</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="acao" value="adicionar">
                    
                    <div class="mb-3">
                        <label for="add_nome" class="form-label">Nome:</label>
                        <input type="text" class="form-control" id="add_nome" name="nm_contato" required>
                    </div>
                    <div class="mb-3">
                        <label for="add_login" class="form-label">Login:</label>
                        <input type="text" class="form-control" id="add_login" name="ds_login" required>
                    </div>
                    <div class="mb-3">
                        <label for="add_email" class="form-label">E-mail:</label>
                        <input type="email" class="form-control" id="add_email" name="ds_email">
                    </div>
                    <div class="mb-3">
                        <label for="add_telefone" class="form-label">Telefone:</label>
                        <input type="text" class="form-control" id="add_telefone" name="cd_telefone">
                    </div>
                    <div class="mb-3">
                        <label for="add_senha" class="form-label">Senha:</label>
                        <input type="password" class="form-control" id="add_senha" name="ds_senha" required>
                    </div>
                    <div class="mb-3">
                        <label for="add_avatar" class="form-label">Avatar (Imagem):</label>
                        <input type="file" class="form-control" id="add_avatar" name="file">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar Contato</button>
                </div>
            </form>
        </div>
    </div>
</div>