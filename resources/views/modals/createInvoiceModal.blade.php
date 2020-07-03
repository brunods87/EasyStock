<!-- Modal -->
<div class="modal fade" id="createInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="createInvoiceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      
        <div class="modal-header">
          <ul class="nav nav-tabs" id="moldesTab" role="tablist">
            <li class="nav-item"><a class="nav-link active" id="molde-tab" data-toggle="tab" href="#molde" role="tab" aria-controls="molde" aria-selected="true"><span class="d-block">Detalhes</span></a></li>
            <li class="nav-item"><a class="nav-link" id="addpeca-tab" data-toggle="tab" href="#addpeca" role="tab" aria-controls="addpeca" aria-selected="true"><span class="d-block">Materiais</span></a></li>
            <li class="nav-item"><a class="nav-link" id="editpeca-tab" data-toggle="tab" href="#editpeca" role="tab" aria-controls="editpeca" aria-selected="true"><span class="d-block">Editar Peças</span></a></li>
            <li class="nav-item"><a class="nav-link" id="xmlfile-tab" data-toggle="tab" href="#xmlfile" role="tab" aria-controls="xmlfile" aria-selected="true"><span class="d-block">Ficheiro XML</span></a></li>
            @if (1)
            <li class="nav-item"><a class="nav-link" id="destroymold-tab" data-toggle="tab" href="#destroymold" role="tab" aria-controls="destroymold" aria-selected="true"><span class="d-block">Eliminar Molde</span></a></li>
            @endif
          </ul>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="tab-content" id="moldesTabContent">
            <div class="tab-pane fade show active" id="molde" role="tabpanel" aria-labelledby="molde-tab">
              <div class="modal-body">
                <div class="container">
                  <div class="card" v-if="current_molde">
                    <ul>
                      <li><b>Projecto:</b> @{{current_molde.projecto}};</li>
                      <li><b>Designação:</b> @{{current_molde.designacao}};</li>
                      <li v-if="current_molde.cliente"><b>Cliente</b> @{{current_molde.cliente.nome}};</li>
                      <li v-if="current_molde.projetista"><b>Nome do Projetista:</b> @{{current_molde.projetista.nome}};</li>
                      <li v-if="current_molde.projetista"><b>Email do Projetista:</b> @{{current_molde.projetista.email}};</li>
                      <li><b>Data de Elaboração:</b> @{{current_molde.data_elaboracao}};</li>
                      <li><b>Data de Verificação:</b> @{{current_molde.data_verificacao}};</li>
                      <li><b>Nº PLT:</b> @{{current_molde.nplt}};</li>
                      <li><b>Revisão:</b> @{{current_molde.revisao}};</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="addpeca" role="tabpanel" aria-labelledby="addpeca-tab">
              <div class="modal-body">
                <div class="container">
                    <table id="newpeca-table" class="table table-bordered table-striped text-center">
                      <thead>
                        <tr>
                          <th>Object ID*</th>
                          <th>Tipo</th>
                          <th>Número*</th>
                          <th>Descrição*</th>
                          <th>Quantidade</th>
                          <th>Dims/Refs</th>
                          <th>Material</th>
                          <th>Tratamento</th>
                          <th>Dureza</th>
                          <th>Versão</th>
                          <th>Compras</th>
                      </thead>
                      <tbody>
                        <tr>
                          <td><input type="text" v-model="novaPeca.objectid"></td>
                          <td><select v-model="novaPeca.tipo"><option v-for="tipo in tipos" v-bind:value="tipo.nome">@{{tipo.nome}}</option></select></td>
                          <td><input type="text" v-model="novaPeca.numero"></td>
                          <td><input type="text" v-model="novaPeca.descricao"></td>
                          <td><input type="number" v-model="novaPeca.quantidade"></td>
                          <td><input type="text" v-model="novaPeca.dimref"></td>
                          <td><input type="text" v-model="novaPeca.material"></td>
                          <td><input type="text" v-model="novaPeca.tratamento"></td>
                          <td><input type="text" v-model="novaPeca.dureza"></td>
                          <td><input type="text" v-model="novaPeca.versao"></td>
                          <td><select v-model="novaPeca.compra"><option v-for="compra in compras" v-bind:value="compra.estado">@{{compra.estado}}</option></select></td>
                      </tbody>
                    </table>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="insertPeca">Inserir</button>
              </div>
            </div>
            <div class="tab-pane fade" id="editpeca" role="tabpanel" aria-labelledby="editpeca-tab">
              <div class="modal-body">
                <div class="container">
                  <table class="table table-bordered table-striped text-center">

                    <thead>

                      <tr>

                        <th>Peça Nº</th>
                        <th>Descrição</th>
                        <th>Tipo</th>
                        <th>Eliminar</th>

                      </tr>

                    </thead>
                    <tbody>

                      <tr v-for="peca in pecas">

                        <td v-text="peca.numero"></td>
                        <td v-text="peca.descricao"></td>
                        <td><select v-model="peca.tipo.nome"><option v-for="tipo in tipos" v-bind:value="tipo.nome">@{{tipo.nome}}</option></select></td>
                        <td><button type="button" class="btn delete-button" @click="deletePeca(peca.id)"><img src="/img/deleteicon.png" class="icon"></button></td>

                      </tr>                

                    </tbody>          

                  </table>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="savePecas">Guardar</button>
              </div>
            </div>
            <div class="tab-pane fade" id="xmlfile" role="tabpanel" aria-labelledby="xmlfile-tab">
              <div class="modal-body">

              </div>
            </div>
          @if (1)
            <div class="tab-pane fade" id="destroymold" role="tabpanel" aria-labelledby="destroymold-tab">
              <div class="modal-body">
                  <div class="row justify-content-center" v-if="current_molde">
                    <form method="POST" action="/api/dmeosltdreoy" @submit.prevent="destroyMold" ref="form_destroy">
                      @csrf
                      <input type="hidden" name="destroy_id" v-model="current_molde.id">
                      <button type="submit" class="btn btn-danger">Eliminar @{{current_molde.nome}}</button>
                    </form>
                  </div>
              </div>
            </div>
          @endif
        </div>
        
      
    </div>
  </div>
</div>