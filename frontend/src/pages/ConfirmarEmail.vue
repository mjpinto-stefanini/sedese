<template>
    <q-page class="flex flex-center bg-grey-1">
        <q-form @submit="onRecoverPassword">
            <q-card flat bordered style="width: 448px" class="q-pa-md">
                <q-card-section>
                    <div class="text-h6 text-center">Confirmar E-mail</div>
                </q-card-section>
                <q-card-section class="q-gutter-sm">
                    <div v-text="resultado"></div>
                </q-card-section>
            </q-card>
        </q-form>
    </q-page>
</template>

<script>
//import axios from 'axios';
import accountMixin from "../mixins/accountMixin";
export default {
    name: "ConfirmarEmail",
    mixins: [accountMixin],
    data() {
        return {
            resultado: '',
        }
    },
    methods: {
        async mailConfirm(token)
        {
            try {
                const { status } = await this.$http.get(`users/confirm-email/${token}`);
                console.log('status', status)
                if (status === 200 || status === 204) {
                    this.resultado = 'E-mail confirmado com sucesso!'
                    return;
                }
                this.resultado = 'Erro ao confirmar seu email!'
                return;
            } catch (error) {
                this.$q.notify({
                    message: error.response.data.message,
                    color: "negative",
                    position: "top",
                });
            }
        }
    },
    mounted() {
        this.mailConfirm(this.$route.params.token);
    }
};
</script>

<style></style>
