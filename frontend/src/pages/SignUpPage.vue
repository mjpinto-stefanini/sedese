<template>
    <q-page class="flex flex-center bg-grey-1">
        <q-form @submit="onRegister">
            <q-card flat bordered style="width: 448px" class="q-pa-md">
                <q-card-section>
                    <div class="text-h5 text-center">Criar conta</div>
                </q-card-section>

                <q-card-section class="q-gutter-sm">
                    <q-select
                        outlined
                        v-model="form.service"
                        :options="services"
                        label="Ambito de Atuação"
                        :rules="[isRequired]"
                        lazy-rules
                    >
                        <template v-slot:prepend>
                            <q-icon name="corporate_fare" class="cursor-pointer" />
                        </template>
                    </q-select>

                    <q-select
                        v-show="form.service.label !== null"
                        outlined
                        v-model="form.secretary"
                        :options="filterSecretaries"
                        :label="form.service.value === 2 ? 'Município' : 'Lotação'"
                        @filter="filterFn"
                        :rules="[isRequired]"
                        lazy-rules
                        use-input
                        input-debounce="0"
                    >
                        <template v-slot:prepend>
                            <q-icon name="mdi-domain" class="cursor-pointer" />
                        </template>

                        <template v-slot:no-option>
                            <q-item>
                                <q-item-section class="text-grey">
                                    Sem resultados!
                                </q-item-section>
                            </q-item>
                        </template>
                    </q-select>

                    <q-input
                        outlined
                        v-model="form.name"
                        label="Nome"
                        type="text"
                        :rules="[isRequired]"
                        lazy-rules
                        v-on:keypress="onlyLetter($event)"
                    >
                        <template v-slot:prepend>
                            <q-icon name="mdi-account-outline" class="cursor-pointer" />
                        </template>
                    </q-input>

                    <q-input
                        outlined
                        v-model="form.cpf"
                        label="CPF"
                        type="text"
                        :rules="[isRequired, isCpf]"
                        mask="###.###.###-##"
                        lazy-rules
                    >
                        <template v-slot:prepend>
                            <q-icon
                                name="mdi-card-account-details-outline"
                                class="cursor-pointer"
                            />
                        </template>
                    </q-input>

                    <q-input
                        outlined
                        autocomplete="off"
                        v-model="form.email"
            oncopy="return false" onpaste="return false" oncut="return false"
                        label="Email"
                        type="email"
                        :rules="[isRequired, isEmail]"
                        lazy-rules
                    >
                        <template v-slot:prepend>
                            <q-icon name="mdi-email-outline" class="cursor-pointer" />
                        </template>
                    </q-input>
                    <q-input
                        outlined
                        autocomplete="off"
                        v-model="form.email_confirmation"
            oncopy="return false" onpaste="return false" oncut="return false"
                        label="Email Confirmação"
                        type="email"
                        :rules="[isRequired, isEmail, emailMatch]"
                        lazy-rules
                    >
                        <template v-slot:prepend>
                            <q-icon name="mdi-email-outline" class="cursor-pointer" />
                        </template>
                    </q-input>

                    <q-input
                        outlined
                        autocomplete="off"
                        v-model="form.password"
                        lazy-rules
                        :rules="[isRequired]"
                        label="Senha"
                        :type="showPassword ? 'text' : 'password'"
                    >
                        <template v-slot:prepend>
                            <q-icon name="mdi-form-textbox-password" class="cursor-pointer" />
                        </template>
                        <template v-slot:append>
                            <q-icon
                                :name="showPassword ? 'mdi-eye-off-outline' : 'mdi-eye-outline'"
                                class="cursor-pointer"
                                @click="showPassword = !showPassword"
                            />
                        </template>
                    </q-input>
                    <q-input
                        outlined
                        autocomplete="off"
                        v-model="form.password_confirmation"
                        lazy-rules
                        :rules="[isRequired, passwordMatch]"
                        label="Confirmar sua Senha"
                        :type="showPassword ? 'text' : 'password'"
                    >
                        <template v-slot:prepend>
                            <q-icon name="mdi-form-textbox-password" class="cursor-pointer" />
                        </template>
                        <template v-slot:append>
                            <q-icon
                                :name="showPassword ? 'mdi-eye-off-outline' : 'mdi-eye-outline'"
                                class="cursor-pointer"
                                @click="showPassword = !showPassword"
                            />
                        </template>
                    </q-input>
                </q-card-section>
                <q-card-section class="q-pt-none">
                    <q-btn
                        label="Continuar"
                        color="primary"
                        class="full-width q-py-md q-mb-md"
                        no-caps
                        unelevated
                        type="submit"
                    />
                    <q-btn
                        label="Cancelar"
                        color="primary"
                        outline
                        class="full-width q-py-md"
                        no-caps
                        unelevated
                        to="signin"
                    />
                </q-card-section>
            </q-card>
        </q-form>
    </q-page>
