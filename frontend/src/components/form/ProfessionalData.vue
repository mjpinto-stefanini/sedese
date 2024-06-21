<template>
    <q-card flat>
        <q-card-section>
            <div class="row q-col-gutter-y-md">
                <div class="col-12">
                    <q-select
                        v-model="form.regional"
                        :options="regionalList"
                        label="Âmbito de atuação*"
                        name="regional"
                        for="regional"
                        outlined
                        :rules="[isRequired]"
                        disable
                    />
                </div>
                <!-- ESTADUAL -->
                <div class="col-12 row q-col-gutter-y-md" v-if="form.regional.value === 1">
                    <div class="col-12">
                        <q-select
                            v-model="form.lotacao"
                            :options="filterLotacao"
                            label="Lotação*"
                            name="lotacao"
                            for="lotacao"
                            outlined
                            :rules="[isRequired]"
                            disable
                        />
                    </div>

                    <div class="col-12" v-if="form.lotacao.label === 'Subsecretaria de Assistência Social'">
                        <q-select
                            v-model="form.superintendencia"
                            :options="parametros.superintendenciaList"
                            label="Superintendência/Assessoria*"
                            name="superintendencia"
                            for="superintendencia"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>

                    <div class="col-12" v-if="form.lotacao.label === 'Diretoria Regional de Desenvolvimento Social'">
                        <q-select
                            v-model="form.diretoriaRegionalDesSocial"
                            :options="parametros.diretoriaRegionalDesSocialList"
                            label="Diretorias*"
                            name="diretoriaRegionalDesSocial"
                            for="diretoriaRegionalDesSocial"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>

                    <div class="col-12" v-if="form.lotacao.label === 'CREAS Regional'">
                        <q-select
                            v-model="form.creasRegional"
                            :options="parametros.creasRegionalList"
                            label="Unidade*"
                            name="creasRegional"
                            for="creasRegional"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>
                    <div class="col-12" v-if="form.lotacao.label === 'Outros Públicos'">
                        <q-select
                            v-model="form.outrosPublicos"
                            :options="parametros.outrosPublicosList"
                            name="outrosPublicos"
                            for="outrosPublicos"
                            label="Órgão de Atuação*"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>
                    <div class="col-12" v-if="form.outrosPublicos.value === 8">
                        <q-input
                            v-model="form.outrosPublicosOutro"
                            label="Informe qual é o seu órgão de atuação*"
                            name="outrosPublicosOutro"
                            for="outrosPublicosOutro"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>
                    <div class="col-12" v-if="form.lotacao.label === 'Perceiros (Inscrição Interna)'">
                        <q-select
                            v-model="form.parceirosInscInterna"
                            :options="parceirosInscInternaList"
                            label="Parceiros*"
                            name="parceirosInscInterna"
                            for="parceirosInscInterna"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>
                    <div class="col-12" v-if="form.superintendencia.value === 1">
                        <q-select
                            v-model="form.protecaoSocialBasica"
                            :options="parametros.protecaoSocialBasicaList"
                            label="Diretorias*"
                            name="protecaoSocialBasica"
                            for="protecaoSocialBasica"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>
                    <div class="col-12" v-if="form.superintendencia.value === 2">
                        <q-select
                            v-model="form.protecaoSocialEspecialEstadual"
                            :options="parametros.protecaoSocialEspecialEstadualList"
                            label="Diretorias*"
                            name="protecaoSocialEspecialEstadual"
                            for="protecaoSocialEspecialEstadual"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>
                    <div class="col-12" v-if="form.superintendencia.value === 3">
                        <q-select
                            v-model="form.vigilanciaCapacitacao"
                            :options="parametros.vigilanciaCapacitacaoList"
                            label="Diretorias*"
                            name="vigilanciaCapacitacao"
                            for="vigilanciaCapacitacao"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>
                    <div class="col-12" v-if="form.regional.value === 1">
                        <div v-if="form.lotacao.label === 'Ceas'">
                            <q-select
                                v-model="form.funcao"
                                :options="parametros.funcaoDesempenhadaCeasList"
                                label="Função desempenhada*"
                                name="funcao"
                                for="funcao"
                                outlined
                                :rules="[isRequired]"
                                @update:model-value="limparCamposCeasFuncaoDesempenhada()"
                            />
                        </div>
                        <div v-else>
                            <q-select
                                v-model="form.funcao"
                                :options="parametros.funcaoDesempenhadaList"
                                label="Função desempenhada*"
                                name="funcao"
                                for="funcao"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                    </div>
                    <div class="col-12" v-if="form.funcao === 'Conselheiro'">
                        <q-select
                            v-model="form.ceas_representacao"
                            :options="parametros.funcaoDesempenhadaSecratariaList"
                            label="Segmento*"
                            name="segmento"
                            for="segmento"
                            outlined
                            :rules="[isRequired]"
                            @update:model-value="limparCamposCeasSegmento()"
                        />
                    </div>
                    <div class="col-12" v-if="form.ceas_representacao === 'Governamental'">
                        <div class="col-12">
                            <q-select
                                v-model="form.seguimento_governo"
                                :options="parametros.representacaoRepresentacaoList"
                                label="Representação*"
                                name="representação"
                                for="representação"
                                outlined
                                :rules="[isRequired]"
                                @update:model-value="limparCamposCeasRepresentacao()"
                            />
                        </div>
                        <div class="col-12" v-if="form.seguimento_governo.value === 1">
                            <q-select
                                v-model="form.representacaoAreaRepresentada"
                                :options="parametros.representacaoAreaRepresentadaList"
                                label="Área Representada*"
                                name="representacaoAreaRepresentada"
                                for="representacaoAreaRepresentada"
                                outlined
                                clearable
                                :rules="[isRequired]"
                            />
                        </div>

                        <div class="col-12" v-if="form.representacaoAreaRepresentada === 'Outros'">
                            <q-input
                                v-model="form.outrosRepresentacaoAreaRepresentada"
                                label="Informe qual é o sua área representada*"
                                name="outrosRepresentacaoAreaRepresentada"
                                for="outrosRepresentacaoAreaRepresentada"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                    </div>

                    <div class="col-12" v-if="form.seguimento_governo === 'Outro'">
                        <q-input
                            v-model="form.ceas_segmento"
                            label="Representação*"
                            name="representação"
                            for="representação"
                            outlined
                            counter
                            maxlength="30"
                            clear-icon="close"
                            clearable
                            :rules="[isRequired]"
                        />
                    </div>
                    <div class="col-12" v-if="form.ceas_representacao === 'Sociedade Civil'">
                        <q-select
                            v-model="form.ceas_segmento"
                            :options="parametros.representacaoSegmentoList"
                            label="Representação*"
                            name="representação"
                            for="representação"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>
                    <div class="col-12" v-if="form.funcao === 'Outro'">
                        <q-input
                            v-model="form.funcaoOutro"
                            label="Função Outro*"
                            name="funcaoOutro"
                            for="funcaoOutro"
                            outlined
                            placeholder="Função Outro"
                            counter
                            maxlength="50"
                            clear-icon="close"
                            clearable
                            :rules="[isRequired]"
                        />
                    </div>

                    <div class="col-12" v-if="form.funcao === 'Conselheiro'">
                        <q-select
                            v-model="form.ceas_titularidade"
                            :options="parametros.funcaoDesempenhadaConselheiroList"
                            label="Titularidade*"
                            name="titularidade"
                            for="titularidade"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>
                </div>
                <!-- FIM ESTADUAL -->
                <!-- MUNICIPAL -->
                <div class="col-12 row q-col-gutter-y-md" v-if="form.regional.value === 2">
                    <div class="col-12">
                        <q-select
                            v-model="form.orgao"
                            label="Orgão*"
                            name="orgao"
                            for="orgao"
                            outlined
                            :options="parametros.orgaoList"
                            :rules="[isRequired]"
                        />
                    </div>

                    <div class="col-12">
                        <q-select
                            v-model="form.municipio"
                            :options="filterMunicipios"
                            label="Município onde atua*"
                            name="municipio"
                            for="municipio"
                            outlined
                            :rules="[isRequired]"
                            disable
                        />
                    </div>
                    <!-- Opções de input dependendo do valor do campo Orgão -->
                    <div class="col-12" v-if="form.orgao.value === 2">
                        <!-- Opções para Conselheiro Municipal -->
                        <q-select
                            v-model="form.funcao"
                            :options="parametros.funcaoDesempenhadaCeasList"
                            label="Função desempenhada*"
                            name="funcao"
                            for="funcao"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>
                    <div class="col-12" v-else-if="form.orgao.value && form.orgao.value !== 5">
                        <q-select
                            v-model="form.funcao"
                            :options="parametros.funcaoDesempenhadaList"
                            label="Função desempenhada*"
                            name="funcao"
                            for="funcao"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>
                    <!-- Opções de input dependendo do valor do campo Orgão -->
                    <div class="col-12" v-if="form.funcao === 'Conselheiro'">
                        <q-select
                            v-model="form.representante"
                            :options="parametros.representanteList"
                            label="Segmento*"
                            name="representante"
                            for="representante"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>

                    <div class="col-12" v-if="form.orgao.value === 1">
                        <q-select
                            v-model="form.areadeAtuacao"
                            :options="parametros.areadeAtuacaoList1"
                            label="Área de atuação*"
                            name="areadeAtuacao"
                            for="areadeAtuacao"
                            outlined
                            clearable
                            :rules="[isRequired]"
                        />

                        <!-- Opções de input dependendo do valor do campo Área de atuação -->
                        <div class="col-12" v-if="form.areadeAtuacao.value === 1">
                            <q-select
                                v-model="form.servicosPrograma"
                                :options="parametros.protecaoSocialList"
                                label="Serviço/Programa*"
                                name="servicosPrograma"
                                for="servicosPrograma"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                    </div>

                    <!-- Opções de input dependendo do valor do campo Serviço/Programa -->
                    <div class="col-12" v-if="form.servicosPrograma.value === 4">
                        <div class="col-12">
                            <q-select
                                v-model="form.beneficiosMunicipal"
                                :options="parametros.beneficioslList"
                                label="Benefício*"
                                name="beneficiosMunicipal"
                                for="beneficiosMunicipal"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                        <div class="col-12" v-if="form.beneficiosMunicipal === 'Outro'">
                            <q-input
                                v-model="form.beneficiosMunicipalOutro"
                                label="Outro - Benefícios*"
                                name="beneficiosMunicipalOutro"
                                for="beneficiosMunicipalOutro"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                    </div>

                    <!-- Opções de input dependendo do valor do campo Representante -->
                    <div class="col-12" v-if="form.representante.value === 1">
                        <div class="col-12">
                            <q-select
                                v-model="form.areaRepresentada"
                                :options="parametros.representacaoGovernamentalConselheiroList"
                                label="Representação*"
                                name="areaRepresentada"
                                for="areaRepresentada"
                                outlined
                                clearable
                                :rules="[isRequired]"
                            />
                        </div>

                        <div class="col-12" v-if="form.areaRepresentada === 'Outro'">
                            <q-input
                                v-model="form.areaRepresentadaOutro"
                                label="Outro - Área representada*"
                                name="areaRepresentadaOutro"
                                for="areaRepresentadaOutro"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                    </div>

                    <div class="col-12" v-if="form.representante.value === 2">
                        <q-select
                            v-model="form.areaRepresentada"
                            :options="parametros.areaRepresentadaCivilList"
                            label="Representação*"
                            name="areaRepresentada"
                            for="areaRepresentada"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>

                    <div class="col-12" v-if="form.orgao.value === 3">
                        <q-select
                            v-model="form.areadeAtuacao"
                            :options="parametros.areadeAtuacaoList2"
                            label="Área de Atuação*"
                            name="areadeAtuacao"
                            for="areadeAtuacao"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>

                    <!-- Opções de input dependendo do valor do campo Área de Atuacao -->
                    <div class="col-12" v-if="form.areadeAtuacao === 1">
                        <q-select
                            v-model="form.areadeAtuacao"
                            :options="parametros.areadeAtuacaoList2"
                            label="Área de Atuação*"
                            name="areadeAtuacao"
                            for="areadeAtuacao"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>

                    <div class="col-12" v-if="form.areadeAtuacao.value === 2">
                        <q-select
                            v-model="form.protecaoSocialEspecialMunicipal"
                            :options="parametros.protecaoSocialEspecialMunicipalList"
                            label="Nível de Complexidade*"
                            name="protecaoSocialEspecialMunicipal"
                            for="protecaoSocialEspecialMunicipal"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>

                    <!-- Opções de input dependendo do valor do campo Proteção Social Especial -->
                    <div class="col-12" v-if="form.protecaoSocialEspecialMunicipal.value === 1">
                        <div class="col-12">
                            <q-select
                                v-model="form.servicosPrograma"
                                :options="parametros.socialEspecialMediaComplexidadeList"
                                label="Serviço/Programa*"
                                name="servicosPrograma"
                                for="servicosPrograma"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                    </div>
                    <div class="col-12" v-else>
                        <div class="col-12" v-if="form.areadeAtuacao.value === 2">
                            <q-select
                                v-model="form.servicosPrograma"
                                :options="parametros.socialEspecialAltaComplexidadeList"
                                label="Serviço/Programa*"
                                name="servicosPrograma"
                                for="servicosPrograma"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                    </div>

                    <!-- Opções de input dependendo do valor do campo Área de atuação -->
                    <div class="col-12" v-if="form.areadeAtuacao.value === 3">
                        <div class="col-12">
                            <q-select
                                v-model="form.servicosPrograma"
                                :options="parametros.gestaoDoSuasList"
                                label="Serviço/Programa*"
                                name="servicosPrograma"
                                for="servicosPrograma"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>

                        <div class="col-12" v-if="form.servicosPrograma === 'Outro'">
                            <q-input
                                v-model="form.servicosProgramaOutro"
                                label="Outro - Serviço/Programa*"
                                name="servicosProgramaOutro"
                                for="servicosProgramaOutro"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                    </div>

                    <!-- Opções de input dependendo do valor do campo Área de atuação -->
                    <div class="col-12" v-if="form.areadeAtuacao.value === 4">
                        <div class="col-12" v-if="form.servicosPrograma === 'Outro'">
                            <q-input
                                v-model="form.servicosProgramaOutro"
                                label="Outro - Serviço/Programa*"
                                name="servicosProgramaOutro"
                                for="servicosProgramaOutro"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                        <div class="col-12">
                            <q-select
                                v-model="form.servicosPrograma"
                                :options="parametros.gestaoFinanceiraOrcamentariaSuasList"
                                label="Serviço/Programa*"
                                name="servicosPrograma"
                                for="servicosPrograma"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                    </div>
                    <div class="col-12" v-if="false">
                        <div class="col-12">
                            <q-select
                                v-model="form.areaRepresentada"
                                :options="parametros.representacaoAreaRepresentadaList"
                                label="Área Representada*"
                                name="areaRepresentada"
                                for="areaRepresentada"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                        <div class="col-12" v-if="form.areaRepresentadaOutro">
                            <q-input
                                v-model="form.areaRepresentadaOutro"
                                label="Outro - Área Representada*"
                                name="areaRepresentadaOutro"
                                for="areaRepresentadaOutro"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                    </div>

                    <div class="col-12" v-if="form.areaRepresentada !== ''">
                        <q-select
                            v-model="form.cargo"
                            :options="parametros.cargoList"
                            label="Titularidade*"
                            name="cargo"
                            for="cargo"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>

                </div>

                <div class="col-12" v-if="form.funcao === 'Secretaria Executiva'">
                    <q-select
                        v-model="form.vinculoEmpregaticio"
                        :options="parametros.vinculoEmpregaticioList"
                        label="Vínculo empregaticio*"
                        name="vinculoEmpregaticio"
                        for="vinculoEmpregaticio"
                        outlined
                        :rules="[isRequired]"
                        @update:model-value="limparVinculoEmpregaticio()"
                    />
                </div>

                <div class="col-12" v-if="form.vinculoEmpregaticio === 'Outro' && form.funcao === 'Secretaria Executiva'">
                    <q-input
                        v-model="form.vinculoEmpregaticioOutro"
                        label="Informe qual é o seu vínculo empregatício*"
                        name="vinculoEmpregaticioOutro"
                        for="vinculoEmpregaticioOutro"
                        outlined
                        :rules="[isRequired]"
                    />
                </div>

                <div class="col-12" v-if="form.regional.value === 2 && form.orgao.value !== 5">
                    <q-toggle
                        v-model="form.possuiRepresentacao"
                        label="Possui também alguma representação em conselho de assistência social (municipal ou estadual)?"
                    />
                </div>

                <div class="col-12" v-if="form.possuiRepresentacao">

                    <div class="col-12" v-if="form.orgao.value === 2">
                        <q-select
                            v-model="form.representacaoConselho"
                            :options="parametros.representacaoConselhoList"
                            label="Conselho*"
                            name="representacaoConselho"
                            for="representacaoConselho"
                            outlined
                            :rules="[isRequired]"
                        />

                    </div>
                    <div class="col-12" v-else>
                        <q-select
                            v-model="form.representacaoConselho"
                            :options="parametros.representacaoConselhoCMASList"
                            label="Conselho*"
                            name="representacaoConselho"
                            for="representacaoConselho"
                            outlined
                            :rules="[isRequired]"
                        />

                    </div>
                    <div class="col-12">
                        <q-select
                            v-model="form.representacaoRepresentacao"
                            :options="parametros.representanteList"
                            label="Segmento*"
                            name="representacaoRepresentacao"
                            for="representacaoRepresentacao"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>
                    <div class="col-12" v-if="form.representacaoConselho.value === 1">
                        <div class="col-12" v-if="form.representacaoRepresentacao.value === 1">
                            <q-select
                                v-model="form.representacaoSegmento"
                                :options="parametros.representacaoRepresentacaoList"
                                label="Representação*"
                                name="representacaoSegmento"
                                for="representacaoSegmento"
                                outlined
                                clearable
                                :rules="[isRequired]"
                            />
                        </div>

                        <div class="col-12" v-if="form.representacaoRepresentacao.value === 2">
                            <q-select
                                v-model="form.representacaoSegmento"
                                :options="parametros.representacaoSegmentoList"
                                label="Representação*"
                                name="representacaoSegmento"
                                for="representacaoSegmento"
                                outlined
                                clearable
                                :rules="[isRequired]"
                            />
                        </div>
                        <div class="col-12" v-if="form.representacaoSegmento.value === 1">
                            <q-select
                                v-model="form.representacaoAreaRepresentada"
                                :options="parametros.representacaoAreaRepresentadaList"
                                label="Área Representada*"
                                name="representacaoAreaRepresentada"
                                for="representacaoAreaRepresentada"
                                outlined
                                clearable
                                :rules="[isRequired]"
                            />
                        </div>

                        <div class="col-12" v-if="form.representacaoAreaRepresentada === 'Outros'">
                            <q-input
                                v-model="form.outrosRepresentacaoAreaRepresentada"
                                label="Informe qual é o sua área representada*"
                                name="outrosRepresentacaoAreaRepresentada"
                                for="outrosRepresentacaoAreaRepresentada"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                    </div>
                    <div class="col-12" v-else>
                        <div class="col-12" v-if="form.representacaoRepresentacao.value === 1">
                            <q-select
                                v-model="form.representacaoSegmento"
                                :options="parametros.representacaoGovernamentalConselheiroList"
                                label="Representação*"
                                name="representacaoSegmento"
                                for="representacaoSegmento"
                                outlined
                                clearable
                                :rules="[isRequired]"
                            />
                        </div>


                        <div class="col-12" v-if="form.representacaoRepresentacao.value === 2">
                            <q-select
                                v-model="form.representacaoSegmento"
                                :options="parametros.areaRepresentadaCivilList"
                                label="Representação*"
                                name="representacaoSegmento"
                                for="representacaoSegmento"
                                outlined
                                clearable
                                :rules="[isRequired]"
                            />
                        </div>
                    </div>
                    <div class="col-12">
                        <q-select
                            v-model="form.representacaoTitularidade"
                            :options="parametros.representacaoTitularidadeList"
                            label="Titularidade*"
                            name="representacaoTitularidade"
                            for="representacaoTitularidade"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>
                </div>
            </div>
        </q-card-section>
    </q-card>
