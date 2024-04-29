<template>
  <q-page padding>
    <q-dialog v-model="dialog" persistent>
      <q-card>
        <q-card-section class="row items-center">
          <q-toolbar>
            <q-avatar icon="person" color="primary" text-color="white" />
            <q-toolbar-title>{{ selectedUser.name }} </q-toolbar-title>
            <span class="q-ml-sm"> {{ selectedUser.created }} </span>
            <q-btn
              color="primary"
              icon="close"
              round
              flat
              @click="dialog = false"
              class="q-ml-md"
            />
          </q-toolbar>
        </q-card-section>

        <q-separator class="q-mb-lg" />

        <q-card flat>
          <q-card-section>
            <div class="row q-col-gutter-md">
              <div class="col-12">
                <q-toggle
                  v-model="form.is_active"
                  color="green"
                  label="Ativado"
                  :disable="user.is_admin && user.type_admin === '3'"
                />
              </div>

              <div class="col-12">
                <q-toggle
                  v-model="form.is_admin"
                  color="green"
                  label="Administrador"
                  :disable="user.is_admin && user.type_admin !== '1'"
                />
              </div>

              <div class="col-12">
                <q-select
                  :disable="
                    user.is_admin &&
                    user.type_admin !== '1' &&
                    user.type_admin !== '2'
                  "
                  v-model="form.type_admin"
                  :options="optionsUser"
                  label="Tipo de Administrador"
                  outlined
                  use-input
                  clear-icon="close"
                  clearable
                />
              </div>
            </div>
          </q-card-section>
        </q-card>

        <q-card-actions align="right">
          <!--
            <q-btn
            color="negative"
            label="Resetar Senha"
            no-caps
            unelevated
            padding="sm xl"
            @click="dialog = true"
            v-close-popup
          />
        -->
          <q-btn
            color="primary"
            label="Salvar"
            no-caps
            unelevated
            padding="sm xl"
            @click="onSave"
          />
        </q-card-actions>
      </q-card>
    </q-dialog>

    <q-toolbar>
      <q-toolbar-title> Lista de usuários</q-toolbar-title>
      <q-btn flat round dense icon="apps" class="q-mr-xs" />
      <q-btn flat round dense icon="more_vert" />
    </q-toolbar>

    <div class="row">
      <div class="col-sm-12 col-md-4 offset-md-2">
        <q-card flat>
          <q-card-section>
            <div class="q-pa-md">
              <q-select
              outlined
              v-model="consulta.status"
              :options="consultaStatusOptions"
              label="Status">
              <template v-slot:no-option>
                  <q-item>
                    <q-item-section class="text-grey">
                      &nbsp;
                    </q-item-section>
                  </q-item>
                </template>
              </q-select>
            </div>

            <div class="q-pa-md">
              <q-select
                v-model="consulta.tipoPerfil"
                :options="tipoPerfilOptions"
                outlined
                label="Perfil">
                <template v-slot:no-option>
                  <q-item>
                    <q-item-section class="text-grey">
                      &nbsp;
                    </q-item-section>
                  </q-item>
                </template>
              </q-select>
            </div>

            <div>
              <div class="q-pa-md">
                <q-select
                  v-model="consulta.ambitoAtuacao"
                  :options="ambitoAtuacaoOptions"
                  outlined
                  lazy-rules
                  label="Ambito Atuação">
                  <template v-slot:no-option>
                    <q-item>
                      <q-item-section class="text-grey">
                        &nbsp;
                      </q-item-section>
                    </q-item>
                  </template>
                </q-select>
              </div>

              <div class="q-pa-md">
                <div v-if="consulta.ambitoAtuacao">
                  <q-select
                    outlined
                    v-model="consulta.lotacao"
                    :options="filterSecretaries"
                    :label="ambitoLabel"
                    @filter="filterFn"
                    lazy-rules
                    use-input
                    input-debounce="0">
                    <template v-slot:no-option>
                      <q-item>
                        <q-item-section class="text-grey">
                          Sem resultados!
                        </q-item-section>
                      </q-item>
                    </template>
                  </q-select>
                </div>
              </div>
            </div>

          </q-card-section>
        </q-card>
      </div>
      <div class="col-sm-12 col-md-4" style="margin-top: 15px;">
        <div class="q-pa-md">
          <q-input outlined v-model="consulta.name" label="Nome" />
        </div>

        <div class="q-pa-md">
          <q-input outlined v-model="consulta.cpf" label="CPF" mask="###.###.###-##"/>
        </div>
        <div class="q-pa-md">
          <q-input outlined v-model="consulta.email" label="E-mail" :rules="[isEmail]" />
        </div>
        <div class="q-pa-md" style="margin-top: -20px;">
          <q-btn color="green" size="18px"  @click="ConsultarUsuario" style="margin-right: 10px;">
            Pesquisar
          </q-btn>
          <q-btn color="orange" outline size="18px"  @click="limparFiltrosPagina">
            Limpar Filtros
          </q-btn>
        </div>
      </div>
    </div>

    <q-table :rows="rows" :columns="columns" row-key="name" flat bordered>
      <template v-slot:header-cell-is_active="props">
        <q-th :props="props">
          <q-icon name="sym_o_info" size="1.2rem" color="primary">
            <q-tooltip
              class="bg-primary text-caption"
              :offset="[10, 10]"
              style="max-width: 600px"
              >Informa se o usuario está ativo na plataforma, se desabilitar o
              usuario não poderá acessar a plataforma.
            </q-tooltip>
          </q-icon>
        </q-th>
      </template>

      <template v-slot:body-cell-id="props">
        <q-td :props="props">
          <div class="row">
            <div class="q-gutter-xs q-pa-xs">
              <q-btn
                size="sm"
                color="secondary"
                no-caps
                unelevated
                padding="sm"
                @click="$router.replace('/user/' + props.row.id )"
                icon="visibility"
              />
              <q-tooltip
                class="bg-secondary text-caption"
                :offset="[10, 10]"
                style="max-width: 600px"
                >Ver Dados do Usuário
              </q-tooltip>
            </div>
          </div>
        </q-td>
      </template>
      <template v-slot:body-cell-service="props">
        <q-td :props="props">
          <span v-if="props.row.service">
            <q-chip size="sm"
              :label="props.row.service"
              :color="props.row.service === 'Estadual' ? 'green' : 'blue'"
              text-color="white"
            />
          </span>
        </q-td>
      </template>
      <template v-slot:body-cell-perfil="props">
        <q-td :props="props">
          <q-chip
            size="sm"
            :text-color="props.row.perfil === 3 ? 'black' : 'white'"
            :label="props.row.perfil_label"
            :color="
              props.row.perfil === 1
                ? 'red'
                : props.row.perfil === 2
                ? 'orange'
                : 'gray'
            "
          />
        </q-td>
      </template>
      <template v-slot:body-cell-is_admin="props">
        <q-td :props="props">
          <div class="q-gutter-sm">
            <q-icon name="print" />
            <!-- <q-toggle v-model="props.row.is_admin">
                    <q-icon name="sym_o_info" size="1.2rem" color="primary">
                        <q-tooltip
                            class="bg-primary text-caption"
                            :offset="[10, 10]"
                            style="max-width: 600px">Administrativo: Informa se o usuario é um administrador.
                        </q-tooltip>
                    </q-icon>
                </q-toggle> -->
          </div>
        </q-td>
      </template>
      <template v-slot:body-cell-is_active="props">
        <q-td :props="props">
          <div class="q-gutter-sm">
            <q-chip size="sm"
              :text-color="getRowChipProperties(props.row).textColor"
              :label="getRowChipProperties(props.row).label"
              :color="getRowChipProperties(props.row).color"
            />
          </div>
        </q-td>
      </template>
    </q-table>
  </q-page>
