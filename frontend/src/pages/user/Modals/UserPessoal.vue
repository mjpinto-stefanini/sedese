<template>
    <q-dialog v-model="modalAbrir">
        <q-card style="width: 80%; max-width: 80vw;">
            <q-card-section>
                <h6 style="margin: 0; padding: 0;"><q-icon name="sym_o_person" color="primary" /> Editar Dados Pessoais
                </h6>
            </q-card-section>
            <q-card-section>
                <div class="row q-col-gutter-md">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <q-input v-model="user.name" for="name" label="Nome e sobrenome" name="name" outlined
                            clear-icon="close" clearable :rules="[isRequired]" v-on:keypress="onlyLetter($event)" />
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <q-input v-model="user.cpf" for="cpf" label="CPF" name="cpf" outlined clear-icon="close"
                            clearable mask="###.###.###-##" :rules="[isRequired]" />
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <q-input outlined v-model="user.birthday" label="Data de Nascimento">
                            <template v-slot:append>
                                <q-icon name="event" class="cursor-pointer">
                                    <q-popup-proxy>
                                        <q-date v-model="user.birthday" mask="DD/MM/YYYY"></q-date>
                                    </q-popup-proxy>
                                </q-icon>
                            </template>
                        </q-input>
                    </div>
                    <div class="col-12">
                        <q-toggle v-model="checkSocialName">
                            Nome social
                            <q-icon name="sym_o_info" size="1.2rem" color="primary">
                                <q-tooltip class="bg-primary text-caption" :offset="[10, 10]" style="max-width: 600px">
                                    Nome Social: designação pela qual a pessoa travesti ou
                                    transexual se identifica e é socialmente reconhecida. (Conforme
                                    Art.1° do DECRETO Nº 8.727, DE 28 DE ABRIL DE 2016)
                                </q-tooltip>
                            </q-icon>
                        </q-toggle>
                    </div>
                    <div class="col-12" v-if="checkSocialName">
                        <q-input v-model="user.social_name" label="Nome Social" name="socialName" for="socialName"
                            outlined clear-icon="close" clearable :rules="[isRequired]"
                            v-on:keypress="onlyLetter($event)" />
                    </div>
                    <div class="col-12 row">
                        <div class="col-12">
                            <q-select v-model="user.gender_identity" :options="parametros.genderIdentityList"
                                label="Identidade de genero" name="genderIdentity" for="genderIdentity" outlined
                                clear-icon="close" clearable :rules="[isRequired]">

                                <template v-slot:prepend>
                                    <q-icon name="sym_o_info" size="1.2rem" color="primary">
                                        <q-tooltip class="bg-primary text-caption" :offset="[10, 10]"
                                            style="max-width: 600px">
                                            Identidade de Gênero: dimensão da identidade de uma pessoa
                                            que diz respeito à forma como se relaciona com as
                                            representações de masculinidade e feminilidade e como isso
                                            se traduz em sua prática social, sem guardar relação
                                            necessária com o sexo atribuído no nascimento.(Conforme
                                            Art.1° do DECRETO Nº 8.727, DE 28 DE ABRIL DE 2016)
                                        </q-tooltip>
                                    </q-icon>
                                </template>
                            </q-select>
                        </div>
                        <div class="col-12" v-if="user.gender_identity === 'Outros'">
                            <q-input v-model="user.gender_identity_others" name="genderIdentityOthers"
                                for="genderIdentityOthers" label="Outros" outlined clear-icon="close" clearable
                                :rules="[isRequired]" />
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-12">
                        <q-input v-model="user.rg" name="RG" label="Numero do RG" outlined
                            mask="##############################" clear-icon="close" clearable :rules="[isNumber]" />
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <q-input v-model="user.issuing_body" label="Orgão emissor" name="issuingBody" outlined
                            clear-icon="close" clearable v-on:keypress="onlyLetter($event)" />
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <q-select v-model="user.uf" :options="ufList" label="UF" name="uf" outlined input-debounce="0"
                            @filter="onUfFilter" v-on:keypress="onlyLetter($event)" />
                    </div>
                    <div class="col-12">
                        <q-select v-model="user.education" :options="parametros.educationList" name="education"
                            for="education" label="Escolaridade" outlined use-input input-debounce="0"
                            @filter="onEducationFilter" clear-icon="close" clearable :rules="[isRequired]" />
                    </div>
                    <div class="col-12">
                        <q-select v-model="user.profission" :options="professionFiltered" label="Profissão"
                            name="profession" for="profession" outlined use-input input-debounce="0"
                            @filter="onProfessionFilter" clear-icon="close" clearable :rules="[isRequired]" />
                    </div>
                    <div class="col-12" v-if="user.profission === 'Outros'">
                        <q-input v-model="user.profission_others" placeholder="Informe a outra profissão"
                            name="profissionOthers" for="profissionOthers" outlined counter maxlength="60"
                            clear-icon="close" clearable :rules="[isRequired]" />
                    </div>
                    <div class="col-12">
                        <q-toggle v-model="isDeficiency" label="Possui alguma deficiência" />
                    </div>
                    <div class="col-12 row" v-if="isDeficiency">
                        <div class="col-12">
                            <q-select v-model="user.deficiency" name="deficiency" for="deficiency"
                                :options="deficiencyList" label="Tipo de deficiência" outlined
                                @filter="onDeficiencyFilter" clear-icon="close" clearable :rules="[isRequired]" />
                        </div>
                        <div class="col-12" v-if="user.deficiency === 'Outros'">
                            <q-input v-model="user.deficiency_others" name="deficiencyOthers" for="deficiencyOthers"
                                placeholder="informe o outro tipo de deficiência" outlined counter maxlength="30"
                                clear-icon="close" clearable :rules="[isRequired]" />
                        </div>
                    </div>
                    <div class="col-12 row" v-if="isDeficiency">
                        <div class="col-12">
                            <q-toggle v-model="isDeficiencyStructure"
                                label="Necessita de estrutura para participar da ação?" />
                        </div>
                        <div class="col-12 q-pl-sm" v-if="isDeficiencyStructure"
                            style="margin-left: -0.5em; margin-top: 1em;">
                            <q-input v-model="user.deficiency_structure"
                                placeholder="informe caso precise de uma estrutura de acesso." outlined
                                name="deficiencyStructure" for="deficiencyStructure" counter maxlength="200"
                                clear-icon="close" clearable :rules="[isRequired]" />
                        </div>
                    </div>
                </div>
            </q-card-section>
            <q-card-actions>
                <q-btn outlined label="Cancelar" color="red" @click="limparFiltrosPagina" v-close-popup
                    style="float: left !important; margin-left:10px;" />
                <q-btn outlined label="Salvar" color="green" @click="salvarDadosPessoais" v-close-popup
                    :disabled="!camposObrigatoriosDePessoalPreenchidos()" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script>
