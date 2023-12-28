<template>
  <q-page class="bg-grey-1">
    <div class="q-pa-md">
      <div class="row" style="margin-bottom: 10px;">
        <div class="col-12">
          <q-btn class="bg-primary text-white" @click="voltarPagina" style="float: right;">
            Voltar
          </q-btn>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-4 q-pa-xs">
          <q-card class="my-card">
            <q-card-section>
              <div class="text-h6">
                <q-icon name="sym_o_person" color="primary"/> {{ user.name }}
                <q-btn class="bg-primary text-caption text-white" @click="modalDadosPessoais = true" style="float: right;">
                  <font-awesome-icon :icon="['far', 'pen-to-square']" />
                  <q-tooltip
                    class="bg-primary text-caption outline"
                    :offset="[10, 10]"
                    style="max-width: 600px">
                      Editar informações do pessoais.
                  </q-tooltip>
                </q-btn>
              </div>
              <div>
                <q-chip size="sm" 
                  :text-color="user.is_active ? 'white' : 'dark'"
                  :label="user.is_active ? 'Ativado' : 'Desativado'"
                  :color="user.is_active ? 'green' : 'gray'"
                />
                <q-chip v-if="user.type_admin == 1" size="sm"
                    :text-color="'white'"
                    :label="'Super Admin / Equipe DEP'"
                    :color="'primary'"
                />
                <q-chip v-if="user.type_admin == 2" size="sm"
                    :text-color="'white'"
                    :label="'SUBAS / Diretorias Regionais'"
                    :color="'primary'"
                />
                <q-chip v-if="user.type_admin == 3" size="sm"
                    :text-color="'white'"
                    :label="'Outros parceiros / Participantes'"
                    :color="'primary'"
                />
              </div>
            </q-card-section>
            <q-card-section>
              <div class="row">
                <div class="col-sm-12 q-pa-xs" v-if="user.secretaria">
                  <span class="text-grey">Secretaria</span> {{ user.secretaria }}
                </div>
                <div class="col-sm-12 q-pa-xs" v-if="user.name">
                  <span class="text-grey">Nome</span> {{ user.name }}
                </div>
                <div class="col-sm-12 q-pa-xs" v-if="personal.social_name">
                  <span class="text-grey">Nome Social</span> {{ personal.social_name }}
                </div>
                <div class="col-sm-12 q-pa-xs" v-if="personal.gender_identity">
                  <span class="text-grey">Identidade de Gênero</span> {{ personal.gender_identity }}
                </div>
                <div class="col-sm-12 q-pa-xs" v-if="personal.social_name">
                  <span class="text-grey">Nome Social</span> {{ personal.social_name }}
                </div>
                <div class="col-sm-12 q-pa-xs" v-if="user.birthday">
                  <span class="text-grey">Data de nascimento</span> {{ user.birthday_txt }}
                </div>
                <div class="col-sm-12 q-pa-xs" v-if="user.cpf">
                  <span class="text-grey">CPF</span> {{ user.cpf }}
                </div>
                <div class="col-sm-12 q-pa-xs" v-if="personal.rg">
                  <span class="text-grey">RG</span> {{ personal.rg }}
                </div>
                <div class="col-sm-12 q-pa-xs" v-if="personal.issuing_body">
                  <span class="text-grey">Orgão emissor</span> {{ personal.issuing_body }}
                </div>
                <div class="col-sm-12 q-pa-xs" v-if="personal.uf">
                  <span class="text-grey">UF</span> {{ personal.uf }}
                </div>
                <div class="col-sm-12 q-pa-xs" v-if="personal.education">
                  <span class="text-grey">Escolaridade</span> {{ personal.education }}
                </div>
                <div class="col-sm-12 q-pa-xs" v-if="personal.profission !== 'Outros' && personal.profission">
                  <span class="text-grey">Profissão</span> {{ personal.profission }}
                </div>
                <div class="col-sm-12 q-pa-xs" v-if="personal.profission === 'Outros'">
                  <span class="text-grey">Profissão</span> {{ personal.profission_others }}
                </div>
                <div class="col-sm-12 q-pa-xs" v-if="personal.is_deficiency">
                  <span class="text-grey">Deficiência</span> <span v-if="personal.deficiency !== 'Outros'"> {{ personal.deficiency }}</span><span v-if="personal.deficiency === 'Outros'"> {{ personal.deficiency_others }}</span>
                </div>
                <div class="col-sm-12 q-pa-xs" v-if="personal.deficiency_structure">
                  <span class="text-grey">Necessita de estrutura para participar da ação?</span> {{ personal.deficiency_structure }}
                </div>
              </div>
            </q-card-section>
          </q-card>
          <q-card class="my-card" style="margin-top: 15px;">
            <q-card-section>
              <div class="text-h6">
                Ações
              </div>
            </q-card-section>
          </q-card>
          <q-card class="my-card" style="margin-top: 15px;">
            <q-card-section>
              <div class="text-h6">
                Atribuições do Perfil
              </div>
            </q-card-section>
          </q-card>
        </div>
        <!-- modal dados pessoais -->
        <q-dialog v-model="modalDadosPessoais">
          <q-card style="width: 80%; max-width: 80vw;">
            <q-card-section>
              <h6 style="margin: 0; padding: 0;">Editar Dados Pessoais</h6>
            </q-card-section>
            <q-card-actions>
              <q-btn outlined label="Cancelar" color="red" v-close-popup style="float: left !important; margin-left:10px;" />
              <q-btn outlined label="Salvar" color="green" @click="salvarDadosPessoais" v-close-popup />
            </q-card-actions>
          </q-card>
        </q-dialog>
        <!-- fim da modal -->
        <div class="col-sm-8 q-pa-xs">
          <div class="col-sm-12">
            <q-card class="my-card">
              <q-card-section>
                <div class="text-h6">
                  <q-icon name="sym_o_home_work" color="primary"/> Dados Residenciais
                  <q-btn class="bg-primary text-caption text-white" @click="modalDadosResidenciais = true" style="float: right;">
                    <font-awesome-icon :icon="['far', 'pen-to-square']" />
                    <q-tooltip
                      class="bg-primary text-caption outline"
                      :offset="[10, 10]"
                      style="max-width: 600px">
                        Editar informações de residencia.
                    </q-tooltip>
                  </q-btn>
                </div>
              </q-card-section>
              <q-card-section>
                <div class="row" v-if="address.id">
                  <div class="col-sm-6 q-pa-xs">
                    <span class="text-grey">CEP</span> {{ address.zip_code }}
                  </div>
                  <div class="col-sm-6 q-pa-xs">
                    <span class="text-grey">Logradouro</span> {{ address.street }}
                  </div>
                  <div class="col-sm-6 q-pa-xs">
                    <span class="text-grey">Número</span> {{ address.number }}
                  </div>
                  <div class="col-sm-6 q-pa-xs">
                    <span class="text-grey">Bairro</span> {{ address.neighborhood }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="address.complement">
                    <span class="text-grey">Complemento</span> {{ address.complement }}
                  </div>
                  <div class="col-sm-6 q-pa-xs">
                    <span class="text-grey">Cidade</span> {{ address.city }}
                  </div>
                  <div class="col-sm-6 q-pa-xs">
                    <span class="text-grey">UF</span> {{ address.state }}
                  </div>
                </div>
                <div class="row" v-if="!address.id">
                  Não Cadastrado
                </div>
              </q-card-section>
            </q-card>
          </div>
          <!-- modal para edição de dados residenciais -->
          <q-dialog v-model="modalDadosResidenciais">
            <q-card style="width: 80%; max-width: 80vw;">
              <q-card-section>
                <h6 style="margin:0px; padding: 0px;">Editar Dados Residenciais</h6>
              </q-card-section>
              <q-card-section>
                <div class="row q-col-gutter-md">
                  <div class="col-12">
                    <q-input
                      v-model="address.zip_code"
                      label="Cep"
                      name="zip_code"
                      for="zip_code"
                      outlined
                      clear-icon="close"
                      clearable
                      mask="#####-###"
                      @blur="getAddressByZipCode"
                      value=""
                      :rules="[isRequired]"
                    />
                </div>
                <div class="col-4">
                  <q-input
                    v-model="address.street"
                    label="Logradouro"
                    name="street"
                    for="street"
                    outlined
                    clear-icon="close"
                    clearable
                    :rules="[isRequired]"
                    />
                </div>
                <div class="col-4">
                  <q-input
                    v-model="address.number"
                    label="Número"
                    name="number"
                    for="number"
                    outlined
                    clear-icon="close"
                    clearable
                    ref="number"
                    :rules="[isRequired, isNumber]"
                    />
                </div>
                <div class="col-4">
                  <q-input
                    v-model="address.complement"
                    label="Complemeto"
                    outlined
                    clear-icon="close"
                    clearable
                    />
                </div>
                <div class="col-4">
                  <q-input
                    v-model="address.neighborhood"
                    label="Bairro"
                    name="neighborhood"
                    for="neighborhood"
                    outlined
                    clear-icon="close"
                    clearable
                    :rules="[isRequired]"
                    />
                </div>
                <div class="col-4">
                  <q-input
                    v-model="address.city"
                    label="Cidade"
                    name="city"
                    for="city"
                    outlined
                    clear-icon="close"
                    clearable
                    :rules="[isRequired]"
                    />
                </div>
                <div class="col-4">
                  <q-select
                    v-model="address.state"
                    :options="stateFiltered"
                    label="UF"
                    name="state"
                    for="state"
                    outlined
                    use-input
                    input-debounce="0"
                    @filter="onStateFilter"
                    clear-icon="close"
                    clearable
                    :rules="[isRequired]"
                    />
                  </div>
                </div>
              </q-card-section>
              <q-card-actions>
                <q-btn outlined label="Cancelar" color="red" v-close-popup style="float: left !important; margin-left:10px;" />
                <q-btn outlined label="Salvar" color="green" @click="salvarDadosEndereco" v-close-popup />
              </q-card-actions>
            </q-card>
          </q-dialog>
          <!-- fim da modal -->
          <div class="col-sm-12 q-pt-sm">
            <q-card class="my-card">
              <q-card-section>
                <div class="text-h6">
                  <q-icon name="sym_o_call" color="primary"/> Contato
                  <q-btn class="bg-primary text-caption text-white" @click="modalDadosContato = true" style="float: right;">
                    <font-awesome-icon :icon="['far', 'pen-to-square']" />
                    <q-tooltip
                      class="bg-primary text-caption outline"
                      :offset="[10, 10]"
                      style="max-width: 600px">
                        Editar informações de contato.
                    </q-tooltip>
                  </q-btn>
                </div>
              </q-card-section>
              <q-card-section>
                <div class="row">
                  <div class="col-sm-6 q-pa-xs">
                    <span class="text-grey">E-mail</span> {{ user.email }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="contact.phone">
                    <span class="text-grey">Telefone Residencial</span> {{ contact.phone }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="contact.cell_phone">
                    <span class="text-grey">Celular</span> {{ contact.cell_phone }} - <span class="text-grey">Whatsapp</span> {{ contact.cell_phone_whatsapp }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="contact.institutional_phone">
                    <span class="text-grey">Telefone Institucional</span> {{ contact.institutional_phone }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="contact.institutional_email">
                    <span class="text-grey">E-mail Institucional</span> {{ contact.institutional_email }}
                  </div>
                </div>
              </q-card-section>
            </q-card>
          </div>
          <!-- modal para edição de dados de contato -->
          <q-dialog v-model="modalDadosContato">
            <q-card style="width: 80%; max-width: 80vw;">
              <q-card-section>
                <h6 style="margin:0px; padding: 0px;">Editar Dados Residenciais</h6>
              </q-card-section>
              <q-card-section>
                <div class="col-12">
                  <q-input
                    v-model="user.email"
                    label="Email*"
                    outlined
                    clear-icon="close"
                    name="email"
                    for="email"
                    disable
                    clearable
                    type="email"
                    :rules="[isRequired]" 
                    />
                </div>
                <div class="col-12">
                  <q-input
                    v-model="contact.phone"
                    label="Telefone Residencial"
                    outlined
                    clear-icon="close"
                    mask="(##) ####-####"
                    :rules="[isPhoneNumber, notLessThanNormal, notMoreThanNormal]"
                    clearable
                    type="tel"
                  />
                </div>
                <div class="col-6">
                  <q-input
                    v-model="contact.cell_phone"
                    label="Nº Celular*"
                    name="cell_phone"
                    for="cell_phone"
                    outlined
                    clear-icon="close"
                    mask="(##) # ####-####"
                    :rules="[isRequired, isCellPhoneNumber, notLessThan, notMoreThan]"
                    clearable
                    type="tel"
                  />
                </div>
                <div class="col-6">
                  <q-select
                    v-model="contact.cell_phone_whatsapp"
                    name="cell_phone_whatsapp"
                    for="cell_phone_whatsapp"
                    label="Este número possui WhatsApp?"
                    :options="['Sim', 'Não']"
                    :rules="[isRequired]"
                    outlined
                  />
                </div>
                <div class="col-12">
                  <q-input
                    v-model="contact.institutional_phone"
                    label="Telefone Institucional"
                    outlined
                    clear-icon="close"
                    clearable
                    type="tel"
                    mask="(##) ####-####"
                    :rules="[isPhoneNumber, notLessThanNormal, notMoreThanNormal]"
                  />
                </div>
                <div class="col-12">
                  <q-input
                    v-model="contact.institutional_email"
                    label="Email Institucional"
                    outlined
                    clear-icon="close"
                    clearable
                    type="email"
                    :rules="[isEmail]"
                  />
                </div>
              </q-card-section>
              <q-card-actions>
                <q-btn outlined label="Cancelar" color="red" v-close-popup style="float: left !important; margin-left:10px;" />
                <q-btn outlined label="Salvar" color="green" @click="salvarDadosContato" v-close-popup style="float: right !important;" />
              </q-card-actions>
            </q-card>
          </q-dialog>
          <!-- fim da modal -->
          <div class="col-sm-12 q-pt-sm">
            <q-card class="my-card">
              <q-card-section>
                <div class="text-h6">
                  <q-icon name="sym_o_work" color="primary"/> Profissionais
                  <q-btn class="bg-primary text-caption text-white" @click="updateColaboradorData" style="float: right;">
                    <font-awesome-icon :icon="['far', 'pen-to-square']" />
                    <q-tooltip
                      class="bg-primary text-caption outline"
                      :offset="[10, 10]"
                      style="max-width: 600px">
                        Editar informações de profissionais.
                    </q-tooltip>
                  </q-btn>
                </div>
              </q-card-section>
              <q-card-section>
                <div class="row" v-if="professional.id">
                  <div class="col-sm-6 q-pa-xs" v-if="professional.lotacao">
                    <span class="text-grey">Lotação</span> {{ professional.lotacao }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="professional.superintendencia">
                    <span class="text-grey">Superintendência</span> {{ professional.superintendencia }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="professional.protecao_social_basica">
                    <span class="text-grey">Diretorias</span> {{ professional.protecao_social_basica }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="professional.protecao_social_especial">
                    <span class="text-grey">Diretoria</span> {{ professional.protecao_social_especial }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="professional.vigilancia_capacitacao">
                    <span class="text-grey">Diretorias</span> {{ professional.vigilancia_capacitacao }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="professional.vinculo_empregaticio">
                    <span class="text-grey">Vínculo Empregatício</span> {{ professional.vinculo_empregaticio }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="professional.funcao">
                    <span class="text-grey">Função</span> {{ professional.funcao }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="professional.diretoria_regional_des_social">
                    <span class="text-grey">Diretoria Regional DES Social</span> {{ professional.diretoria_regional_des_social }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="professional.creas_regional">
                    <span class="text-grey">CREAS Regional</span> {{ professional.creas_regional }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="professional.exe_creas_funcao">
                    <span class="text-grey">Exe CREAS - Função</span> {{ professional.exe_creas_funcao }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="professional.exe_creas_vinc_empreg">
                    <span class="text-grey">Exe CREAS - Vinculo Empregaticio</span> {{ professional.exe_creas_vinc_empreg }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="professional.outros_publicos">
                    <span class="text-grey">Outros públicos</span> {{ professional.outros_publicos }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="professional.outros_publicos_others">
                    <span class="text-grey">Outros públicos</span> {{ professional.outros_publicos_others }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="professional.parceiros">
                    <span class="text-grey">Parceiros</span> {{ professional.parceiros }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="professional.orgao">
                    <span class="text-grey">Orgão</span> {{ professional.orgao }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="professional.area_de_atuacao">
                    <span class="text-grey">Área de Atuação</span> {{ professional.area_de_atuacao }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="professional.protecao_social_basica_municipal">
                    <span class="text-grey">Proteção Social Básica Municipal</span> {{ professional.protecao_social_basica_municipal }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="professional.beneficios_socioassistenciais">
                    <span class="text-grey">Beneficios Socio Assistenciais</span> {{ professional.beneficios_socioassistenciais }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="professional.protecao_social_especial_municipal">
                    <span class="text-grey">Diretoria Municipal</span> {{ professional.protecao_social_especial_municipal }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="professional.social_especial_municipal_media_complexidade">
                    <span class="text-grey">Social Especial Municipal Média Complexidade</span> {{ professional.social_especial_municipal_media_complexidade }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="professional.social_especial_municipal_alta_complexidade">
                    <span class="text-grey">Social Especial Municipal Alta Complexidade</span> {{ professional.social_especial_municipal_alta_complexidade }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="professional.representacao == '1'">
                    <span class="text-grey">Representação</span> Sim
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="professional.area_representada">
                    <span class="text-grey">Área Representada</span> {{ professional.area_representada }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="professional.area_representada_outros">
                    <span class="text-grey">Área Representada Outros</span> {{ professional.area_representada_outros }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="professional.representante">
                    <span class="text-grey">Representação</span> {{ professional.representante }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="professional.representacao_titularidade">
                    <span class="text-grey">Titularidade</span> {{ professional.representacao_titularidade }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="professional.representacao_segmento">
                    <span class="text-grey">Segmento</span> {{ professional.representacao_segmento }}
                  </div>
                  <div class="col-sm-6 q-pa-xs" v-if="professional.cargo">
                    <span class="text-grey">Cargo</span> {{ professional.cargo }}
                  </div>
                </div>
                <div class="row" v-if="!professional.id">
                  Não Cadastrado
                </div>
              </q-card-section>
            </q-card>
          </div>
        </div>
      </div>
    </div>
  </q-page>
</template>

<script>
import { ref } from 'vue'
import accountMixin from "../../mixins/accountMixin";
import axios from "axios";
import Swal from 'sweetalert2'

export default {
  setup () {
    return {
      tab: ref('dados_pessoais'),
      modalDadosResidenciais: ref(false),
      modalDadosContato: ref(false),
      modalDadosPessoais: ref(false)
    }
  },
  name: "ViewPageUser",
  mixins: [accountMixin],
  data() {
    return {
      UserId: this.$route.params.id,
      user: [],
      contact: {
        email: "",
        phone: "",
        cell_phone: "",
        institutional_phone: "",
        institutional_email: "",
        cell_phone_whatsapp: [],
        error: false,
        checkZip: "1"
      },
      personal: [],
      professional: [],
      address: {
        zip_code: null,
        street: null,
        number: null,
        complement: null,
        neighborhood: null,
        city: null,
        state: null,
      },
      stateFiltered: [],
      stateList: [
        "AC",
        "AL",
        "AP",
        "AM",
        "BA",
        "CE",
        "DF",
        "ES",
        "GO",
        "MA",
        "MT",
        "MS",
        "MG",
        "PA",
        "PB",
        "PR",
        "PE",
        "PI",
        "RJ",
        "RN",
        "RS",
        "RO",
        "RR",
        "SC",
        "SP",
        "SE",
        "TO",
      ],
      baseUrlViaCep: "https://viacep.com.br/ws/",
    };
  },
  methods: {
    async getUserData() {
      try {
        const { data, status } = await this.apiUser(this.UserId, 'users');
        console.log(data);
        if (data) {
          this.user = data;
          this.user.servico = 'Municipal';
          if (data.service == 1) {
            this.user.servico = 'Estadual';
          }
          this.getSecretary(data.secretary);
          this.getUserPersonal();
          this.getUserContact();
          this.getUserAddress();
          this.getUserProfessionals();
        }
        if (status !== 200) {
          this.$q.notify({
            message: 'Nao Encontrado',
            color: "negative",
            position: "top",
          });
        }
      } catch (error) {
        this.$q.notify({
          message: error.message,
          color: "negative",
          position: "top",
        });
      }
    },
    async getUserPersonal() {
      try {
        const { data, status } = await this.apiUser(this.UserId, 'personal');
        if (data) { this.personal = data; }
        if (status !== 200) { console.warn('Error personal'); }
      } catch (error) {
        this.$q.notify({
          message: error.message,
          color: "negative",
          position: "top",
        });
      }
    },
    async getUserContact() {
      try {
        const { data, status } = await this.apiUser(this.UserId, 'contact');
        if (data) { this.contact = data; }
        if (status !== 200) { console.warn('Error contact'); }
      } catch (error) {
        this.$q.notify({
          message: error.message,
          color: "negative",
          position: "top",
        });
      }
    },
    async getUserAddress() {
      try {
        const { data, status } = await this.apiUser(this.UserId, 'address');
        if (data) { this.address = data; }
        if (status !== 200) { console.warn('Error address'); }
      } catch (error) {
        this.$q.notify({
          message: error.message,
          color: "negative",
          position: "top",
        });
      }
    },
    async getUserProfessionals() {
      try {
        const { data, status } = await this.apiUser(this.UserId, 'professionals');
        if (data) { this.professional = data; }
        if (status !== 200) { console.warn('Error professional'); }
      } catch (error) {
        this.$q.notify({
          message: error.message,
          color: "negative",
          position: "top",
        });
      }
    },
    async getSecretary(id) {
      try {
        const { data, status } = await this.apiGlobal(`ambitoatuacao/show/${id}`);
        if (data) { this.user.secretaria = data.nome; }
        if (status !== 200) { console.warn('Error secretaria'); }
      } catch (error) {
        this.$q.notify({
          message: error.response.data.message,
          color: "negative",
          position: "top",
        });
      }
    },
    async getAddressByZipCode() {
      try {
        this.$q.loading.show({
          message: 'Buscando endereço',
          backgroundColor: 'indigo',
        });
        const { data, status } = await axios.get(`${this.baseUrlViaCep}${this.addressData.zip_code}/json/`);
        if (status === 200) {
          this.addressData.street = data.logradouro;
          this.addressData.neighborhood = data.bairro;
          this.addressData.complement = data.complemento;
          this.addressData.city = data.localidade;
          this.addressData.state = data.uf;
          this.$refs.number.focus();
          this.$q.loading.hide();
        }
      } catch (error) {
        console.log(error);
        this.$q.loading.hide();
      }
    },
    async salvarDadosEndereco() {

    },
    async salvarDadosContato() {

    },
    async salvarDadosPessoais() {

    },
    voltarPagina() {
      // limpando os dados do usuario
      // para garantir que não haja cache
      this.user = [];
      // voltando a pagina de parceiros
      this.$router.push({ name: "Users" });
    },
    isRequired(value) {
      return !!value || "Campo obrigatório";
    },
    isNumber(value) {
      return ( (value && /^\d+$/.test(value)) || "Somente números" );
    },
    onStateFilter(val, update) {
      if (val === "") {
        update(() => {
          this.stateFiltered = this.stateList;
        });
      }
      update(() => {
        const needle = val.toLowerCase();
        this.stateFiltered = this.stateList.filter((v) =>
        v.toLowerCase().includes(needle)
        );
      });
    },
    isCellPhoneNumber(value) {
      return ((value && /^\(\d{2}\) \d \d{4}-\d{4}$/.test(value)) || "Não permitido outros caracteres");
    },
    isPhoneNumber(value) {
      return ((value && /^\(\d{2}\) \d{4}-\d{4}$/.test(value)) || "Não permitido outros caracteres");
    },
    isNumber(value) {
      return ((value && /^\d+$/.test(value)) || "Somente números");
    },
    notLessThanNormal(value) {
      return ((value && value.length <= 14) || "Máximo de 14 caracteres");
    },
    notLessThan(value) {
      return ((value && value.length <= 17) || "Máximo de 17 caracteres");
    },
    notMoreThan(value) {
      return ((value && value.length >= 11) || "Mínimo de 11 caracteres");
    },
    notMoreThanNormal(value) {
      return ((value && value.length >= 14) || "Mínimo de 14 caracteres");
    },
    isEmail(value) {
      return ((value && /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)) || "E-mail deve ser válido");
    },
  },  
  created() {
    this.getUserData();
  },
  watch: {
    form: {
      handler() {
        this.$emit("address", this.address);
        this.$emit("contact", this.contact);
      },
      deep: true,
    },
  },
}
</script>
<style lang="sass" scoped>
  .my-card
      width: 100%
  .column > div
      padding: 10px 15px
      background: rgba(86, 61, 124, .15)
      border: 1px solid rgba(86, 61, 124, .2)
  .column + .column
      margin-top: 1rem
</style>