</template>

<script>
import accountMixin from "../mixins/accountMixin";

export default {
    name: "SignUpPage",
    mixins: [accountMixin],
    data() {
        return {
            form: {
                from: 'cadastro',
                secretary: null,
                service: {
                    value: null,
                    label: null,
                },
                name: null,
                email: null,
                email_confirmation: null,
                password: null,
                password_confirmation: null,
            },
            showPassword: false,
            allSecretaries: [],
            filterSecretaries: [],
            services: [
                { label: "Estadual", value: 1 },
                { label: "Municipal", value: 2 },
            ],
        };
    },
    methods: {
        isRequired(value) {
            return !!value || "Campo obrigatório";
        },
        isCpf(cpf) {
            const validar = cpf => checkAll(prepare(cpf))

            const notDig = i => !['.', '-', ' '].includes(i)
            const prepare = cpf => cpf.trim().split('').filter(notDig).map(Number)
            const is11Len = cpf => cpf.length === 11
            const notAllEquals = cpf => !cpf.every(i => cpf[0] === i)
            const onlyNum = cpf => cpf.every(i => !isNaN(i))

            const calcDig = limit => (a, i, idx) => a + i * ((limit + 1) - idx)
            const somaDig = (cpf, limit) => cpf.slice(0, limit).reduce(calcDig(limit), 0)
            const resto11 = somaDig => 11 - (somaDig % 11)
            const zero1011 = resto11 => [10, 11].includes(resto11) ? 0 : resto11

            const getDV = (cpf, limit) => zero1011(resto11(somaDig(cpf, limit)))
            const verDig = pos => cpf => getDV(cpf, pos) === cpf[pos]

            const checks = [is11Len, notAllEquals, onlyNum, verDig(9), verDig(10)]
            const checkAll = cpf => checks.map(f => f(cpf)).every(r => !!r)

            return validar(cpf) || "Formato de CPF inválido";
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
        passwordMatch(value) {
            if (value !== this.form.password) {
                return "As senhas informadas não conferem, favor, preencher o campo novamente.";
            }
            return true;
        },
        onlyLetter(e) {
            let char = String.fromCharCode(e.keyCode);
            if (/^[A-Za-z\s]+$/.test(char)) {
                return true;
            } else {
                e.preventDefault();
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
        async onRegister() {
            try {
				this.$q.loading.show({
					message: 'Enviando...',
					backgroundColor: 'indigo',
                });

                const { status, message } = await this.$http.post("auth/register", this.form);
                if (status === 422) {
                    this.$q.notify({
                        message: message,
                        color: "negative",
                        position: "top",
                    });
                }

                if (status === 200 || status === 201) {
                    this.$q.notify({
                        progress: true,
                        //message: "Usuario registrado, em instantes você receberá um email com as instruções para ativar sua conta",
                        message: "Usuario registrado!",
                        type: "positive",
                    }, 5000);

                    if (this.form.secretary.label == 'Subsecretaria de Assistência Social' || this.form.secretary.label == 'Diretoria Regional de Desenvolvimento Social') {
                        this.$q.notify({
                            message: "Seu cadastro está pendente de confirmação. Quando for aprovado, você receberá um e-mail",
                            color: "info",
                            position: "top",
                        });
                    }
                    const { data, status } = await this.$http.post("auth/login", this.form);
                    if (status === 200 || status === 201) {
                        // antes de continuar com os dados cadastrais, é setado o usuárioe sua autenticação
                        localStorage.setItem("token", data.authorization.token);
                        localStorage.setItem("user", JSON.stringify(data.user));
                        this.$router.push({ name: "Main" });
                    }
                }
                this.$q.loading.hide();
            } catch (error) {
                this.$q.notify({
                    message: error.response.data.message,
                    color: "negative",
                    position: "top",
                });
            }
        },

        async getSecretaries() {
            try {
                const { data, status } = await this.$http.get(
                    `ambitoatuacao/regiaoadm/${
                        this.form?.service.value === 1 ? "1" : "2"
                    }`
                );
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
    },
    computed: {
    },
    watch: {
        'form.service'() {
            this.form.secretary = null;
            this.getSecretaries();
        }
    },
};
</script>