<template>
    <q-page class="bg-grey-1">
        <div class="q-pa-md">
            <div class="row" style="margin-bottom: 10px;">
                <div class="col-12">
                    <q-btn class="bg-primary text-white" style="float: right;" @click="voltarPagina">
                        Voltar
                    </q-btn>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 q-pa-xs">
                    <UserPessoalCard :dadosUser="dadosUser"></UserPessoalCard>
                </div>
                <div class="col-sm-4 q-pa-xs">
                    <div class="row">
                        <div class="col-sm-12 q-pa-xs">
                            <UserEnderecoCard :dadosUser="dadosUser"></UserEnderecoCard>
                        </div>
                        <div class="col-sm-12 q-pa-xs">
                            <UserContatoCard :dadosUser="dadosUser"></UserContatoCard>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 q-pa-xs">
                    <UserProfissionalCard :dadosUser="dadosUser"></UserProfissionalCard>
                </div>
            </div>
        </div>
    </q-page>
</template>

<script>
import accountMixin from "../../mixins/accountMixin";
import UserPessoalCard from "./Cards/UserPessoal.vue";
import UserEnderecoCard from "./Cards/UserEndereco.vue";
import UserContatoCard from "./Cards/UserContato.vue";
import UserProfissionalCard from "./Cards/UserProfissional.vue";

import ApiDataUser from "../../mixins/users";
import * as parametros from '../../mixins/parameters';
import * as Validates from "../../mixins/validates";

export default {
    name: "AdminViewUser",
    components: {
        UserPessoalCard,
        UserEnderecoCard,
        UserContatoCard,
        UserProfissionalCard
    },
    data() {
        return {
            UserId: this.$route.params.id,
            dadosUser: {},
            parametros
        }
    },
    mixins: [accountMixin, ApiDataUser],
    methods: {
        voltarPagina() {
            this.dadosUser = [];
            this.$router.push({ name: "Users" });
        },
        async dadosUsuario() {
            Validates.isCpf('123');
            Validates.isCpf('35763890833');
            Validates.isCpf('357.638.908-33');
            this.$q.loading.show({
                message: 'Carregando informações do usuário',
                backgroundColor: 'indigo',
            });
            try {
                const { dados, status } = await this.userData(this.UserId);
                if (!status) {

                    this.$q.notify({
                        message: 'Nao Encontrado',
                        color: "negative",
                        position: "top",
                    });
                    this.$q.loading.hide();
                    return
                }
                this.dadosUser.user = dados;
                this.dadosPessoalUsuario();
                this.secretaria(dados.secretary);
                this.dadosContatoUsuario();
                this.dadosEnderecoUsuario();
                this.dadosProfissionaisUsuario();
            } catch (error) {
                this.$q.loading.hide();
            }
            this.$q.loading.hide();
        },
        async dadosPessoalUsuario() {
            try {
                const { dados, status } = await this.personalData(this.UserId);
                if (!status) {
                    return;
                }
                this.dadosUser.pessoal = dados;
            } catch (error) {
                this.$q.loading.hide();
            }
        },
        async dadosContatoUsuario() {
            try {
                const { dados, status } = await this.contactData(this.UserId);
                if (!status) {
                    return;
                }
                this.dadosUser.contato = dados;
            } catch (error) {
                this.$q.loading.hide();
            }
        },
        async dadosEnderecoUsuario() {
            try {
                const { dados, status } = await this.getUserAddress(this.UserId);
                if (!status) {
                    return;
                }
                this.dadosUser.endereco = dados;
            } catch (error) {
                this.$q.loading.hide();
            }
        },
        async dadosProfissionaisUsuario() {
            try {
                const { dados, status } = await this.getUserProfessionals(this.UserId);
                if (!status) {
                    return;
                }
                this.dadosUser.profissional = dados;
            } catch (error) {
                this.$q.loading.hide();
            }
        },
        async secretaria(secretaryId) {
            try {
                const { dados, status } = await this.secretaryById(secretaryId);
                if (!status) {
                    return;
                }
                this.dadosUser.secretaria = dados;
            } catch (error) {
                this.$q.loading.hide();
            }
        }
    },
    created() {
        this.dadosUsuario();
    }
}

</script>