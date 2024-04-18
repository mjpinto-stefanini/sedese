<template>
    <q-card flat>
        <q-card-section>
            <div class="row q-col-gutter-md">
                <div class="col-8">
                    <q-input
                        v-model="form.name"
                        for="name"
                        label="Nome e sobrenome"
                        name="name"
                        outlined
                        clear-icon="close"
                        clearable
                        :rules="[isRequired]"
                        v-on:keypress="onlyLetter($event)"
                    />
                </div>
                <div class="col-4">
                    <q-input outlined v-model="form.birthday" label="Data de Nascimento" mask="##/##/####" :rules="[isRequired]" :autofocus="true">
                        <template v-slot:append>
                            <q-icon name="event" class="cursor-pointer">
                                <q-popup-proxy>
                                    <q-date v-model="form.birthday" mask="DD/MM/YYYY" :rules="[isRequired]"></q-date>
                                </q-popup-proxy>
                            </q-icon>
                        </template>
                    </q-input>
                </div>
                <div class="col-12">
                    <q-toggle v-model="checkSocialName"
                        >Nome social
                        <q-icon name="sym_o_info" size="1.2rem" color="primary">
                            <q-tooltip
                                class="bg-primary text-caption"
                                style="max-width: 600px"
                            >
                                Nome Social: designação pela qual a pessoa travesti ou
                                transexual se identifica e é socialmente reconhecida. (Conforme
                                Art.1° do DECRETO Nº 8.727, DE 28 DE ABRIL DE 2016)
                            </q-tooltip>
                        </q-icon></q-toggle
                    >
                </div>
                <div class="col-12" v-if="checkSocialName">
                    <q-input
                        v-model="form.socialName"
                        label="Nome Social"
                        name="socialName"
                        for="socialName"
                        outlined
                        clear-icon="close"
                        clearable
                        :rules="[isRequired]"
                        v-on:keypress="onlyLetter($event)"
                    />
                </div>
                <div class="col-12 row">
                    <div :class="activeGenderIdentityOthers ? 'col-4' : 'col-12'">
                        <q-select
                            v-model="form.genderIdentity"
                            :options="genderIdentityList"
                            label="Identidade de genero"
                            name="genderIdentity"
                            for="genderIdentity"
                            outlined
                            clear-icon="close"
                            clearable
                            :rules="[isRequired]"
                        >
                            <template v-slot:prepend>
                                <q-icon name="sym_o_info" size="1.2rem" color="primary">
                                    <q-tooltip
                                        class="bg-primary text-caption"
                                        :offset="[10, 10]"
                                        style="max-width: 600px"
                                    >
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
                    <div class="col-8 q-pl-sm" v-if="activeGenderIdentityOthers">
                        <q-input
                            v-model="form.genderIdentityOthers"
                            name="genderIdentityOthers"
                            for="genderIdentityOthers"
                            label="Outros"
                            outlined
                            clear-icon="close"
                            clearable
                            :rules="[isRequired]"
                        />
                    </div>
                </div>
                <div class="col-5">
                    <q-input
                        v-model="form.RG"
                        name="RG"
                        label="Numero do RG"
                        outlined
                        mask="##############################"
                        clear-icon="close"
                        clearable
                        :rules="[isNumber]"
                    />
                </div>
                <div class="col-4">
                    <q-input
                        v-model="form.issuingBody"
                        label="Orgão emissor"
                        name="issuingBody"
                        outlined
                        clear-icon="close"
                        clearable
                        :rules="[isLetter]"
                    />
                </div>
                <div class="col-3">
                    <q-select
                        v-model="form.uf"
                        :options="ufFiltered"
                        label="UF"
                        name="uf"
                        outlined
                        use-input
                        input-debounce="0"
                        @filter="onUfFilter"
                        :rules="[isLetter]"
                    />
                </div>
                <div class="col-12">
                    <q-select
                        v-model="form.education"
                        :options="educationFiltered"
                        name="education"
                        for="education"
                        label="Escolaridade"
                        outlined
                        use-input
                        input-debounce="0"
                        @filter="onEducationFilter"
                        clear-icon="close"
                        clearable
                        :rules="[isRequired]"
                    />
                </div>
                <div class="col-12">
                    <q-select
                        v-model="form.profession"
                        :options="professionFiltered"
                        label="Profissão"
                        name="profession"
                        for="profession"
                        outlined
                        use-input
                        input-debounce="0"
                        @filter="onProfessionFilter"
                        clear-icon="close"
                        clearable
                        :rules="[isRequired]"
                    />
                </div>
                <div class="col-12" v-if="form.profession === 'Outros'">
                    <q-input
                        v-model="form.profissionOthers"
                        placeholder="Informe a outra profissão"
                        name="profissionOthers"
                        for="profissionOthers"
                        outlined
                        counter
                        maxlength="60"
                        clear-icon="close"
                        clearable
                        :rules="[isRequired]"
                    />
                </div>
                <div class="col-12">
                    <q-toggle v-model="isDeficiency" label="Possui alguma deficiência" />
                </div>
                <div class="col-12 row" v-if="isDeficiency">
                    <div :class="activeDeficiencyOthers ? 'col-4' : 'col-12'">
                        <q-select
                            v-model="form.deficiency"
                            name="deficiency"
                            for="deficiency"
                            :options="deficiencyFiltered"
                            label="Tipo de deficiência"
                            outlined
                            use-input
                            input-debounce="0"
                            @filter="onDeficiencyFilter"
                            clear-icon="close"
                            clearable
                            :rules="[isRequired]"
                        />
                    </div>
                    <div class="col-12" v-if="form.deficiency === 'Outros'">
                        <q-input
                            v-model="form.deficiencyOthers"
                            name="deficiencyOthers"
                            for="deficiencyOthers"
                            placeholder="informe o outro tipo de deficiência"
                            outlined
                            counter
                            maxlength="30"
                            clear-icon="close"
                            clearable
                            :rules="[isRequired]"
                        />
                    </div>
                </div>
                <div class="col-12 row" v-if="isDeficiency">
                    <div class="col-12">
                        <q-toggle
                            v-model="isDeficiencyStructure"
                            label="Necessita de estrutura para participar da ação?"
                        />
                    </div>
                    <div class="col-12 q-pl-sm" v-if="isDeficiencyStructure" style="margin-left: -0.5em; margin-top: 1em;">
                        <q-input
                            v-model="form.deficiencyStructure"
                            placeholder="informe caso precise de uma estrutura de acesso."
                            outlined
                            name="deficiencyStructure"
                            for="deficiencyStructure"
                            counter
                            maxlength="200"
                            clear-icon="close"
                            clearable
                            :rules="[isRequired]"
                        />
                    </div>
                </div>
            </div>
        </q-card-section>
    </q-card>
