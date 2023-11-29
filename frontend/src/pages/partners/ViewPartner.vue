<template>
  <q-page style="padding: 5px 15px;">
    <div class="row" style="margin: 10px 0;">
      <div class="col-12">
        <q-btn class="bg-purple text-white" to="/listaparceiros" style="float: right;">Voltar</q-btn>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6">
        <q-card>
          <q-card-section class="text-black">
            <div class="text-subtitle2">Dados da Instituição:</div>
            <div class="text-h6">
              <font-awesome-icon :icon="['far', 'user']" />
              {{ this.parceiro.nome_instituicao }}
            </div>
            <div class="col-12" style="margin-left: 25px;">
              CNPJ: {{ this.parceiro.cnpj }}
            </div>
            <div class="row">
              <div class="col-12">
                <div v-if="this.parceiro.status === '1'" style="float: left;">
                  <q-badge color="green" label="Ativo" style="margin: 0 5px;" />
                </div>
                <div v-else style="float: left;">
                  <q-badge color="red" label="Inativo" style="margin: 0 5px;" />
                </div>
                <q-badge color="purple" label="Outros Parceiros Participantes" style="margin: 0 5px;" />
              </div>
              <div class="col-12" style="margin-top: 15px;">
                <table class="table">
                  <tr>
                    <td class="text-grey text-right">Responsável Legal:</td>
                    <td>{{ this.parceiro.responsavel_legal }}</td>
                  </tr>
                  <tr> <td colspan="2"></td> </tr>
                  <tr> <td colspan="2"></td> </tr>
                  <tr> <td colspan="2"></td> </tr>
                  <tr> <td colspan="2"></td> </tr>
                  <tr>
                    <td class="text-grey text-right">CPF:</td>
                    <td> {{ this.parceiro.cpf }}</td>
                  </tr>
                  <tr>
                    <td class="text-grey text-right">E-mail:</td>
                    {{ this.parceiro.email }}
                  </tr>
                  <tr>
                    <td class="text-grey text-right">Telefone:</td>
                    {{ this.parceiro.telefone }}
                  </tr>
                  <tr> <td colspan="2"></td> </tr>
                  <tr> <td colspan="2"></td> </tr>
                  <tr> <td colspan="2"></td> </tr>
                  <tr> <td colspan="2"></td> </tr>
                  <tr>
                    <td class="text-grey text-right">Observações:</td>
                    {{ this.parceiro.observacao }}
                  </tr>
                </table>
                <hr class="border-grey" style="margin: 25px 0;"/>
                <h6 style="margin: 15px;">Ações</h6>
                <q-toggle 
                  color="green" 
                  v-model="parceiroStatus" 
                  :label="parceiroStatusLabel" 
                  @click="atualizarStatus" />
                <q-btn outline style="margin-left: 75px;" @click="novoColaborador = true">Novo Colaborador</q-btn>
              </div>
            </div>
          </q-card-section>
        </q-card>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-6" style="padding: 5px 15px;">
        <h6 style="margin: 15px;">Lista de Colaboradores</h6>
        <div class="row">
          <div class="col-lg-5 col-md-5 col-sm-12">
            <q-input outlined v-model="consultarColab.cpf" label="CPF" mask="###.###.###-##"/>
          </div>
          <div class="col-lg-5 col-md-5 offset-md-1 offset-lg-1 col-sm-12">
            <q-input outlined v-model="consultarColab.nome" label="Nome do Colaborador"/>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 15px;" align-center>
            <q-btn outline @click="consultarColaborador">
              Consultar
            </q-btn>
          </div>
        </div>
        <div class="row" style="margin-top: 15px;">
          <div class="col-auto">
            <q-table flat bordered
              virtual-scroll
              :columns="columns" 
              :rows="colabRows"
              v-model:pagination="pagination"
              :rows-per-page-options="[0]"
            >
              <template v-slot:body-cell-status="props">
                <q-td :props="props">
                  <div v-if="this.parceiro.status === '1'" style="float: left;">
                    <q-badge color="green" label="Ativo" style="margin: 0 5px;" />
                  </div>
                  <div v-else style="float: left;">
                    <q-badge color="red" label="Inativo" style="margin: 0 5px;" />
                  </div>
                </q-td>
              </template>
              <template v-slot:body-cell-id="props">
                <q-td :props="props">
                  <q-btn outline>
                    <font-awesome-icon :icon="['fas', 'unlock-keyhole']" />
                    <q-tooltip
                      class="bg-cyan text-caption outline"
                      :offset="[10, 10]"
                      style="max-width: 600px">
                      Resetar Senha
                    </q-tooltip>
                  </q-btn>
                  <q-btn outline class="bg-blue text-white"
                    @click="$router.replace('/user/' + props.row.id )"
                    style="margin: 0 5px;">
                    <font-awesome-icon :icon="['far', 'user']" />
                    <q-tooltip
                      class="bg-blue text-caption outline"
                      :offset="[10, 10]"
                      style="max-width: 600px">
                      Informações do Colaborador
                    </q-tooltip>
                  </q-btn>
                </q-td>
              </template>
            </q-table>
          </div>
        </div>
      </div>
    </div>

    <q-dialog v-model="novoColaborador">
      <q-card style="width: 700px; max-width: 80vw;">
        <q-card-section>
          <div class="text-h6">Cadastrar Novo Colaborador</div>
        </q-card-section>

        <q-card-section class="q-pt-none">
          <div class="row" style="margin: 5px 0;">
            <div class="col-md-12">
              <q-input outlined v-model="dadoColaborador.nome" label="Nome do Colaborador" :rules="[isRequired]"/>
            </div>
          </div>
          <div class="row" style="margin: 5px 0;">
            <div class="col-md-12">
              <q-input outlined v-model="dadoColaborador.cpf" label="CPF" mask="###.###.###-##" :rules="[isRequired]"/>
            </div>
          </div>
          <div class="row" style="margin: 5px 0;">
            <div class="col-md-12">
              <q-input outlined v-model="dadoColaborador.email" label="Email" :rules="[isRequired, isEmail, emailMatch]"/>
            </div>
          </div>
          <div class="row" style="margin: 5px 0;">
            <div class="col-md-12">
              <q-input outlined v-model="dadoColaborador.repetirEmail" label="Confirmação de Email" :rules="[emailMatch]"/>
            </div>
          </div>
        </q-card-section>

        <q-card-actions align="right">
          <q-btn outlined label="Cancelar" color="red" v-close-popup style="float: left !important;" />
          <q-btn outlined label="Salvar" color="green" @click="salvarColaborador" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>

  </q-page>
