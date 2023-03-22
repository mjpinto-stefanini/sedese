<template>
    <q-page class="flex flex-center bg-grey-1">
        <q-form @submit="onRecoverPassword">
            <q-card flat bordered style="width: 448px" class="q-pa-md">
                <q-card-section>
                    <div class="text-h5 text-center">Por favor insira sua nova senha</div>
                </q-card-section>
                <q-card-section class="q-gutter-sm">

                    <q-input
                      outlined
                      autocomplete="false"
                      v-model="form.password"
                      lazy-rules
                      :rules="[validPassword, val => !!val || 'Por favor insira sua nova senha']"
                      label="Nova Senha"
                      :type="form.showPasswordNew ? 'text' : 'password'"
                    >
                        <template v-slot:prepend>
                            <q-icon name="mdi-form-textbox-password" class="cursor-pointer" />
                        </template>
                        <template v-slot:append>
                            <q-icon
                              :name="form.showPasswordNew ? 'mdi-eye-off-outline' : 'mdi-eye-outline'"
                              class="cursor-pointer"
                              @click="form.showPasswordNew = !form.showPasswordNew"
                            />
                        </template>
                    </q-input>

                    <q-input
                      outlined
                      autocomplete="false"
                      v-model="form.confirmPassword"
                      lazy-rules
                      :rules="[validPassword, val => !!val || 'Por favor confirme sua nova senha', val => val === form.password || 'As senhas não coincidem']"
                      label="Confirme sua nova senha"
                      :type="form.showPasswordConfirm ? 'text' : 'password'"
                    >
                        <template v-slot:prepend>
                            <q-icon name="mdi-form-textbox-password" class="cursor-pointer" />
                        </template>
                        <template v-slot:append>
                            <q-icon
                              :name="form.showPasswordConfirm ? 'mdi-eye-off-outline' : 'mdi-eye-outline'"
                              class="cursor-pointer"
                              @click="form.showPasswordConfirm = !form.showPasswordConfirm"
                            />
                        </template>
                    </q-input>

                </q-card-section>
                <q-card-section class="q-pt-none">
                    <q-btn
                      label="Enviar"
                      color="primary"
                      class="full-width q-py-md q-mb-md"
                      no-caps
                      :loading="form.loadingRecoverPassword"
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
//import axios from 'axios';
import accountMixin from "../mixins/accountMixin";
export default {
    name: "RecoverPasswordPage",
    mixins: [accountMixin],
    data() {
        return {
            form: {
                email: "",
                password: "",
                confirmPassword: "",
                token: "",
                loadingRecoverPassword: false,
                showPasswordNew: false,
                showPasswordConfirm: false,
            },
        };
    },
    methods: {
        validPassword(value) {
            return (
              (value && /(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&]{8,}$/.test(value)) || "Mínimo de 8 caracteres, 1 letra e 1 número"
            );
        },
    },
    created() {
        this.form.token = this.$route.params.token;
        console.log(this.form.token);
    }
};
</script>

<style></style>
