<!-- Modal -->
<div class="modal fade" id="addExpensesModal" tabindex="-1" role="dialog" aria-labelledby="addExpensesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      
        <div class="modal-header d-block">
          <h5 class="modal-title text-center" id="exampleModalLabel">Inserir Despesas</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <ul class="nav nav-tabs" id="expensesTab" role="tablist">
            <li class="nav-item"><a class="nav-link active" id="materials-tab" data-toggle="tab" href="#materials" role="tab" aria-controls="materials" aria-selected="true"><span class="d-block">Materiais</span></a></li>
            <li class="nav-item"><a class="nav-link" id="employees-tab" data-toggle="tab" href="#employees" role="tab" aria-controls="employees" aria-selected="true"><span class="d-block">Mão de Obra</span></a></li>
            <li class="nav-item"><a class="nav-link" id="equipments-tab" data-toggle="tab" href="#equipments" role="tab" aria-controls="equipments" aria-selected="true"><span class="d-block">Equipamentos</span></a></li>
          </ul>
          
        </div>
        
        <div class="modal-body">
          <div class="tab-content" id="expensesTabContent">
            <div class="tab-pane fade show active" id="materials" role="tabpanel" aria-labelledby="materials-tab">
              <div class="container-fluid">
                <table class="table table-bordered data-table-materials">
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>Nome</th>
                          <th>Referência</th>
                          <th>Preço</th>
                          <th>Unidade</th>
                          <th>Fornecedor</th>
                          <th>Categoria</th>
                          <th>Tipo</th>
                          <th>Desconto</th>
                          <th>Stock</th>
                          <th width="100px">Ações</th>
                      </tr>
                  </thead>
                  <tbody>
                  </tbody>
              </table>
              </div>
            </div>
            <div class="tab-pane fade" id="employees" role="tabpanel" aria-labelledby="employees-tab">
              <div class="container-fluid">
                <table class="table table-bordered data-table-employees">
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>Número</th>
                          <th>Nome</th>
                          <th>Data de admissão</th>
                          <th>Salário</th>
                          <th>Valor Hora</th>
                          <th>Valor Hora Extra</th>
                          <th width="100px">Ações</th>
                      </tr>
                  </thead>
                  <tbody>
                  </tbody>
              </table>
              </div>
            </div>
            <div class="tab-pane fade" id="equipments" role="tabpanel" aria-labelledby="equipments-tab">
              <div class="container-fluid">
                <table class="table table-bordered data-table-equipments">
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>Nome</th>
                          <th>Referência</th>
                          <th>Preço</th>
                          <th>Unidade</th>
                          <th>Fornecedor</th>
                          <th>Categoria</th>
                          <th>Tipo</th>
                          <th>Stock</th>
                          <th>Desconto</th>
                          <th>IVA</th>
                          <th width="100px">Ações</th>
                      </tr>
                  </thead>
                  <tbody>
                  </tbody>
              </table>
              </div>
            </div>
          </div>
        </div>
            
    </div>
  </div>
</div>