<template>
    <q-card class="my-card">
        <q-card-section>
            <div class="text-h6"><q-icon name="sym_o_person" color="primary" /> {{ user.name }}
                <q-btn class="bg-primary text-caption text-white"
                    @click="abrirModal"
                    style="float: right;">
                    <font-awesome-icon :icon="['far', 'pen-to-square']" />
                    <q-tooltip class="bg-primary text-caption outline" :offset="[10, 10]" style="max-width: 600px">
                        Editar informações pessoais.
                    </q-tooltip>
                </q-btn>
            </div>
            <div>
                <q-chip size="sm" :text-color="chipTextColor" :label="chipLabel" :color="chipColor" />
                <q-chip v-if="user.type_admin == 1" size="sm" :text-color="'white'" :label="'Administrador'"
                    :color="'primary'" />
                <q-chip v-if="user.type_admin == 2" size="sm" :text-color="'white'" :label="'Responsavel Tecnico'"
                    :color="'primary'" />
                <q-chip v-if="user.type_admin == 3" size="sm" :text-color="'white'" :label="'Usuário'"
                    :color="'primary'" />
            </div>
        </q-card-section>
        <q-markup-table>
            <tbody>
                <tr v-if="user.name">
                    <td class="text-left"><span class="text-grey">Nome</span> {{ user.name }}</td>
                </tr>
                <tr v-if="personal.social_name">
                    <td class="text-left"><span class="text-grey">Nome Social</span> {{ personal.social_name }}</td>
                </tr>
                <tr v-if="personal.gender_identity !== 'Outros'">
                    <td class="text-left"><span class="text-grey">Identidade de Gênero</span> {{ personal.gender_identity }}</td>
                </tr>
                <tr  v-if="personal.gender_identity === 'Outros'">
                    <td class="text-left"><span class="text-grey">Identidade de Gênero</span> {{ personal.gender_identity_others }}</td>
                </tr>
                <tr v-if="personal.birthday">
                    <td class="text-left"><span class="text-grey">Data de nascimento</span> {{ personal.birthday }}</td>
                </tr>
                <tr v-if="personal.cpf">
                    <td class="text-left"><span class="text-grey">CPF</span> {{ personal.cpf }}</td>
                </tr>
                <tr v-if="personal.rg">
                    <td class="text-left"><span class="text-grey">RG</span> {{ personal.rg }}</td>
                </tr>
                <tr v-if="personal.issuing_body">
                    <td class="text-left"><span class="text-grey">Orgão emissor</span> {{ personal.issuing_body }}</td>
                </tr>
                <tr v-if="personal.uf">
                    <td class="text-left"><span class="text-grey">UF</span> {{ personal.uf }}</td>
                </tr>
                <tr v-if="personal.education">
                    <td class="text-left"><span class="text-grey">Escolaridade</span> {{ personal.education }}</td>
                </tr>
                <tr v-if="personal.profission !== 'Outros' && personal.profission">
                    <td class="text-left"><span class="text-grey">Profissão</span> {{ personal.profission }}</td>
                </tr>
                <tr v-if="personal.profission === 'Outros'">
                    <td class="text-left"><span class="text-grey">Profissão</span> {{ personal.profission_others }}</td>
                </tr>
                <tr v-if="personal.deficiency">
                    <td class="text-left" v-if="personal.deficiency !== 'Outros'"><span class="text-grey">Deficiência</span> {{ personal.deficiency }}</td>
                    <td class="text-left" v-if="personal.deficiency === 'Outros'"><span class="text-grey">Deficiência</span> {{ personal.deficiency_others }}</td>
                </tr>
                <tr v-if="personal.deficiency_structure">
                    <td class="text-left"><span class="text-grey">Necessita de estrutura para participar da ação?</span><p>{{ personal.deficiency_structure }}</p></td>
                </tr>
            </tbody>
        </q-markup-table>
    </q-card>
    <q-card class="my-card" style="margin-top: 15px;">
        <q-card-section>
            <h6 style="margin: 0; padding: 0;">
                <q-icon name="build_circle" color="primary" /> Definir situação Cadastral
            </h6>
        </q-card-section>
        <q-card-actions>
            <span class="text-grey" style="margin: 15px 5px;">Situação Cadastral:</span>
            <q-select dense outlined :options="userPerfilStatus" v-model="user.status"
                @update:model-value="changeStatusUsuario($event)" style="width: 98%; margin: 0px 5px;" />
        </q-card-actions>
    </q-card>

    <q-card class="my-card" style="margin-top: 15px; margin-bottom: 10px;">
        <q-card-section>
            <div class="text-h6"><q-icon name="manage_accounts" color="primary" />  Atribuíção de Perfil
                <q-btn color="green" small outline @click="resetarSenhaUsuario" style="float: right;"> Resetar Senha</q-btn>
            </div>
        </q-card-section>
        <q-card-actions>
            <span class="text-grey" style="margin: 15px 5px;">Tipo de perfil:</span>
            <q-select dense outlined :options="tipoPerfilOptions" v-model="user.tipo_perfil"
                @update:model-value="changeTipoPerfilUsuario($event)" style="width: 98%; margin: 0px 5px;" />
        </q-card-actions>
        <q-card-actions>
            <span class="text-grey" style="margin: 15px 5px;">Tipo de perfil Administrativo:</span>
            <q-select dense outlined :options="tipoPerfilAdminOptions" v-model="user.type_admin"
                @update:model-value="changeTipoPerfilAdminUsuario($event)" style="width: 98%; margin: 0px 5px;" />
        </q-card-actions>
    </q-card>
    <UserPessoalModal :dadosUser="dadosUser" :modalDadosPessoais="mostrarModal" @update:modalDadosPessoais="atualizarModal"></UserPessoalModal>
