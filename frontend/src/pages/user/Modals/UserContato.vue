<template>
    <q-dialog v-model="modalAbrir">
        <q-card style="width: 80%; max-width: 80vw;">
            <q-card-section>
                <h6 style="margin:0px; padding: 0px;"><q-icon name="contacts" color="primary" /> Editar Contato</h6>
            </q-card-section>
            <q-card-section>
                <div class="col-12" style="margin:10px 0px; margin-bottom: 20px;">
                    <q-input v-model="user.email" label="Email Principal" outlined type="email" :rules="[isRequired, isEmail]" />
                </div>
                <div class="col-12">
                    <q-input v-model="contato.phone" label="Telefone Residencial" outlined clear-icon="close"
                        mask="(##) ####-####" min="11" max="14" :rules="[isPhoneNumber]" clearable type="tel" />
                </div>
                <div class="col-6">
                    <q-input v-model="contato.cell_phone" label="Nº Celular*" name="cell_phone" for="cell_phone"
                        outlined clear-icon="close" mask="(##) # ####-####" :rules="[isRequired, isCellPhoneNumber]"
                        clearable type="tel" />
                </div>
                <div class="col-6">
                    <q-select v-model="contato.cell_phone_whatsapp" name="cell_phone_whatsapp"
                        for="cell_phone_whatsapp" label="Este número possui WhatsApp?" :options="['Sim', 'Não']"
                        :rules="[isRequired]" outlined />
                </div>
                <div class="col-12">
                    <q-input v-model="contato.institutional_phone" label="Telefone Institucional" outlined
                        clear-icon="close" clearable type="tel" mask="(##) ####-####" min="11" max="14"
                        :rules="[isPhoneNumber,]" />
                </div>
                <div class="col-12">
                    <q-input v-model="contato.institutional_email" label="Email Institucional" outlined
                        clear-icon="close" clearable type="email" :rules="[isEmail]" />
                </div>
            </q-card-section>
            <q-card-actions>
                <q-btn outlined label="Cancelar" color="red" @click="limparFiltrosPagina" v-close-popup
                    style="float: left !important; margin-left:10px;" />
                <q-btn outlined label="Salvar" color="green" @click="salvarDadosContato" v-close-popup
                    style="float: right !important;" :disabled="!camposObrigatoriosDeContatoPreenchidos()" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script>
import { isCellPhoneNumber, isRequired, isPhoneNumber } from "../../../mixins/validates";
import ApiDataUser from "../../../mixins/users";
import accountMixin from "../../../mixins/accountMixin";
import { stateList } from '../../../mixins/parameters';

export default {
    name: "UserContatoModal",
    props: {
        modalContato: {
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
            modalAbrir: false,
            stateList: stateList,
            contatoData: [],
        };
    },
    mixins: [accountMixin, ApiDataUser],
    watch: {
        modalContato(newVal) {
            this.modalAbrir = newVal;
        },
        modalAbrir(newVal) {
            this.$emit('update:modalContato', newVal);
        },
        dadosUser: {
            handler(newVal) {
                if (newVal && newVal.contato) {
                    this.contatoData = newVal.contato;
                }
            },
            deep: true,
            immediate: true
        }
    },
    computed: {
        user() {
            return this.dadosUser.user || {};
        },
        contato() {
            return this.contatoData;
        }
        /*
        user() {
            const userData = this.dadosUser.user || {};
            return userData;
        },
        contato() {
            return this.dadosUser.contato || {};
        }*/
    },
    methods: {
        limparFiltrosPagina() {
            this.$router.go();
        },
        camposObrigatoriosDeContatoPreenchidos() {
            return this.contatoData.cell_phone,
                this.contatoData.cell_phone_whatsapp;
        },

        isRequired(value) {
            return isRequired(value);
        },
        isPhoneNumber(value) {
            return isPhoneNumber(value);
        },
        isCellPhoneNumber(value) {
            return isCellPhoneNumber(value);
        },
        async salvarDadosContato() {
            let params = {
                'user_id': this.user.id,
                'contact': this.contatoData
            }

            if (!this.camposObrigatoriosDeContatoPreenchidos()) {
                this.$q.notify({
                    message: 'É necessário preencher todos os dados obrigatórios para salvar.',
                    color: 'negative',
                    position: 'top',
                });
            }

            try {
                const result = await this.$http.post('contact/updatebyuser', params);
                if (result.status === 200) {
                    this.$q.notify({
                        message: 'Novo colaborador criado com sucesso!',
                        color: "positive",
                        position: "top",
                    });
                }
            } catch (error) {
                this.validandoToken(error);
            }
        }
    }
}
</script>