<template>
	<q-page padding>
		<q-toolbar>
			<q-toolbar-title> Lista de Parceiros </q-toolbar-title>
		</q-toolbar>

    <q-card style="padding: 15px 0;">
      <div class="row" >
        <div class="col-8 offset-2">        
          <q-form class="row">
            <div class="col-12" style="margin: 5px 0;">
              <q-select v-model="consulta.status" :options="options" outlined label="Status" />
            </div>
            <div class="col-12" style="margin: 5px 0;">
              <q-input v-model="consulta.nomeParceiro" label="Nome do Parceiro" outlined clear-icon="close" clearable />
            </div>
            <div class="col-12" style="margin: 5px 0;">
              <q-input v-model="consulta.nomeEmpresa" label="Nome da Empresa" outlined clear-icon="close" clearable />
            </div>
            <div class="col-12" style="margin: 5px 0;">
              <q-input v-model="consulta.cpf_cnpj" label="CPF / CNPJ" outlined clear-icon="close" clearable v-mask="['###.###.###-##', '##.###.###/####-##']"  maxlength="20" />
            </div>
            <div class="col-12" style="margin: 5px 0;">
              <q-input v-model="consulta.email" label="E-mail" outlined clear-icon="close" clearable :rules="[isEmail]" />
            </div>
            <div class="col-4">
              <q-btn outline @click="consultaPorCampo">Pesquisar</q-btn>
            </div>
            <div class="col-4 offset-4">
              <q-btn outline style="float: right;" @click="modalNovoParceiro = true">Novo Parceiro</q-btn>
            </div>
          </q-form>
        </div>
      </div>
    </q-card>
    <div class="row" style="margin-top: 35px;">
      <div class="col-8 offset-2">
        <q-table 
          flat bordered
          :rows="parceirosRow"
          :columns="columns"
          virtual-scroll
          v-model:pagination="pagination"
          :rows-per-page-options="[0]" >
          <template v-slot:body-cell-status="props">
            <q-td :props="props">
              <div v-if="props.row.status === '1'">
                <q-badge color="green" label="Ativo" />
              </div>
              <div v-if="props.row.status === '2'">
                <q-badge color="red" label="Inativo" />
              </div>
            </q-td>
          </template>
          <template v-slot:body-cell-id="props">
            <q-td :props="props">
              <q-btn
								size="sm"
								color="secondary"
								no-caps
								unelevated
								padding="sm"
								@click="$router.replace('/parceiro/' + props.row.uuid )"
								icon="visibility"
							/>
							<q-tooltip
								class="bg-secondary text-caption"
								:offset="[10, 10]"
								style="max-width: 600px"
								>Ver Dados do Parceiro
							</q-tooltip>
            </q-td>
          </template>
        </q-table>
      </div>
    </div>
		
    <q-dialog v-model="modalNovoParceiro" persistent transition-show="scale" transition-hide="scale">
      <q-card class="bg-blue text-white" style="width: 700px; max-width: 80vw;">
        <q-card-section>
          <div class="text-h6">Cadatrar Novo Parceiro</div>
        </q-card-section>

        <q-card-section class="bg-white">
          <q-form class="row">
            <q-card style="padding: 5px 15px; margin-bottom: 10px; width: 100%;" class="row">
              <div class="col-12">
                <q-input outlined style="margin: 5px 0;" v-model="novoParceiro.nomeInstituicao" label="Nome da Instituição" :rules="[isRequired]"/>
              </div>
              <div class="col-12">
                <q-input outlined style="margin: 5px 0;" v-model="novoParceiro.cnpj" label="CNPJ" mask="##.###.###/####-##" :rules="[isRequired]"/>
              </div>
            </q-card>
            <q-card style="padding: 5px 15px; margin-bottom: 10px;" class="row">
              <div class="col-12">
                <q-input outlined style="margin: 5px 0;" v-model="novoParceiro.nomeResponsavel" label="Responsavel Legal" :rules="[isRequired]"/>
              </div>
              <div class="col-12">
                <q-input outlined style="margin: 5px 0;" v-model="novoParceiro.cpf" label="CPF" mask="###.###.###-##" :rules="[isRequired]" />
              </div>
              <div class="col-12">
                <q-input outlined style="margin: 5px 0;" v-model="novoParceiro.telefone" label="Telefone" v-mask="['(##) ####-####', '(##) #####-####']" />
              </div>
              <div class="col-12">
                <q-input outlined style="margin: 5px 0;" v-model="novoParceiro.email" label="E-mail" :rules="[isRequired, isEmail]"/>
              </div>
              <div class="col-12">
                <q-input outlined v-model="novoParceiro.observacao" label="Observações" type="textarea" maxlength="250" />
              </div>
            </q-card>
            <div class="row">
              <div class="col-12">
                <q-btn flat label="Cancelar" class="bg-red text-white" style="margin: 5px;" v-close-popup />
                <q-btn flat label="Salvar" class="bg-green text-white" style="margin: 5px;" @click="salvarParceiros"  v-close-popup />
              </div>
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>

	</q-page>