</template>

<script>
import {mapGetters} from "vuex";
import * as parametros from '../../mixins/parameters';

export default {
    name: "ProfessionalData",
    data() {
        return {
            parametros,
            form: {
                regional: "",
                lotacao: "",
                creasRegional: "",
                outrosPublicos: "",
                outrosPublicosOutro: "",
                parceirosInscInterna: "",
                funcaoOutro: "",
                municipio: "",
                superintendencia: "",
                diretoriaRegionalDesSocial: "",
                protecaoSocialBasica: "",
                protecaoSocialEspecialEstadual: "",
                vigilanciaCapacitacao: "",
                vinculoEmpregaticio: "",
                vinculoEmpregaticioOutro: "",
                funcao: "",
                orgao: "",
                areadeAtuacao: "",
                beneficiosMunicipal: "",
                beneficiosMunicipalOutro: "",
                protecaoSocialEspecialMunicipal: "",
                servicosPrograma: "",
                servicosProgramaOutro: "",
                representante: "",
                areaRepresentada: "",
                areaRepresentadaOutro: "",
                cargo: "",
                possuiRepresentacao: false,
                representacaoConselho: "",
                representacaoTitularidade: "",
                representacaoRepresentacao: "",
                representacaoSegmento: "",
                representacaoAreaRepresentada: "",
                outrosRepresentacaoAreaRepresentada: "",
                seguimento_governo: "",

            },
            parceirosInscInternaList: [],
            filterMunicipios: [],
            filterLotacao: [],
            regionalList: parametros.regionalList,
        };
    },
    computed: {
        ...mapGetters(["user"]),
        areaRepresentadaOutro() {
            return this.areaRepresentada === "Outro";
        },
    },
    methods: {
        isRequired(value, errorMessage = "Campo obrigatório") {
            return !!value || errorMessage;
        },
        limparCamposCeasFuncaoDesempenhada() {
            if (this.form.funcao === 'Secretaria Executiva') {
                this.form.ceas_representacao = '';
                // this.form.representacaoTitularidade = '';
                this.form.ceas_titularidade = '';
                this.form.representacaoAreaRepresentada = '';
                this.form.outrosRepresentacaoAreaRepresentada = '';
            }
            if (this.form.funcao === 'Conselheiro') {
                this.form.ceas_representacao = '';
            }
        },
        limparCamposCeasSegmento() {
            this.form.seguimento_governo = '';
            this.form.representacaoAreaRepresentada = '';
            this.form.ceas_titularidade = '';
            this.form.representacaoTitularidade = '';
            this.form.representacaoSegmento = '';
            if (this.form.representacaoAreaRepresentada !== 'Outros') {
                this.form.outrosRepresentacaoAreaRepresentada === '';
            }
        },
        limparCamposCeasRepresentacao() {
            // this.form.seguimento_governo.value
            this.form.representacaoAreaRepresentada = '';
        },
        async getMunicipios() {
            try {
                const {data, status} = await this.$http.get(`ambitoatuacao/regiaoadm/2`);
                if (status === 200) {
                    this.allMunicipios = data.map((ele) => {
                        return {
                            ...ele,
                            label: ele.nome,
                            value: ele.id,
                        };
                    });
                    this.filterMunicipios = this.allMunicipios;
                }
            } catch (error) {
                return error;
            }
        },
        async getLotacao() {
            try {
                const {data, status} = await this.$http.get(`ambitoatuacao/regiaoadm/1`);
                if (status === 200) {
                    this.allLotacao = data.map((ele) => {
                        return {
                            ...ele,
                            label: ele.nome,
                            value: ele.id,
                        };
                    });
                    this.filterLotacao = this.allLotacao;
                }
            } catch (error) {
                return error;
            }
        },
        limparVinculoEmpregaticio() {
            this.form.vinculoEmpregaticioOutro = '';
        }
    },
    watch: {
        filterLotacao (val) {
            this.form.lotacao = val.find(
                (el) => el.value === JSON.parse(localStorage.getItem("user")).secretary
            );
        },
        filterMunicipios (val) {
            this.form.municipio = val.find(
                (el) => el.value === JSON.parse(localStorage.getItem("user")).secretary
            );
        },
        "form.lotacao": function () {
            this.form.superintendencia = "";
            this.form.diretoriaRegionalDesSocial = "";
            this.form.vigilanciaCapacitacao = "";
            this.form.protecaoSocialBasica = "";
            this.form.protecaoSocialEspecialEstadual = "";
        },
        "form.superintendencia": function () {
            this.form.diretoriaRegionalDesSocial = "";
            this.form.vigilanciaCapacitacao = "";
            this.form.protecaoSocialBasica = "";
            this.form.protecaoSocialEspecialEstadual = "";
        },
        "form.areadeAtuacao": function () {
            this.form.servicosPrograma = "";
            this.form.protecaoSocialBasicaMunicipal = "";
            this.form.beneficiosMunicipal = "";
            this.form.protecaoSocialEspecialMunicipal = "";
            this.form.socialEspecialMunicipalMediaComplexidade = "";
            this.form.socialEspecialMunicipalAltaComplexidade = "";
            this.form.gestaoDoSuas = "";
            this.form.gestaoFinanceiraOrcamentariaSuas = "";
            this.form.conselheiro = "";
            this.form.representante = "";
            this.form.areaRepresentada = "";
            this.form.areaRepresentadaOutro = "";
        },
        "form.orgao": function () {
            this.form.areadeAtuacao = "";
            this.form.servicosPrograma = "";
            this.form.protecaoSocialBasicaMunicipal = "";
            this.form.beneficiosMunicipal = "";
            this.form.protecaoSocialEspecialMunicipal = "";
            this.form.socialEspecialMunicipalMediaComplexidade = "";
            this.form.socialEspecialMunicipalAltaComplexidade = "";
            this.form.gestaoDoSuas = "";
            this.form.gestaoFinanceiraOrcamentariaSuas = "";
            this.form.conselheiro = "";
            this.form.representante = "";
            this.form.areaRepresentada = "";
            this.form.areaRepresentadaOutro = "";
        },
        regional(val) {
            if (val.value === 2) this.orgao = this.orgaoList[0];
        },
        form: {
            handler() {
                this.$emit("professional", this.form);
            },
            deep: true,
        },
        'form.representacaoAreaRepresentada'(newValue, oldValue) {
            if (oldValue === 'Outros') {
                this.form.outrosRepresentacaoAreaRepresentada = null;
            }
        },
    },
    created() {
        this.getMunicipios();
        this.getLotacao();
        this.form.regional = this.regionalList.find(
            (el) => el.value === +JSON.parse(localStorage.getItem("user")).service
        );
    },
};
</script>