</template>

<script>
import { ref } from 'vue';
import accountMixin from "../mixins/accountMixin";

// const tipoPerfilOptions = [
//   {value: 1, label: "Super Admin / Equipe DEP"},
//   {value: 2, label: "SUBAS / Diretorias Regionais"},
//   {value: 3, label: "Outros parceiros / Participantes"},
// ];

const tipoPerfilOptions = [
  {value:1, label: 'Responsavel Técnico'},
  {value:2, label: 'Participante'},
  {value:3, label: 'Colaborador'},
];

export default {
  name: "UsersPage",
  mixins: [accountMixin],
  data() {
    return {
      dialog: false,
      user: {},
      form: {
        type_admin: "",
        is_admin: false,
        is_active: false,
        perfil: "",
      },
      optionsUser: [
        { label: "Diretor", value: "1" }, //Diretor
        { label: "Operador", value: "2" }, //Operador
        { label: "Usuários", value: "3" }, //Usuário
      ],
      columns: [
        {
          name: "is_active",
          label: "Status",
          field: "is_active",
          align: "center",
          sortable: true,
        },
        {
          name: "name",
          label: "Nome",
          field: "name",
          align: "left",
          sortable: true,
        },
        {
          name: "perfil",
          label: "Perfil",
          field: "perfil",
          align: "left",
          sortable: true,
        },
        {
          name: "service",
          label: "Âmbito de atuação",
          field: "service",
          align: "left",
          sortable: true,
        },
        {
          name: "secretary",
          label: "Lotação/Município",
          field: "secretary",
          align: "left",
          sortable: true,
        },
        {
          name: "id",
          label: "Ações",
          field: "id",
          align: "left",
          sortable: true,
        },
      ],
      rows: [],
      selectedUser: {},
      consulta: {
        status: null,
        tipoPerfil: null,
        ambitoAtuacao: {
          value: null,
          label: null,
        },
        lotacao: {
          value: null,
          label: null,
        },
        name: null,
        cpf: null,
        email: null
      },
      allSecretaries: [],
      filterSecretaries: [],
      ambitoAtuacaoOptions: [
        { label: "Estadual", value: 1 },
        { label: "Municipal", value: 2 },
      ],
      chipTextColor: null,
      chipLabel: null,
      chipColor: null,
    };
  },
  computed: {
    consultaStatusOptions() {
      return [
        { value: 1, label: 'ATIVO', color: 'green' },
        { value: 2, label: 'INATIVO', color: 'gray' },
        { value: 3, label: 'PENDENTE', color: 'orange' },
        { value: 4, label: 'RECUSADO', color: 'red' },
      ];
    },
    ambitoLabel() {
      switch (parseInt(this.consulta.ambitoAtuacao.value)) {
        case 1:
          return 'Estadual';
        case 2:
          return 'Municipal';
        default:
          return 'Selecione o âmbito de atuação';
      }
    },
  },
  methods: {
    async onSave() {
      const data = {
        is_active: this.form.is_active,
        is_admin: this.form.is_admin,
        type_admin: this.form.type_admin.value,
      };
      try {
        const { status } = await this.$http.patch(
          `users/${this.selectedUser.id}/user`,
          data
        );
        if (status === 200) {
          this.$q.notify({
            message: "Usuário atualizado com sucesso!",
            color: "green",
            position: "top",
            icon: "check_circle",
          });
          this.rows = [];
          this.getUsers();
          this.dialog = false;
        }
      } catch (error) {
        this.$q.notify({
          message: error.response.data.message,
          color: "negative",
          position: "top"
        })
      }
    },
    limparFiltrosPagina() {
      this.$router.go();
    },
    openModal(props) {
      this.selectedUser = props.row;
      this.form.is_active = this.selectedUser.is_active;
      this.form.is_admin = this.selectedUser.is_admin;
      this.form.type_admin = this.selectedUser.type_admin;
      this.user = JSON.parse(localStorage.getItem("user"));
      this.dialog = true;
    },
    async getUsers() {
      try {
        const { data, status } = await this.$http.get("users/");
        if (status === 200) {
          data.forEach((user) => {
            this.rows.push({
              name: user.name,
              cpf: user.cpf.replace(
                /(\d{3})(\d{3})(\d{3})(\d{2})/,
                "$1.$2.$3-$4"
              ),
              service: user.service === "1" ? "Estadual" : (user.service === "2" ? "Municipal" : null),
              secretary: user.secretary,
              is_admin: !!user.is_admin,
              id: user.id,
              is_active: !!user.is_active,
              perfil: parseInt(user.perfil),
              perfil_label:
                parseInt(user.perfil) === 1
                  ? "Responsavel Técnico"
                  : parseInt(user.perfil) === 2
                  ? "Participante"
                  : "Colaborador",
              created: new Date(user.created_at).toLocaleString("pt-BR"),
              status: user.status
            });
            // this.updateChipProperties(user.status);
          });
          // this.rows = data;
        }
      } catch (error) {
        this.$q.notify({
          message: error.response.data.message,
          color: "negative",
          position: "top",
        });
      }
    },
    getRowChipProperties(row) {
      const perfilStatus = this.consultaStatusOptions.find(item => item.value === row.status);

      return {
        textColor: perfilStatus ? 'white' : '',
        label: perfilStatus ? perfilStatus.label : '',
        color: perfilStatus ? perfilStatus.color : '',
      };
    },
    async ConsultarUsuario() {
      const queryParams = {
        status: this.consulta.status ? this.consulta.status.value : null,
        perfil: this.consulta.tipoPerfil ? this.consulta.tipoPerfil.value : null,
        service: this.consulta.ambitoAtuacao ? this.consulta.ambitoAtuacao.value : null,
        secretary: this.consulta.lotacao ? this.consulta.lotacao.value : null,
        name: this.consulta.name,
        cpf: this.consulta.cpf,
        email: this.consulta.email,
      };

      try {
        const { data, status } = await this.$http.get("users", { params: queryParams });
        if (status === 200) {
          // limpando a row da tabela para que os novos dados sejam inceridos
          this.rows = [];
          // adicionando o resultado na tabela
          data.forEach((user) => {
            this.rows.push({
              name: user.name,
              cpf: user.cpf.replace(
                /(\d{3})(\d{3})(\d{3})(\d{2})/,
                "$1.$2.$3-$4"
              ),
              service: user.service === "1" ? "Estadual" : (user.service === "2" ? "Municipal" : null),
              secretary: user.secretary,
              is_admin: !!user.is_admin,
              id: user.id,
              is_active: !!user.is_active,
              perfil: parseInt(user.perfil),
              perfil_label:
                parseInt(user.perfil) === 1
                  ? "Responsavel Técnico"
                  : parseInt(user.perfil) === 2
                  ? "Participante"
                  : "Colaborador",
              created: new Date(user.created_at).toLocaleString("pt-BR"),
              status: user.status
            });
          });
        }
      } catch (error) {
        this.$q.notify({
          message: error.response?.data.message,
          color: "negative",
          position: "top"
        })
      }
    },
    async getSecretaries() {
      try {
        if (!this.consulta.ambitoAtuacao.value) {
          return null;
        }
        const { data, status } = await this.$http.get(
          `ambitoatuacao/regiaoadm/${
              this.consulta?.ambitoAtuacao.value === 1 ? "1" : "2"
        }`);
        if (status === 200) {
          this.allSecretaries = data.map((ele) => {
            return {
              ...ele,
              label: ele.nome,
              value: ele.id,
            };
          });

          this.filterSecretaries = this.allSecretaries;
        }
      } catch (error) {
        this.$q.notify({
          message: error.message,
          color: "negative",
          position: "top",
        });
      }
    },
    filterFn(val, update) {
      if (val === "") {
        update(() => {
          this.filterSecretaries = this.allSecretaries;
        });
        return;
      }
      update(() => {
        const needle = val.toLowerCase();
        this.filterSecretaries = this.allSecretaries.filter((v) => {
          return v.nome.toLowerCase().indexOf(needle) > -1;
        });
      });
    },
    isEmail(value) {
      return ((value && /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)) || "E-mail deve ser válido");
		}
  },
  created() {
    this.getUsers();
    this.getSecretaries();
  },
  setup() {
    return {
      model: ref(null),
      tipoPerfilOptions,
    }
  },
  watch: {
    'consulta.ambitoAtuacao'(newValue) {
      this.consulta.lotacao = null;
      this.getSecretaries();
    }
  },
};
</script>