</template>
<script>
import { ref } from 'vue';
import {TheMask} from 'vue-the-mask';
import accountMixin from "../../mixins/accountMixin";

const columns = [
  { name: 'status', label: 'Status', field: 'status', sortable: true },
  { 
    name: 'name', required: true, label: 'Nome do Colaborador', align: 'left',
    field: row => row.name, format: val => `${val}`, sortable: true 
  },
  { name: 'email', align: 'center', label: 'email', field: 'email', sortable: true },
  { name: 'id', label: 'ações', field: 'id' },
];
let colabRows = [];
let rows = [];
for (let i = 0; i < colabRows.length; i++) {
  rows = rows.concat(colabRows.slice(0).map(r => ({ ...r })))
}
rows.forEach((row, index) => {
  row.index = index
})

export default {
  name: "ViewPartner",
  components: {TheMask},
  mixins: [accountMixin],
  data() {
    return {
      PartnerId: this.$route.params.id,
      parceiro: [],
      colaboradores: [],
      parceiroStatus: null,
      parceiroStatusLabel: null,
      consultarColab: {
        nome: null,
        cpf: null,
        id: this.PartnerId,
      },
      columns,
      rows,
      colabRows,
      dadoColaborador: {
        nome: null,
        cpf: null,
        email: null,
        repetirEmail: null
      },
      novoCadastro: [],
    }
  },
  setup() {
    return {
      novoColaborador: ref(false),
      parceiroStatus: ref(true)
    }
  },
  methods: {
    async getPartnerData() {
      try {
        const { data, status } =  await this.$http.get("parceiros/show/" + this.PartnerId);
        this.parceiro = data;
        if (status === 200) {
          this.getColaboradoresData()
          // verificando status do parceiro
          this.parceiroStatus = this.parceiro.status === '1' ? true : false;
          this.parceiroStatusLabel = this.parceiro.status === '1' ? 'Ativo' : 'Inativo';
        }
      } catch(error) {
        this.$q.notify({
          message: error.message,
          color: "negative",
          position: "top",
        });
      }
    },
    async getColaboradoresData() {
      try {
        const { data, status } = await this.$http.get("colaboradores/?id=" + this.PartnerId);
        if (status === 200 && Array.isArray(data)) {
          data.forEach((colab) => {
            this.colabRows.push({
              status: colab.status,
              name: colab.nome,
              email: colab.email,
              id: colab.user_id
            });
          });
        } else {
          throw new Error('Resposta inválida ou vazia');
        }
      } catch (error) {
        this.$q.notify({
          message: error.message || 'Erro ao obter colaboradores',
          color: "negative",
          position: "top",
        });
      }
    },
    async consultarColaborador() {
      const { data, status } = await this.$http.get("colaboradores?id=" + this.PartnerId , {
        params: this.consultarColab
      });
      // limpando a tabela
      this.colabRows = [];
      //exibindo os resultados
      data.forEach((colab) => {
        this.colabRows.push({
          status: colab.status,
          name: colab.nome,
          email: colab.email,
          id: colab.user_id
        });
      });
    },
    async salvarColaborador() {
      this.novoCadastro = {
        'parceiro': this.parceiro,
        'colaborador': this.dadoColaborador
      };
      const { data, status } = await this.$http.post("colaboradores/store", this.novoCadastro);
      if (status === 200 || status === 201) {
        // mensagem de sucesso
        this.$q.notify({
          message: 'Novo colaborador criado com sucesso!',
          color: "positive",
          position: "top",
        });
        // adicionando na tabela
        this.colabRows = data.map((colab) => ({
          status: colab.status,
          name: colab.nome,
          email: colab.email,
          id: colab.user_id
        }));
      }
    },
    async updateColaboradorData() {

    },
    async atualizarStatus() {
      console.log('teste');
    },
    async atualizarStatusColaborador(id) {
      console.log(id)
    },
    isRequired(value) {
			return !!value || "Campo obrigatório";
		},
    isEmail(value) {
      return (
        (value && /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)) || "E-mail deve ser válido"
      );
    },
    emailMatch(value) {
      if (value !== this.form.email) {
        return "Os emails informados não conferem, favor, preencher o campo novamente.";
      }
      return true;
    },
  },
  mounted() {},
  created() {
    this.getPartnerData();
  },
  computed: {
    
  },
};
</script>
<style>
</style>
