<template>
    <q-dialog v-model="modalAbrir">
        <q-card style="width: 80%; max-width: 80vw;">
            <q-card-section>
                <h6 style="margin:0px; padding: 0px;"><q-icon name="sym_o_home_work" color="primary" /> Editar Dados
                    Residenciais</h6>
            </q-card-section>
            <q-card-section>
                <div class="row q-col-gutter-md">
                    <div class="col-12">
                        <q-input v-model="address.zip_code" label="Cep" name="zip_code" for="zip_code" outlined
                            clear-icon="close" clearable mask="#####-###" @blur="getAddressByZipCode" value=""
                            :rules="[isRequired]" />
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <q-input v-model="address.street" label="Logradouro" name="street" for="street" outlined
                            clear-icon="close" clearable :rules="[isRequired]" />
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <q-input v-model="address.number" label="Número" name="number" for="number" outlined
                            clear-icon="close" clearable ref="number" :rules="[isRequired, isNumber]" />
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <q-input v-model="address.complement" label="Complemeto" outlined clear-icon="close"
                            clearable />
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <q-input v-model="address.neighborhood" label="Bairro" name="neighborhood" for="neighborhood"
                            outlined clear-icon="close" clearable :rules="[isRequired]" />
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <q-input v-model="address.city" label="Cidade" name="city" for="city" outlined
                            clear-icon="close" clearable :rules="[isRequired]" />
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <q-select v-model="address.state" :options="stateFiltered" label="UF" name="state" for="state"
                            outlined use-input input-debounce="0" @filter="onStateFilter" clear-icon="close" clearable
                            :rules="[isRequired]" />
                    </div>
                </div>
            </q-card-section>
            <q-card-actions>
                <q-btn outlined label="Cancelar" color="red" @click="limparFiltrosPagina" v-close-popup
                    style="float: left !important; margin-left:10px;" />
                <q-btn outlined label="Salvar" color="green" @click="salvarDadosEndereco" v-close-popup
                    style="float: right !important;" :disabled="!camposObrigatoriosDeEnderecosPreenchidos()" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script>
import { onlyLetter, isNumber, isRequired } from "../../../mixins/validates";
import ApiDataUser from "../../../mixins/users";
import accountMixin from "../../../mixins/accountMixin";
import { stateList, urlCep } from '../../../mixins/parameters';
import axios from "axios";

export default {
    name: "UserEnderecoModal",
    props: {
        modalDadosEndereco: {
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
            stateFiltered: [],
            addressData: [],
            stateList: stateList,
            baseUrlViaCep: urlCep,
        };
    },
    mixins: [accountMixin, ApiDataUser],
    watch: {
        modalDadosEndereco(newVal) {
            this.modalAbrir = newVal;
        },
        modalAbrir(newVal) {
            this.$emit('update:modalDadosEndereco', newVal);
        },
        dadosUser: {
            handler(newVal) {
                if (newVal && newVal.address) {
                    this.addressData = newVal.address;
                }
            },
            deep: true,
            immediate: true
        }
    },
    computed: {
        address() {
            const enderecoData = this.dadosUser.endereco || {};
            return enderecoData;
        }
    },
    methods: {
        async salvarDadosEndereco() {
            try {
                if (!this.camposObrigatoriosDeEnderecosPreenchidos()) {
                    this.$q.notify({
                        message: 'É necessário preencher todos os dados obrigatórios para salvar.',
                        color: 'negative',
                        position: 'top',
                    });
                }
                const result = await this.$http.post('address/updatebyuser', this.address);
                if (result.status === 200) {
                    this.$q.notify({
                        message: 'Endereço salvo com sucesso!',
                        color: 'positive',
                        position: 'top',
                    });
                } else {
                    this.$q.notify({
                        message: `Erro ao salvar endereço: ${result.status} - ${result.statusText}`,
                        color: 'negative',
                        position: 'top',
                    });
                }
            } catch (error) {
                this.validandoToken(error);
            }
        },
        limparFiltrosPagina() {
            this.$router.go();
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
        onStateFilter(val, update) {
            if (val === "") {
                update(() => {
                    this.stateFiltered = this.stateList;
                });
            }
            update(() => {
                const needle = val.toLowerCase();
                this.stateFiltered = this.stateList.filter((v) =>
                    v.toLowerCase().includes(needle)
                );
            });
        },
        async getAddressByZipCode() {
            try {
                this.$q.loading.show({
                    message: 'Buscando endereço',
                    backgroundColor: 'indigo',
                });

                const { data, status } = await axios.get(`${this.baseUrlViaCep}${this.address.zip_code}/json/`);

                if (status === 200) {
                    this.addressData.street = data.logradouro;
                    this.addressData.neighborhood = data.bairro;
                    this.addressData.complement = data.complemento;
                    this.addressData.city = data.localidade;
                    this.addressData.state = data.uf;
                    this.$refs.number.focus();
                    this.$q.loading.hide();
                }
            } catch (error) {
                this.$q.loading.hide();
            }
        },
        camposObrigatoriosDeEnderecosPreenchidos() {
            return this.address.zip_code &&
                this.address.street &&
                this.address.number &&
                this.address.neighborhood &&
                this.address.city &&
                this.address.state;
        }
    }
}
</script>