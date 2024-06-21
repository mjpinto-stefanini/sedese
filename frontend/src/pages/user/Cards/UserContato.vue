<template>
    <q-card class="my-card">
        <q-card-section>
            <div class="text-h6">
                <q-icon name="contacts" color="primary" /> Contato
                <q-btn class="bg-primary text-caption text-white"  @click="abrirModal"
                    style="float: right;">
                    <font-awesome-icon :icon="['far', 'pen-to-square']" />
                    <q-tooltip class="bg-primary text-caption outline" :offset="[10, 10]" style="max-width: 600px">
                        Editar informações de contato.
                    </q-tooltip>
                </q-btn>
            </div>
        </q-card-section>

        <q-markup-table>
            <tbody>
                <tr>
                    <td class="text-left"><span class="text-grey">E-mail</span> {{ user.email }}</td>
                </tr>
                <tr v-if="contato.phone">
                    <td class="text-left"><span class="text-grey">Telefone Residencial</span> {{ contato.phone }}</td>
                </tr>
                <tr v-if="contato.cell_phone">
                    <td class="text-left"><span class="text-grey">Celular</span> {{ contato.cell_phone }} - <span class="text-grey">Whatsapp</span> {{ contato.cell_phone_whatsapp }}</td>
                </tr>
                <tr v-if="contato.institutional_phone">
                    <td class="text-left"><span class="text-grey">Telefone Institucional</span> {{ contato.institutional_phone }}</td>
                </tr>
                <tr v-if="contato.institutional_email">
                    <td class="text-left"><span class="text-grey">E-mail Institucional</span> {{ contato.institutional_email }}</td>
                </tr>
            </tbody>
        </q-markup-table>
    </q-card>
    <UserContatoModal :dadosUser="dadosUser" :modalContato="mostrarModalContato" @update:modalContato="atualizarModal"></UserContatoModal>
</template>

<script>
import UserContatoModal from "../Modals/UserContato.vue";

export default {
    name: "UserContatoCard",
    props: {
        dadosUser: {},
    },
    components: {
        UserContatoModal
    },
    data() {
        return {
            modalContato: false,
            mostrarModalContato: false,
        }
    },
    methods: {
        abrirModal() {
            this.mostrarModalContato = true;
        },
        atualizarModal(novoValor) {
            this.mostrarModalContato = novoValor;
        }
    },
    computed: {
        user() {
            const userData = this.dadosUser.user || {};
            return userData;
        },
        contato() {
            const contatoData = this.dadosUser.contato || {};
            return contatoData;
        }
    }
};
</script>