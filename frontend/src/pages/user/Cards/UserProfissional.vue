<template>
    <q-card class="my-card">
        <q-card-section>
            <div class="text-h6">
                <q-icon name="sym_o_home_work" color="primary" /> Dados Profissionais
                <q-btn class="bg-primary text-caption text-white"  @click="abrirModal"
                    style="float: right;">
                    <font-awesome-icon :icon="['far', 'pen-to-square']" />
                    <q-tooltip class="bg-primary text-caption outline" :offset="[10, 10]" style="max-width: 600px">
                        Editar informações Profissionais.
                    </q-tooltip>
                </q-btn>
            </div>
        </q-card-section>
        <q-markup-table v-if="profissional.regional === 'Estadual' || profissional.regional === 1">
            <tbody>
                <tr>
                    <td class="text-left"><span class="text-grey">Ambito de atuação</span> Estadual</td>
                </tr>
                <tr>
                    <td class="text-left"><span class="text-grey">Lotação</span> {{ profissional.lotacao }}</td>
                </tr>
                <tr v-if="profissional.lotacao === 'Subsecretaria de Assistência Social' && profissional.superintendencia">
                    <td class="text-left"><span class="text-grey">Superintendência/Assessoria</span> <div>{{ profissional.superintendencia }}</div></td>
                </tr>
                <tr v-if="profissional.lotacao === 'Diretoria Regional de Desenvolvimento Social' && profissional.diretoria_regional_des_social">
                    <td class="text-left"><span class="text-grey">Diretorias</span> {{ profissional.diretoria_regional_des_social }}</td>
                </tr>
                <tr v-if="profissional.lotacao === 'CREAS Regional' && profissional.creas_regional">
                    <td class="text-left"><span class="text-grey">Unidade</span> {{ profissional.creas_regional }}</td>
                </tr>
                <tr v-if="profissional.lotacao === 'Outros Públicos' && profissional.outros_publicos_others === 'Outros' && profissional.outros_publicos_others">
                    <td class="text-left"><span class="text-grey">Órgão de Atuação</span> {{ profissional.outros_publicos_others }}</td>
                </tr>
                <tr v-if="profissional.lotacao === 'Perceiros (Inscrição Interna)' && profissional.parceiros">
                    <td class="text-left"><span class="text-grey">Parceiros</span> {{ profissional.parceiros }}</td>
                </tr>
                <tr v-if="profissional.superintendencia === 'Diretoria de Serviços e Benefícios Socioassistenciais' && profissional.protecao_social_basica">
                    <td class="text-left"><span class="text-grey">Diretorias</span> {{ profissional.protecao_social_basica }}</td>
                </tr>
                <tr v-if="profissional.superintendencia === 'Diretoria de Gestão do Cadastro Único e Programas Socioassistenciais' && profissional.protecao_social_especial">
                    <td class="text-left"><span class="text-grey">Diretorias</span> {{ profissional.protecao_social_especial }}</td>
                </tr>
                <tr v-if="profissional.superintendencia === 'Superintendência de Vigilância e Capacitação' && profissional.vigilancia_capacitacao">
                    <td class="text-left"><span class="text-grey">Diretorias</span> {{ profissional.vigilancia_capacitacao }}</td>
                </tr>
                <tr v-if="profissional.representacao">
                    <td class="text-left"><span class="text-grey">Representação</span> {{ profissional.representacao }}</td>
                </tr>
                <tr v-if="profissional.representacao_area_representada === 'Outros' && profissional.representacao_area_representada_outros">
                    <td class="text-left"><span class="text-grey">Área Representada</span> {{ profissional.representacao_area_representada_outros }}</td>
                </tr>
                <tr v-if="profissional.representacao_area_representada !== 'Outros' && profissional.representacao_area_representada">
                    <td class="text-left"><span class="text-grey">Área Representada</span> {{ profissional.representacao_area_representada }}</td>
                </tr>
                <tr v-if="profissional.representacao_segmento">
                    <td class="text-left"><span class="text-grey">Representação</span> {{ profissional.representacao_segmento }}</td>
                </tr>
                <tr v-if="profissional.funcao">
                    <td class="text-left"><span class="text-grey">Função</span> {{ profissional.funcao }}</td>
                </tr>
                <tr v-if="profissional.funcao_outro">
                    <td class="text-left"><span class="text-grey">Função Outro</span> {{ profissional.funcao_outro }}</td>
                </tr>
                <tr v-if="profissional.representacao_titularidade">
                    <td class="text-left"><span class="text-grey">Titularidade</span> {{ profissional.representacao_titularidade }}</td>
                </tr>
            </tbody>
        </q-markup-table>
        <q-markup-table v-if="profissional.regional === 'Municipal' || profissional.regional === 2">
            <tbody>
                <tr>
                    <td class="text-left"><span class="text-grey">Ambito de atuação</span> Municipal</td>
                </tr>
                <tr v-if="secretaria">
                    <td class="text-left"><span class="text-grey">Múnicipio</span> {{ secretaria.nome }}</td>
                </tr>
                <tr v-if="profissional.orgao">
                    <td class="text-left"><span class="text-grey">Órgão</span> {{ profissional.orgao }}</td>
                </tr>
                <tr v-if="profissional.funcao">
                    <td class="text-left"><span class="text-grey">Função</span> {{ profissional.funcao }}</td>
                </tr>
                <tr v-if="profissional.representacao">
                    <td class="text-left"><span class="text-grey">Segmento</span> {{ profissional.representacao }}</td>
                </tr>
                <tr v-if="profissional.area_de_atuacao">
                    <td class="text-left"><span class="text-grey">Área de atuação</span> {{ profissional.area_de_atuacao }}</td>
                </tr>
                <tr v-if="profissional.servicos_programa">
                    <td class="text-left"><span class="text-grey">Serviço/Programa</span> <div>{{ profissional.servicos_programa }}</div></td>
                </tr>
                <tr v-if="profissional.servicos_programa_outro">
                    <td class="text-left"><span class="text-grey">Outro - Serviço/Programa</span> {{ profissional.servicos_programa_outro }}</td>
                </tr>
                <tr v-if="profissional.beneficios_municipal">
                    <td class="text-left"><span class="text-grey">Benefício</span> <div>{{ profissional.beneficios_municipal }}</div></td>
                </tr>
                <tr v-if="profissional.beneficios_municipal_outro">
                    <td class="text-left"><span class="text-grey">Outro - Benefícios</span> {{ profissional.beneficios_municipal_outro }}</td>
                </tr>
                <tr v-if="profissional.area_representada">
                    <td class="text-left"><span class="text-grey">Representação</span> {{ profissional.area_representada }}</td>
                </tr>
                <tr v-if="profissional.area_representada_outros">
                    <td class="text-left"><span class="text-grey">Outro - Área representada</span> {{ profissional.area_representada_outros }}</td>
                </tr>
                <tr v-if="profissional.protecao_social_especial_municipal">
                    <td class="text-left"><span class="text-grey">Nível de Complexidade</span> {{ profissional.protecao_social_especial_municipal }}</td>
                </tr>
                <tr v-if="profissional.cargo">
                    <td class="text-left"><span class="text-grey">Titularidade</span> {{ profissional.cargo }}</td>
                </tr>
                <tr v-if="profissional.vinculo_empregaticio">
                    <td class="text-left"><span class="text-grey">Vínculo empregaticio</span> {{ profissional.vinculo_empregaticio }}</td>
                </tr>
                <tr v-if="profissional.vinculo_empregaticio_outro">
                    <td class="text-left"><span class="text-grey">Outro - Vínculo empregaticio</span> {{ profissional.vinculo_empregaticio_outro }}</td>
                </tr>
                <tr v-if="profissional.representacao_conselho">
                    <td class="text-left"><span class="text-grey">Conselho</span> {{ profissional.representacao_conselho }}</td>
                </tr>
                <tr v-if="profissional.representacao_representacao">
                    <td class="text-left"><span class="text-grey">Representação</span> {{ profissional.representacao_representacao }}</td>
                </tr>
                <tr v-if="profissional.representacao_segmento">
                    <td class="text-left"><span class="text-grey">Segmento</span> {{ profissional.representacao_segmento }}</td>
                </tr>
                <tr v-if="profissional.representacao_area_representada === 'Outros' && profissional.representacao_area_representada_outros">
                    <td class="text-left"><span class="text-grey">Área Representada</span> {{ profissional.representacao_area_representada_outros }}</td>
                </tr>
                <tr v-if="profissional.representacao_area_representada !== 'Outros' && profissional.representacao_area_representada">
                    <td class="text-left"><span class="text-grey">Área Representada</span> {{ profissional.representacao_area_representada }}</td>
                </tr>
                <tr v-if="profissional.representacao_titularidade">
                    <td class="text-left"><span class="text-grey">Titularidade</span> {{ profissional.representacao_titularidade }}</td>
                </tr>
            </tbody>
        </q-markup-table>
    </q-card>
    <UserProfissionalModal :dadosUser="dadosUser" :modalDadosProfissional="mostrarModal" @update:modalDadosProfissional="atualizarModal"></UserProfissionalModal>
</template>

<script>
import UserProfissionalModal from "../Modals/UserProfissional.vue";

export default {
    name: "UserProfissionalCard",
    props: {
        dadosUser: {},
    },
    components: {
        UserProfissionalModal
    },
    data() {
        return {
            modalDadosProfissional: false,
            mostrarModal: false
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
        user() {
            const userData = this.dadosUser.user || {};
            return userData;
        },
        secretaria() {
            const secretariaData = this.dadosUser.secretaria || {};
            return secretariaData;
        },
        profissional() {
            const profissionalData = this.dadosUser.profissional || {};
            return profissionalData;
        }
    }
};
</script>