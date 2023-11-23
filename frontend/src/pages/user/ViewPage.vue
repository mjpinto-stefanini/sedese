<template>
    <q-page class="bg-grey-1">
        <div class="q-pa-md">
            <div class="row">
                <div class="col-sm-4 q-pa-xs">
                    <q-card class="my-card">
                        <q-card-section>
                            <div class="text-h6">
                                <q-icon name="sym_o_person" color="primary"/> {{ user.name }}
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
                </div>
                <div class="col-sm-8 q-pa-xs">
                    <div class="col-sm-12">
                        <q-card class="my-card">
                            <q-card-section>
                                <div class="text-h6">
                                    <q-icon name="sym_o_home_work" color="primary"/> Dados Residenciais
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
                    <div class="col-sm-12 q-pt-sm">
                        <q-card class="my-card">
                            <q-card-section>
                                <div class="text-h6">
                                    <q-icon name="sym_o_call" color="primary"/> Contato
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
                    <div class="col-sm-12 q-pt-sm">
                        <q-card class="my-card">
                            <q-card-section>
                                <div class="text-h6">
                                    <q-icon name="sym_o_work" color="primary"/> Profissionais
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

export default {
    setup () {
        return {
            tab: ref('dados_pessoais')
        }
    },
    name: "ViewPageUser",
	mixins: [accountMixin],
    data() {
        return {
            baseURL: process.env.VUE_APP_API_URL,
            UserId: this.$route.params.id,
            user: [],
            contact: [],
            personal: [],
            address: [],
            professional: [],
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
    },
	created() {
		this.getUserData();
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