</template>
<style></style>
<script>
import { ref } from 'vue';
import {TheMask} from 'vue-the-mask';

const columns = [
  {
    name: 'status',
    label: 'Status',
    field: 'status',
    sortable: true
  },
  {
    name: 'name',
    required: true,
    label: 'Nome da Instituição',
    align: 'left',
    field: row => row.name,
    format: val => `${val}`,
    sortable: true
  },
  { name: 'email', align: 'center', label: 'email', field: 'email', sortable: true },
  { name: 'telefone', label: 'telefone', field: 'telefone', sortable: true },
  { name: 'id', label: 'ações', field: 'id' },
];

let parceirosRow = [];
let rows = [];
for (let i = 0; i < parceirosRow.length; i++) {
  rows = rows.concat(parceirosRow.slice(0).map(r => ({ ...r })))
}
rows.forEach((row, index) => {
  row.index = index
})


const options = [
  {
    value:1,
    label: 'Ativo'
  },
  {
    value:2,
    label: 'Inativo'
  }
];

const modalNovoParceiro = '';

export default {
	name: "PartnersMainPage",
  components: {TheMask},
	data() {
		return {
      columns,
      parceirosRow: [],
      options,
      consulta: {
        status: null,
        nomeParceiro: null,
        nomeEmpresa: null,
        cpf_cnpj: null,
        email: null,
      },
      novoParceiro:{
        nomeInstituicao: null,
        cnpj:null,
        nomeResponsavel:null,
        cpf:null,
        email:null,
        telefone:null,
        observacao:null
      }
		};
	},
  setup() {
    return {
      modalNovoParceiro: ref(false),
      pagination: ref({
        rowsPerPage: 10
      })
    }
  },
	methods: {
    async salvarParceiros() {
      try {
        this.$q.loading.show();
        const { data, status } = await this.$http.post("parceiros/store", this.novoParceiro);
        if (status === 200 || status === 201) {
          this.$q.notify({
            message: 'Novo parceiro criado com sucesso!',
            color: "positive",
            position: "top",
				  });

          await this.getParceiros();
        }
      } catch (error) {
        this.$q.notify({
					message: error.response.data.message,
					color: "negative",
					position: "top",
				});
      } finally {
				this.$q.loading.hide();
			}
    },
    async getParceiros() {
      try {
        if (this.dadosConsulta) {
          this.parceirosRow = []; // Limpar os dados anteriores, se necessário
          this.dadosConsulta.forEach((partner) => {
            this.parceirosRow.push({
              status: partner.status,
              name: partner.nome_instituicao,
              email: partner.email,
              telefone: partner.telefone,
              id: partner.id
            });
          });
        } else {
          const { data, status } = await this.$http.get("parceiros/");
          if (status === 200) {
            data.forEach((partner) => {
              this.parceirosRow.push({
                status: partner.status,
                name: partner.nome_instituicao,
                email: partner.email,
                telefone: partner.telefone,
                id: partner.id,
                uuid: partner.uuid
              });
            });
          }
        }
      } catch (error) {
        this.$q.notify({
          message: error.response.data.message,
          color: "negative",
          position: "top",
        });
      }
    },
    async consultaPorCampo() {
      try {
        this.$q.loading.show();
        const { data, status } = await this.$http.get("/parceiros/consultar", this.consulta);
        this.dadosConsulta = data; // Armazenar os dados obtidos para utilização posterior
        console.log(data);
        this.getParceiros(); // Chamar a função getParceiros para carregar os dados
      } catch (error) {
        this.$q.notify({
          message: error.response.data.message,
          color: 'negative',
          position: 'top',
        });
      } finally {
        this.$q.loading.hide();
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
  },
  mounted() {
    if (this.$route.query.message && this.$route.query.type) {
      this.$q.notify({
        type: this.$route.query.type,
        message: this.$route.query.message,
      })
    }
  },
  created() {
		this.getParceiros();
	},
};
</script>
