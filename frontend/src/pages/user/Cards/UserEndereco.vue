<template>
    <q-card class="my-card">
        <q-card-section>
            <div class="text-h6">
                <q-icon name="sym_o_home_work" color="primary" /> Dados Residenciais
                <q-btn class="bg-primary text-caption text-white"  @click="abrirModal"
                    style="float: right;">
                    <font-awesome-icon :icon="['far', 'pen-to-square']" />
                    <q-tooltip class="bg-primary text-caption outline" :offset="[10, 10]" style="max-width: 600px">
                        Editar informações de residencia.
                    </q-tooltip>
                </q-btn>
            </div>
        </q-card-section>

        <q-markup-table>
            <tbody>
                <tr>
                    <td class="text-left"><span class="text-grey">CEP</span> {{ address.zip_code }}</td>
                </tr>
                <tr>
                    <td class="text-left"><span class="text-grey">Logradouro</span> {{ address.street }}</td>
                </tr>
                <tr>
                    <td class="text-left"><span class="text-grey">Número</span> {{ address.number }}</td>
                </tr>
                <tr>
                    <td class="text-left"><span class="text-grey">Bairro</span> {{ address.neighborhood }}</td>
                </tr>
                <tr v-if="address.complement">
                    <td class="text-left"><span class="text-grey">Complemento</span> {{ address.complement }}</td>
                </tr>
                <tr>
                    <td class="text-left"><span class="text-grey">Cidade</span> {{ address.city }}</td>
                </tr>
                <tr>
                    <td class="text-left"><span class="text-grey">Estado</span> {{ address.state }}</td>
                </tr>
            </tbody>
        </q-markup-table>
    </q-card>
    <UserEnderecoModal :dadosUser="dadosUser" :modalDadosEndereco="mostrarModal" @update:modalDadosEndereco="atualizarModal"></UserEnderecoModal>
</template>

<script>
import UserEnderecoModal from "../Modals/UserEndereco.vue";

export default {
    name: "UserEnderecoCard",
    props: {
        dadosUser: {},
    },
    components: {
        UserEnderecoModal
    },
    data() {
        return {
            modalDadosEndereco: false,
            mostrarModal: false,
        }
    },
    methods: {
        abrirModal() {
            this.mostrarModal = true;
        },
        atualizarModal(novoValor) {
            this.mostrarModal = novoValor;
        }
    },
    computed: {
        address() {
            const enderecoData = this.dadosUser.endereco || {};
            return enderecoData;
        }
    }
};
</script>