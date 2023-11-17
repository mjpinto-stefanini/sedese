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
              <q-input v-model="consulta.cpf_cnpj" label="CPF / CNPJ" outlined clear-icon="close" clearable />
            </div>
            <div class="col-12" style="margin: 5px 0;">
              <q-input v-model="consulta.email" label="E-mail" outlined clear-icon="close" clearable />
            </div>
            <div class="col-4">
              <q-btn outline>Pesquisar</q-btn>
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
          :rows="rows"
          :columns="columns"
          virtual-scroll
          v-model:pagination="pagination"
          :rows-per-page-options="[0]" >
          <template v-slot:body-cell-status="props">
            <q-td :props="props">
              <div v-if="props.row.status === 'Ativo'">
                <q-badge color="green" :label="props.value" />
              </div>
              <div v-if="props.row.status === 'Inativo'">
                <q-badge color="red" :label="props.value" />
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
								@click="$router.replace('/parceiro/' + props.row.id )"
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
                <q-input outlined style="margin: 5px 0;" v-model="novoParceiro.nomeInstituicao" label="Nome da Instituição"/>
              </div>
              <div class="col-12">
                <q-input outlined style="margin: 5px 0;" v-model="novoParceiro.cnpj" label="CNPJ"/>
              </div>
            </q-card>
            <q-card style="padding: 5px 15px; margin-bottom: 10px;" class="row">
              <div class="col-12">
                <q-input outlined style="margin: 5px 0;" v-model="novoParceiro.nomeResponsavel" label="Responsavel Legal"/>
              </div>
              <div class="col-12">
                <q-input outlined style="margin: 5px 0;" v-model="novoParceiro.cpf" label="CPF"/>
              </div>
              <div class="col-12">
                <q-input outlined style="margin: 5px 0;" v-model="novoParceiro.telefone" label="Telefone"/>
              </div>
              <div class="col-12">
                <q-input outlined style="margin: 5px 0;" v-model="novoParceiro.email" label="E-mail"/>
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

const columns = [
  {
    name: 'status',
    label: 'Status',
    field: 'status'
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
  { name: 'id', label: 'ações', field: 'id', sortable: true },
];

const rows = [
  {
    status: 'Ativo',
    name: 'Rede DEV de Desenvolvimento',
    email: 'email@teste.com',
    telefone: '(11) 97585-3333',
    id: 'teste'
  },
  {
    status: 'Inativo',
    name: 'Rede DEV de Desenvolvimento',
    email: 'email@teste.com',
    telefone: '(11) 97585-3333',
    id: 'teste'
  },
];

const options = [
  'Ativo',
  'Inativo'
];

const modalNovoParceiro = '';

export default {
	name: "PartnersMainPage",
	data() {
		return {
      columns,
      rows,
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
    }
  },
	methods: {
    async salvarParceiros() {
      try {
        this.$q.loading.show();
        const { data, status } = await this.$http.post("parceiros/store", this.novoParceiro);
        if (status === 200 || status === 201) {
          console.log(data);
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
    }
  },
};
</script>
