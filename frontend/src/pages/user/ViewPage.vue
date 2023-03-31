<template>
    <q-page class="bg-grey-1">
        <div class="q-pa-md">
            <q-card class="my-card">
                <q-card-section>
                    <div class="text-h6">
                        {{ user.name }}
                        <q-chip dense size="sm"
                            :text-color="user.is_active ? 'white' : 'dark'"
                            :label="user.is_active ? 'Ativado' : 'Desativado'"
                            :color="user.is_active ? 'green' : 'gray'"
                        />
                    </div>
                    <div class="text-weight-thin">{{ user.email }}</div>
                </q-card-section>

                <q-tabs v-model="tab" class="text-primary">
                    <q-tab class="col-sm-3" label="Dados Pessoais" icon="sym_o_person" name="dados_pessoais" />
                    <q-tab class="col-sm-3" label="Residenciais"  icon="sym_o_home_work" name="residenciais" />
                    <q-tab class="col-sm-3" label="Contato"  icon="sym_o_call" name="contato" />
                    <q-tab class="col-sm-3" label="Profissionais"  icon="sym_o_work" name="profissionais" />
                </q-tabs>

                <q-separator />

                <q-tab-panels v-model="tab" animated>
                    <q-tab-panel name="dados_pessoais">
                        <div class="row">
                            <div class="col-sm-4 q-pa-xs">
                                <b>Ambito de Atuação</b> {{ user.servico }}
                            </div>
                            <div class="col-sm-8 q-pa-xs">
                                <b>Secretaria</b> {{ user.secretaria }}
                            </div>
                            <div class="col-sm-4 q-pa-xs">
                                <b>Nome</b> {{ user.name }}
                            </div>
                            <div class="col-sm-4 q-pa-xs" v-if="personal.social_name">
                                <b>Nome Social</b> {{ personal.social_name }}
                            </div>
                            <div class="col-sm-4 q-pa-xs">
                                <b>Identidade de Gênero</b> {{ personal.gender_identity }}
                            </div>
                            <div class="col-sm-4 q-pa-xs" v-if="personal.social_name">
                                <b>Nome Social</b> {{ personal.social_name }}
                            </div>
                            <div class="col-sm-4 q-pa-xs">
                                <b>CPF</b> {{ user.cpf }}
                            </div>
                            <div class="col-sm-4 q-pa-xs">
                                <b>RG</b> {{ personal.rg }}
                            </div>
                            <div class="col-sm-4 q-pa-xs">
                                <b>Orgão emissor</b> {{ personal.issuing_body }}
                            </div>
                            <div class="col-sm-4 q-pa-xs">
                                <b>UF</b> {{ personal.uf }}
                            </div>
                            <div class="col-sm-4 q-pa-xs">
                                <b>Escolaridade</b> {{ personal.education }}
                            </div>
                            <div class="col-sm-4 q-pa-xs" v-if="personal.profission !== 'Outros'">
                                <b>Profissão</b> {{ personal.profission }}
                            </div>
                            <div class="col-sm-4 q-pa-xs" v-if="personal.profission === 'Outros'">
                                <b>Profissão</b> {{ personal.profission_others }}
                            </div>
                            <div class="col-sm-4 q-pa-xs" v-if="personal.is_deficiency">
                                <b>Deficiência</b> <span v-if="personal.deficiency !== 'Outros'"> {{ personal.deficiency }}</span><span v-if="personal.deficiency === 'Outros'"> {{ personal.deficiency_others }}</span>
                            </div>
                            <div class="col-sm-4 q-pa-xs" v-if="personal.deficiency_structure">
                                <b>Necessita de estrutura para participar da ação?</b> {{ personal.deficiency_structure }}
                            </div>

                        </div>
                    </q-tab-panel>
                    <q-tab-panel name="residenciais">
                        <div class="row">
                            <div class="col-sm-4 q-pa-xs">
                                <b>CEP</b> {{ address.zip_code }}
                            </div>
                            <div class="col-sm-4 q-pa-xs">
                                <b>Logradouro</b> {{ address.street }}
                            </div>
                            <div class="col-sm-4 q-pa-xs">
                                <b>Número</b> {{ address.number }}
                            </div>
                            <div class="col-sm-4 q-pa-xs">
                                <b>Bairro</b> {{ address.neighborhood }}
                            </div>
                            <div class="col-sm-4 q-pa-xs" v-if="address.complement">
                                <b>Complemento</b> {{ address.complement }}
                            </div>
                            <div class="col-sm-4 q-pa-xs">
                                <b>Cidade</b> {{ address.city }}
                            </div>
                            <div class="col-sm-4 q-pa-xs">
                                <b>UF</b> {{ address.state }}
                            </div>
                        </div>
                    </q-tab-panel>

                    <q-tab-panel name="contato">
                        <div class="row">
                            <div class="col-sm-4 q-pa-xs">
                                <b>E-mail</b> {{ user.email }}
                            </div>
                            <div class="col-sm-4 q-pa-xs" v-if="contact.phone">
                                <b>Telefone Residencial</b> {{ contact.phone }}
                            </div>
                            <div class="col-sm-4 q-pa-xs" v-if="contact.cell_phone">
                                <b>Celular</b> {{ contact.cell_phone }} - Whatsapp {{ contact.cell_phone_whatsapp }}
                            </div>
                            <div class="col-sm-4 q-pa-xs" v-if="contact.institutional_phone">
                                <b>Telefone Institucional</b> {{ contact.institutional_phone }}
                            </div>
                            <div class="col-sm-4 q-pa-xs" v-if="contact.institutional_email">
                                <b>E-mail Institucional</b> {{ contact.institutional_email }}
                            </div>
                        </div>
                    </q-tab-panel>

                    <q-tab-panel name="profissionais">
                        <div class="row">
                            <div class="col-sm-4 q-pa-xs">
                                <b>Região Administrativa</b> {{ professional.regional }}
                            </div>
                            <div class="col-sm-4 q-pa-xs">
                                <b>Lotação</b> {{ professional.lotacao }}
                            </div>
                            <div class="col-sm-4 q-pa-xs">
                                <b>Unidade</b> {{ professional.lotacao }}
                            </div>

                        </div>


                         {{ professional }}
                         ----------
                        id: "b2675665-6bbe-407f-acd0-ac03d40c6fa3",