import * as parametros from '../../../mixins/parameters';
import { onlyLetter, isNumber, isRequired } from "../../../mixins/validates";
import ApiDataUser from "../../../mixins/users";
import accountMixin from "../../../mixins/accountMixin";

export default {
    name: "UserPessoalModal",
    props: {
        modalDadosPessoais: {
            type: Boolean,
            required: true,
        },
        dadosUser: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            parametros,
            modalAbrir: false,
            checkSocialName: false,
            isDeficiency: false,
            isDeficiencyStructure: false,
            ufList: parametros.stateList,
            educationList: parametros.educationList,
            professionList: parametros.professionList,
            deficiencyList: parametros.deficiencyList,
            ufFiltered: [],
            educationFiltered: [],
            professionFiltered: [],
            deficiencyFiltered: [],
        };
    },
    mixins: [accountMixin, ApiDataUser],
    watch: {
        modalDadosPessoais(newVal) {
            this.modalAbrir = newVal;
        },
        modalAbrir(newVal) {
            this.$emit('update:modalDadosPessoais', newVal);
        },
        dadosUser: {
            handler(newVal) {
                if (newVal.user) {
                    this.userData = newVal.user;
                    if (this.userData.social_name) {
                        this.checkSocialName = true;
                    }
                    if (this.userData.deficiency === 1) {
                        this.isDeficiency = true;
                    }
                    if (this.userData.deficiency_structure === 1) {
                        this.isDeficiencyStructure = true;
                    }
                }
            },
            deep: true,
            immediate: true
        }
    },
    computed: {
        user() {
            const userData = this.dadosUser.user || {};
            return userData;
        }
    },
    methods: {
        async salvarDadosPessoais() {
            if (!this.camposObrigatoriosDePessoalPreenchidos()) {
                this.$q.notify({
                    message: 'É necessário preencher todos os dados obrigatórios para salvar.',
                    color: 'negative',
                    position: 'top',
                });
            }
            let params = {
                'name': this.user.name,
                'birthday': this.user.birthday,
                'personal': this.user
            };
            params['personal']['user_id'] = this.user.id;

            try {
                const result = await this.$http.post('personal/updatebyuser', params);
                if (result.status === 200) {
                    this.$q.notify({
                        message: 'Dados do Usuário atualizado!',
                        color: "positive",
                        position: "top",
                    });
                    this.$router.go();
                }
            } catch (error) {
                this.validandoToken(error);
            }
        },
        camposObrigatoriosDePessoalPreenchidos() {
            const socialNameFilled = this.checkSocialName ? Boolean(this.user.social_name) : true;
            const deficiencyFilled = this.isDeficiency ? (Boolean(this.user.deficiency) && (!this.isDeficiencyStructure || Boolean(this.user.deficiency_structure))) : true;
            const genderIdentityOthersFilled = this.user.gender_identity === 'Outros' ? Boolean(this.user.gender_identity_others) : true;
            const profissionFilled = this.user.profission === 'Outros' ? Boolean(this.user.profission_others) : true;
            const personalFieldsFilled = Boolean(this.user.name) && Boolean(this.user.birthday) && Boolean(this.user.cpf) && Boolean(this.user.education);

            return socialNameFilled && deficiencyFilled && genderIdentityOthersFilled && profissionFilled && personalFieldsFilled;
        },
        limparFiltrosPagina() {
            this.$router.go();
        },
        activeProfissionOthers() {
            return this.user.profission === "Outros";
        },
        onlyLetter(value) {
            return onlyLetter(value);
        },
        isNumber(value) {
            return isNumber(value);
        },
        isRequired(value) {
            return isRequired(value);
        },
        onUfFilter(val, update) {
            if (val === "") {
                update(() => {
                    this.ufFiltered = this.ufList;
                });
            }
            update(() => {
                const needle = val.toLowerCase();
                this.ufFiltered = this.ufList.filter((v) =>
                    v.toLowerCase().includes(needle)
                );
            });
        },
        onEducationFilter(val, update) {
            if (val === "") {
                update(() => {
                    this.educationFiltered = this.educationList;
                });
            }
            update(() => {
                const needle = this.parseStringFilter(val);
                this.educationFiltered = this.educationList.filter((v) =>
                    this.parseStringFilter(v).includes(needle)
                );
            });
        },
        parseStringFilter(text) {
            const er = /[^a-z0-9]/gi;
            return text
                .normalize("NFD")
                .replace(/[\u0300-\u036f]/g, "")
                .replace(er, "")
                .toLowerCase();
        },
        onProfessionFilter(val, update) {
            if (val === "") {
                update(() => {
                    this.professionFiltered = this.professionList;
                });
            }
            update(() => {
                const needle = this.parseStringFilter(val);
                this.professionFiltered = this.professionList.filter((v) =>
                    this.parseStringFilter(v).includes(needle)
                );
            });
        },
        onDeficiencyFilter(val, update) {
            if (val === "") {
                update(() => {
                    this.deficiencyFiltered = this.deficiencyList;
                });
            }
            update(() => {
                const needle = this.parseStringFilter(val);
                this.deficiencyFiltered = this.deficiencyList.filter((v) =>
                    this.parseStringFilter(v).includes(needle)
                );
            });
        }
    }
}
</script>user