</template>

<script>
import { userPerfilStatus, tipoPerfilOptions, tipoPerfilAdminOptions } from '../../../mixins/parameters';
import ApiDataUser from "../../../mixins/users";
import Swal from 'sweetalert2'
import UserPessoalModal from "../Modals/UserPessoal.vue";

export default {
    name: "UserPessoalCard",
    props: {
        dadosUser: {},
    },
    components: {
        UserPessoalModal
    },
    data() {
        return {
            UserId: this.$route.params.id,
            chipTextColor: null,
            chipLabel: null,
            chipColor: null,
            userPerfilStatus: userPerfilStatus,
            tipoPerfilOptions: tipoPerfilOptions,
            tipoPerfilAdminOptions: tipoPerfilAdminOptions,
            modalDadosPessoais: false,
            mostrarModal: false,
        }
    },
    mixins: [ApiDataUser],
    methods: {
        abrirModal() {
            this.mostrarModal = true;
        },
        atualizarModal(novoValor) {
            this.mostrarModal = novoValor;
        },
        updateChipProperties(status) {
            const perfilStatus = userPerfilStatus.find(item => item.value === status);
            if (perfilStatus) {
                this.chipTextColor = 'white';
                this.chipLabel = perfilStatus.label;
                this.chipColor = perfilStatus.color;
            }
        },
        async resetarSenhaUsuario() {
            try {
                const swalResult = await Swal.fire({
                    title: "Aviso",
                    html: `Uma nova senha aleatória será gerada e enviada ao email do usuário. Deseja prosseguir com o <span class="text-grey">reset?</span>`,
                    icon: "warning",
                    showDenyButton: true,
                    confirmButtonColor: "#5cb768",
                    denyButtonColor: "#f34d45",
                    confirmButtonText: "Confirmar",
                    denyButtonText: 'Cancelar'
                });

                if (swalResult.isConfirmed) {
                    const result = await this.$http.get(`users/reset-password/${this.UserId}`);
                    if (result.status === 200) {
                        this.$q.notify({
                            message: 'Sucesso ao resetar a senha do usuário',
                            color: "positive",
                            position: "top",
                        });
                    }
                } else if (swalResult.isDenied) {
                    this.$router.go();
                }
            } catch (error) {
                this.validandoToken(error);
            }
        },
        async changeTipoPerfilUsuario(target) {
            try {
                this.$q.loading.show({
                    message: 'Atualizando Usuário',
                    backgroundColor: 'indigo',
                });
                let params = {
                    'user_id': this.UserId,
                    'perfil': target.value
                }
                const result = await this.$http.post('users/change-perfil', params);
                if (result.status === 200) {
                    this.$q.notify({
                        message: 'Usuário Atualizado com sucesso',
                        color: "positive",
                        position: "top",
                    });
                }
                this.$q.loading.hide();
                this.$router.go();
            } catch (error) {
                this.validandoToken(error);
                this.$q.loading.hide();
                this.$router.go();
            }
        },
        async changeTipoPerfilAdminUsuario(target) {
            try {
                this.$q.loading.show({
                    message: 'Atualizando Usuário',
                    backgroundColor: 'indigo',
                });
                let params = {
                    'user_id': this.UserId,
                    'admin': target.value
                }
                const result = await this.$http.post('users/change-admin', params);
                if (result.status === 200) {
                    this.$q.notify({
                        message: 'Usuário Atualizado com sucesso',
                        color: "positive",
                        position: "top",
                    });
                }
                this.$q.loading.hide();
                this.$router.go();
            } catch (error) {
                this.validandoToken(error);
                this.$q.loading.hide();
                this.$router.go();
            }
        },
        async changeStatusUsuario(target) {
            try {
                this.$q.loading.show({
                    message: 'Atualizando Usuário',
                    backgroundColor: 'indigo',
                });
                let params = {
                    'user_id': this.UserId,
                    'status': target.value
                }
                const result = await this.$http.post('users/change-status', params);
                if (result.status === 200) {
                    this.$q.notify({
                        message: 'Usuário Atualizado com sucesso',
                        color: "positive",
                        position: "top",
                    });
                }
                this.$q.loading.hide();
                this.$router.go();
            } catch (error) {
                this.validandoToken(error);
                this.$q.loading.hide();
                this.$router.go();
            }
        }
    },
    computed: {
        user() {
            const userData = this.dadosUser.user || {};
            if (userData) {
                this.updateChipProperties(userData.status_id);
            }

            return userData;
        },
        personal() {
            const pessoalData = this.dadosUser.pessoal || {};
            return pessoalData;
        }
    }
};
</script>