user_id: "a877492c-e482-44b9-bdb2-45466bf482a2",

superintendencia: "",

protecao_social_basica: null,
protecao_social_especial: null,
vigilancia_capacitacao: null,
vinculo_empregaticio: "Temporário",
funcao: "Assessor(a)",
diretoria_regional_des_social: null,
creas_regional: null,
exe_creas_funcao: null,
exe_creas_vinc_empreg: null,
outros_publicos: null,
outros_publicos_others: null,
parceiros: null,
orgao: null,
area_de_atuacao: null,
protecao_social_basica_municipal: null,
beneficios_socioassistenciais: null,
protecao_social_especial_municipal: null,
social_especial_municipal_media_complexidade: null,
social_especial_municipal_alta_complexidade: null,
representacao: null,
area_representada: null,
area_representada_outros: null,
cargo: null,
created_at: "2023-03-23T15:29:49.000000Z",
updated_at: "2023-03-23T15:29:49.000000Z"
                    </q-tab-panel>


                </q-tab-panels>
            </q-card>
        </div>
    </q-page>

</template>

<script>
import { ref } from 'vue'

export default {
    setup () {
        return {
            tab: ref('dados_pessoais')
        }
    },
    name: "ViewPageUser",
    data() {
        console.log('this.$route.params.id', this.$route.params.id);
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
                const { data, status } = await this.$http.get(`${this.baseURL}users/${this.UserId}/user`);

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
                const { data, status } = await this.$http.get(`${this.baseURL}personal/${this.UserId}/user`);
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
                const { data, status } = await this.$http.get(`${this.baseURL}contact/${this.UserId}/user`);

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
                const { data, status } = await this.$http.get(`${this.baseURL}address/${this.UserId}/user`);

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
                const { data, status } = await this.$http.get(`${this.baseURL}professionals/${this.UserId}/user`);

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
                const { data, status } = await this.$http.get(`ambitoatuacao/show/${id}`);
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
/*
const User = {
    template: '<div>User {{ $route.params.id }}</div>',
}
*/
/*
import AcaoData from "../components/form_acoes/AcaoData.vue";
import PoloData from "@/components/form_acoes/PoloData.vue";
import TurmaData from "@/components/form_acoes/TurmaData.vue";
export default {
    name: "NewActionPage",
    data() {
        return {
            step: 1,
            acaoData: {},
            poloData: {},
            turmaData: {},
            jsonData: "",
        };
    },
    computed: {
        finalData() {
            let jsonData = {
                acao: this.acaoData,
                polo: this.poloData,
                turma: this.turmaData,
            };
            return jsonData;
        },
    },
    methods: {
        setData() {
            this.jsonData = {
                acao: this.acaoData,
                polo: this.poloData,
                turma: this.turmaData,
            };
        },
        async sendForm() {
            const values = {
                acao: { ...this.acaoData},
                polo: { ...this.poloData},
                turma: { ...this.turmaData},
            };

            try {
                const user_id = JSON.parse(localStorage.getItem("user")).id;
                const { status, data } = await this.$http.patch(
                  `users/${user_id}/secondstage`,
                  values
                );
                if (status === 201 || status === 200) {
                    this.$q.notify({
                        message: "Dados salvos com sucesso!",
                        color: "positive",
                        position: "top",
                    });
                    console.log(data);
                }
            }   catch (error) {
                this.$q.notify({
                    message: error.response.data.message,
                    color: "negative",
                    position: "top",
                });
            }
        },
    },
    watch: {
        personalData: {
            handler() {
                // this.setData();
                console.log("personalData");
            },
            deep: true,
        },
        addressData: {
            handler() {
                this.setData();
            },
            deep: true,
        },
        contactData: {
            handler() {
                this.setData();
            },
            deep: true,
        },
        representationData: {
            handler() {
                this.setData();
            },
            deep: true,
        },
        professionalData: {
            handler() {
                this.setData();
            },
            deep: true,
        },
    },

    components: {
        AcaoData,
        PoloData,
        TurmaData,
    },
};
*/
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