</template>

<script>
export default {
    name: "PersonalData",
    data() {
        return {
            genderIdentity: "",
            deficiency: "",
            form: {
                name: "",
                birthday:"",
                socialName: "",
                genderIdentity: "",
                genderIdentityOthers: "",
                RG: "",
                issuingBody: "",
                uf: "",
                education: "",
                profession: "",
                profissionOthers: "",
                isDeficiency: false,
                deficiency: "",
                deficiencyOthers: "",
                deficiencyStructure: "",
                type_admin: "",
                is_admin: false,
                is_active: false,
                erroValidacao: "",
            },
            genderIdentityList: [
                "Homem (cis ou trans)",
                "Mulher (cis ou trans)",
                "Não binário",
                "Outros",
            ],
            educationList: [
                "Ensino Fundamental Completo",
                "Ensino Fundamental Incompleto",
                "Ensino Médio Completo",
                "Ensino Médio Incompleto",
                "Superior Completo",
                "Superio Incompleto",
                "Pós-Graduação Lato-Sensu Completa",
                "Pós-Graduação Lato-Sensu Incompleta",
                "Mestrado Completo",
                "Mestrado Incompleto",
                "Doutorado Completo",
                "Doutorado Incompleto",
                "Curso Técnico",
            ],
            educationFiltered: [],
            professionList: [
                "Assistente Social",
                "Psicólogo",
                "Advogado",
                "Administrador",
                "Antropólogo",
                "Economista",
                "Empregada Doméstico",
                "Pedagogo",
                "Sociólogo",
                "Terapeuta",
                "Terapeuta Ocupacional",
                "Musicoterapeuta",
                "Contador",
                "Estudante",
                "Sem formação Profissional",
                "Outros",
            ],
            professionFiltered: [],
            isDeficiency: false,
            isDeficiencyStructure: false,
            deficiencyList: [
                "Auditiva",
                "Física",
                "Intelectual",
                "Transtorno do Espectro;",
                "Mental",
                "Visual",
                "Multipla",
                "Autista",
                "Outros",
            ],
            deficiencyFiltered: [],
            checkSocialName: false,
            ufFiltered: [],
            ufList: [
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
        inputValue: "",
        ignoredValue: "",

        };
    },
    methods: {
        isRequired(value) {
            return !!value || "Campo obrigatório";
        },
        isNumber(value) {
            if(value){
                return (
                    (!!value && /^[\d.-]+$/.test(value)) || "Somente números"
                );
            }

        },
        onlyLetter(e) {
            let char = String.fromCharCode(e.keyCode);
            if (/^[A-Za-z\s]+$/.test(char)) {
                return true;
            } else {
                e.preventDefault();
            }
        },
        isLetter(value) {
            if(value){
                return (
                    (!!value && /^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/.test(value)) || "Somente letras"
                );
            }
        },
        isMax12(value) {
            this.erroValidacao = "Corrija as informações inseridas"
            return (
                (!!value && value.length <= 12) || "Máximo de 12 caracteres"
            );
        },
        parseStringFilter(text) {
        const er = /[^a-z0-9]/gi;
        return text
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .replace(er, "")
            .toLowerCase();
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
    },
    computed: {
        activeProfissionOthers() {
            return this.profession === "Outros";
        },
        activeDeficiencyOthers() {
            return this.deficiency === "Outros";
        },
        activeGenderIdentityOthers() {
            return this.genderIdentity === "Outros";
        },
    },
    watch: {
        form: {
            handler() {
                this.$emit("personal", this.form);
            },
            deep: true,
        }
    },
    created() {
        this.form.name = JSON.parse(localStorage.getItem("user")).name;
    }
};
</script>
