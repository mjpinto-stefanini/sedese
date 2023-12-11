<template>
  <q-page style="padding: 5px 15px;">
    <div class="row" style="margin: 10px 0;">
      <div class="col-12">
        <q-btn class="bg-primary text-white" @click="voltarPagina" style="float: right;">
          Voltar
        </q-btn>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6">
        <q-card>
          <q-card-section class="text-black">
            <div class="row">
              <div class="col-md-11 col-lg-1">
                <div class="text-subtitle2">Dados da Instituição:</div>
                <div class="text-h6">
                  <span v-if="editarDadosParceiro === false">
                    <font-awesome-icon :icon="['far', 'user']" />
                    {{ this.parceiro.nome_instituicao }}
                  </span>
                  <span v-else>
                    <q-input outlined v-model="dadosParceiro.nomeInstituicao" label="Nome da Instituição" style="margin-left: 35px; margin-right: 25px;">
                      <template v-slot:prepend>
                        <font-awesome-icon :icon="['far', 'user']" />
                      </template>
                    </q-input>
                    
                  </span>
                </div>
                <div class="col-12" style="margin-left: 35px; margin-right: 25px;">
                  <span v-if="editarDadosParceiro === false">
                    CNPJ: {{ this.parceiro.cnpj }}
                  </span>
                  <span v-else>
                    <q-input outlined v-model="dadosParceiro.cnpj" style="margin-top: 10px;" label="CNPJ" v-mask="['##.###.###/####-##']" />
                  </span>
                </div>
              </div>
              <div class="col-md-1 col-lg-1">
                <q-btn class="bg-primary text-caption text-white" @click="updateColaboradorData">
                  <font-awesome-icon :icon="['far', 'pen-to-square']" />
                  <q-tooltip
                      class="bg-primary text-caption outline"
                      :offset="[10, 10]"
                      style="max-width: 600px">
                      Editar informações do Parceiro.
                    </q-tooltip>
                </q-btn>
              </div>
            </div>
            <div class="row">
              <!-- sumindo com esse block para o form -->
              <div class="col-12" v-if="editarDadosParceiro === false">
                <div v-if="this.parceiro.status === '1'" style="float: left;">
                  <q-badge color="green" label="Ativo" style="margin: 0 5px;" />
                </div>
                <div v-else style="float: left;">
                  <q-badge color="red" label="Inativo" style="margin: 0 5px;" />
                </div>
                <q-badge color="purple" label="Outros Parceiros Participantes" style="margin: 0 5px;" />
              </div>

              <div class="col-12" style="margin-top: 15px;">
                <table class="table" v-if="editarDadosParceiro === false">
                  <tr>
                    <td class="text-grey text-right">Responsável Legal:</td>
                    <td >
                      {{ this.parceiro.responsavel_legal }}
                    </td>
                  </tr>
                  <tr> <td colspan="2"></td> </tr>
                  <tr> <td colspan="2"></td> </tr>
                  <tr> <td colspan="2"></td> </tr>
                  <tr> <td colspan="2"></td> </tr>
                  <tr>
                    <td class="text-grey text-right">CPF:</td>
                    <td >
                      {{ this.parceiro.cpf }}
                    </td>
                  </tr>
                  <tr>
                    <td class="text-grey text-right">E-mail:</td>
                    <td >
                      {{ this.parceiro.email }}
                    </td>
                  </tr>
                  <tr>
                    <td class="text-grey text-right">Telefone:</td>
                    <td >
                      {{ this.parceiro.telefone }}
                    </td>
                  </tr>
                  <tr> <td colspan="2"></td> </tr>
                  <tr> <td colspan="2"></td> </tr>
                  <tr> <td colspan="2"></td> </tr>
                  <tr> <td colspan="2"></td> </tr>
                  <tr>
                    <td class="text-grey text-right">Observações:</td>
                    <td >
                      {{ this.parceiro.observacao }}
                    </td>
                  </tr>
                </table>
                <div v-else>
                  <div class="text-subtitle2">Dados do Responsavel Legal:</div>
                  <q-btn class="bg-red text-white btn-sm" @click="MudarResponsavel">Mudar Responsavel Legal</q-btn>
                  
                  <q-input outlined v-model="dadosParceiro.nomeResponsavel" label="Nome do Responsavel Legal" style="margin-top: 10px; margin-left: 35px; margin-right: 25px;"/>
                  <q-input outlined v-model="dadosParceiro.cpf" label="CPF do Responsavel" style="margin-top: 10px; margin-left: 35px; margin-right: 25px;"/>
                  <q-input outlined v-model="dadosParceiro.email" label="E-mail do responsavel" style="margin-top: 10px; margin-left: 35px; margin-right: 25px;" />
                  <q-input outlined v-model="dadosParceiro.telefone" label="Telefone do responsavel" style="margin-top: 10px; margin-left: 35px; margin-right: 25px;"/>
                  <q-input outlined v-model="dadosParceiro.observacao" label="Observações" type="textarea" maxlength="250" style="margin-top: 10px; margin-left: 35px; margin-right: 25px;" />
                </div>
                <hr class="border-grey" style="margin: 25px 0;"/>
                <h6 style="margin: 15px;">Ações</h6>
                <q-toggle 
                  color="green" 
                  v-model="parceiroStatus" 
                  :label="parceiroStatusLabel" 
                  @click="atualizarStatus" />
                <div v-if="editarDadosParceiro === false">
                  <q-btn outline style="margin-top:-55px; margin-left: 200px;" @click="novoColaborador = true">Novo Colaborador</q-btn>
                </div>
                <div v-else>
                  <q-btn class="bg-green text-white" style="margin-top:-55px; margin-left: 200px;" @click="atualizarParceiroData">
                    Salvar Dados
                  </q-btn>
                </div>
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
                  <div v-if="props.row.status === '1'" style="float: left;">
                    <a href="#" @click="mudarStatusColaborador(props.row.uuid)">
                      <q-badge color="green" label="Ativo" style="margin: 0 5px;" />
                    </a>
                  </div>
                  <div v-else style="float: left;">
                    <a href="#" @click="mudarStatusColaborador(props.row.uuid)">
                      <q-badge color="red" label="Inativo" style="margin: 0 5px;" />
                    </a>
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
    <!-- Salvar novo Colaborador -->
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
              <q-input outlined v-model="dadoColaborador.email" label="Email" :rules="[isRequired, isEmail]"/>
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
import { useQuasar } from 'quasar';
import Swal from 'sweetalert2'
import router from '@/router';

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
});

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
      dadosParceiro: {
        nomeInstituicao: null,
        cnpj:null,
        nomeResponsavel:null,
        cpf:null,
        email:null,
        telefone:null,
        observacao:null,
        mudarResponsavelLegal: false,
      },
      editarDadosParceiro: false,
    }
  },
  setup() {
    const $q = useQuasar();
    return {
      novoColaborador: ref(false),
      parceiroStatus: ref(true),
    }
  },
  methods: {
    async getPartnerData() {
      this.dadosParceiro = [];
      try {
        const { data, status } =  await this.$http.get("parceiros/show/" + this.PartnerId);
        this.parceiro = data;
        if (status === 200) {
          this.getColaboradoresData()
          // verificando status do parceiro
          this.parceiroStatus = this.parceiro.status === '1' ? true : false;
          this.parceiroStatusLabel = this.parceiro.status === '1' ? 'Ativo' : 'Inativo';
          // passando os dados do parceiro
          this.dadosParceiro.nomeInstituicao = this.parceiro.nome_instituicao;
          this.dadosParceiro.cnpj = this.parceiro.cnpj;
          this.dadosParceiro.nomeResponsavel = this.parceiro.responsavel_legal;
          this.dadosParceiro.cpf = this.parceiro.cpf;
          this.dadosParceiro.email = this.parceiro.email;
          this.dadosParceiro.telefone = this.parceiro.telefone;
          this.dadosParceiro.observacao = this.parceiro.observacao;
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
      // setando as rows como nulas
      this.colabRows = [];
      try {
        const { data, status } = await this.$http.get("colaboradores/?id=" + this.PartnerId);
        if (status === 200 && Array.isArray(data)) {
          data.forEach((colab) => {
            this.colabRows.push({
              status: colab.status,
              name: colab.nome,
              email: colab.email,
              id: colab.user_id,
              uuid: colab.uuid
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
          id: colab.user_id,
          uuid: colab.uuid
        });
      });
    },
    async salvarColaborador() {
      try {
        this.novoCadastro = {
          'parceiro': this.parceiro,
          'colaborador': this.dadoColaborador
        };

        const cadastroExistente = await this.verificaCadastroColaborador();
        console.log(cadastroExistente);
        const instituicoes = cadastroExistente.map(cadastro => cadastro.instituicao).join(', ');
        console.log(instituicoes);

        if (cadastroExistente.length > 0) {
          // const instituicoes = cadastroExistente.map(cadastro => cadastro.instituicao).join(', ');

          const swalResult = await Swal.fire({
            title: "Aviso",
            html: `Este colaborador está cadastrado em <b>${instituicoes}</b>. Deseja confirmar o cadastro?`,
            // text: `Este colaborador está cadastrado em <b>${instituicoes}</b>. Deseja confirmar o cadastro?`,
            icon: "warning",
            showDenyButton: true,
            confirmButtonColor: "#5cb768",
            denyButtonColor: "#f34d45",
            confirmButtonText: "Confirmar",
            denyButtonText: 'Cancelar'
          });

          if (swalResult.isConfirmed) {
            await this.enviarDadosColaborador();
          } else if (swalResult.isDenied) {
            this.$router.go();
          }
        } else {
          await this.enviarDadosColaborador();
        }
      } catch (error) {
        this.$q.notify({
          message: error.message || 'Falha ao cadastrar novo colaborador',
          color: "negative",
          position: "top",
        });
      }
    },
    async enviarDadosColaborador() {
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
          id: colab.user_id,
          uuid: colab.uuid
        }));
      }
      this.$router.go();
    },
    async verificaCadastroColaborador() {
      const result = await this.$http.get("/colaboradores/checkar?name=" + this.dadoColaborador.nome + "&cpf=" + this.dadoColaborador.cpf + "&email=" + this.dadoColaborador.email);
      return result.data ?? [];
    },
    async atualizarParceiroData() {
      try {
        console.log(this.colabRows);
        const { data, status } = await this.$http.post('parceiros/update/' + this.PartnerId, this.dadosParceiro);

        if (this.dadosParceiro.mudarResponsavelLegal === true) {
          const userIds = this.colabRows.map((colab) => colab.user_id);
          data.forEach((colab) => {
            console.log(id);
            if (!userIds.includes(colab.user_id)) {
              this.colabRows.push({
                status: colab.status,
                name: colab.nome,
                email: colab.email,
                id: colab.user_id,
                uuid: colab.uuid
              });
            }
          });
        }

        this.$q.notify({
          message: 'Dados do Parceiro alterados com sucesso!',
          color: "positive",
          position: "top",
        });
      } catch (error) {
        this.$q.notify({
          message: error.message || 'Falha ao cadastrar novo colaborador',
          color: "negative",
          position: "top",
        });
      }
    },
    async updateColaboradorData() {
      if (this.editarDadosParceiro === true) {
        this.editarDadosParceiro = false;
      } else {
        this.editarDadosParceiro = true;
      }
    },
    MudarResponsavel() {
      Swal.fire({
        title: "Mudança de Responsável Legal!",
        text: "Ao fazer isso, o responsavél legal, será direcionado a lista de colaboradores.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#5cb768",
        cancelButtonColor: "#f34d45",
        confirmButtonText: "Limpar campos e trocar responsavél",
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          // limpando campos e mudando o status para mudar o responsavel legal
          this.dadosParceiro.nomeResponsavel = null;
          this.dadosParceiro.cpf = null;
          this.dadosParceiro.email = null;
          this.dadosParceiro.telefone = null;
          this.dadosParceiro.observacao = null;
          this.dadosParceiro.mudarResponsavelLegal = true;
        }
      });
    },
    async atualizarStatus() {
      Swal.fire({
        title: "Atualizar Status do Parceiro!",
        text: "Ao desativar está instituição, todos os colaboradores dela, também terão seus status desativados. Porem, caso reative o status dela, será necessário reativar os status dos colaboradores manuamente.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#5cb768",
        cancelButtonColor: "#f34d45",
        confirmButtonText: "Confirmar",
        cancelButtonText: 'Cancelar'
      }).then(async (result) => {
        if (result.isConfirmed) {
          try {
            let parceiroStatusParams = {
              'status': this.parceiroStatus === true ? 1 : 0,
              'id': this.PartnerId
            };
            const { data, status } = await this.$http.post("parceiros/updateStatus/", parceiroStatusParams);
            if (status === 200) {
              this.$q.notify({
                message: 'Status do Parceiro Atualiazado com sucesso.',
                color: "positive",
                position: "top",
              });
              // atualizando os dados
              this.getPartnerData()
            }
          } catch (error) {
            this.$q.notify({
              message: error.message || 'Falha ao atualizar os status',
              color: "negative",
              position: "top",
            });
          }
        } else {
          // atualizando os dados
          this.getPartnerData();
        }
      });
    },
    async mudarStatusColaborador(id) {      
      try {
        Swal.fire({
          title: "Mudar Status do Colaborador!",
          text: "Deseja alterar o status do colaborador?.",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#5cb768",
          cancelButtonColor: "#f34d45",
          confirmButtonText: "Confirmar",
          cancelButtonText: 'Cancelar'
        }).then(async (result) => {
          if (result.isConfirmed) {
            const { data, status } = await this.$http.get('/colaboradores/trocarStatus?uuid=' + id);
            if (status === 200) {
              this.$q.notify({
                message: 'Status do Colaborador Atualiazado com sucesso.',
                color: "positive",
                position: "top",
              });
              // atualizando os dados
              this.getPartnerData();
              // this.$router.go();
            }
          }
        })
      } catch (error) {
        this.$q.notify({
          message: error.message || 'Falha ao atualizar os status',
          color: "negative",
          position: "top",
        });
      }
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
      if (value !== this.dadoColaborador.email) {
        return "Os emails informados não conferem, favor, preencher o campo novamente.";
      }
      return true;
    },
    voltarPagina() {
      // limpando os dados dos colaboradores 
      // para garantir que não haja cache
      this.colabRows = [];
      // voltando a pagina de parceiros
      this.$router.push({ name: "PartnersMainPage" });
    }
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
