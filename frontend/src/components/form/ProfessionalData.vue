<template>
    <q-card flat>
        <q-card-section>
            <div class="row q-col-gutter-y-md">
                <div class="col-12">
                    <q-select
                        v-model="form.regional"
                        :options="regionalList"
                        label="Região Administrativa"
                        name="regional"
                        for="regional"
                        outlined
                        :rules="[isRequired]"
                        disable
                    />
                </div>
                <!-- ESTADUAL -->
                <div class="col-12 row q-col-gutter-y-md" v-if="form.regional.value === 1">

<!--                    <div class="col-12" >-->
<!--                        <q-select-->
<!--                          v-model="form.municipio"-->
<!--                          :options="filterMunicipios"-->
<!--                          label="Município onde atua"-->
<!--                          outlined-->
<!--                          :rules="[isRequired]"-->
<!--                        />-->
<!--                    </div>-->

                    <div class="col-12">
                        <q-select
                            v-model="form.lotacao"
                            :options="filterLotacao"
                            label="Lotação"
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
                            :options="superintendenciaList"
                            label="Superintendência/Assessoria"
                            name="superintendencia"
                            for="superintendencia"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>

                    <div class="col-12" v-if="form.lotacao.label === 'Diretoria Regional de Desenvolvimento Social'">
                        <q-select
                            v-model="form.diretoriaRegionalDesSocial"
                            :options="diretoriaRegionalDesSocialList"
                            label="Diretorias"
                            name="diretoriaRegionalDesSocial"
                            for="diretoriaRegionalDesSocial"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>

                    <div class="col-12" v-if="form.lotacao.label === 'CREAS Regional'">
                        <q-select
                            v-model="form.creasRegional"
                            :options="creasRegionalList"
                            label="Unidade"
                            name="creasRegional"
                            for="creasRegional"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>
                    <div class="col-12" v-if="form.lotacao.label === 'Outros Públicos'">
                        <q-select
                            v-model="form.outrosPublicos"
                            :options="outrosPublicosList"
                            name="outrosPublicos"
                            for="outrosPublicos"
                            label="Órgão de Atuação"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>
                    <div class="col-12" v-if="form.outrosPublicos.value === 8">
                        <q-input
                            v-model="form.outrosPublicosOutro"
                            label="Informe qual é o seu órgão de atuação"
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
                            label="Parceiros"
                            name="parceirosInscInterna"
                            for="parceirosInscInterna"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>
                    <div class="col-12" v-if="form.superintendencia.value === 1">
                        <q-select
                            v-model="form.protecaoSocialBasica"
                            :options="protecaoSocialBasicaList"
                            label="Diretorias"
                            name="protecaoSocialBasica"
                            for="protecaoSocialBasica"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>
                    <div class="col-12" v-if="form.superintendencia.value === 2">
                        <q-select
                            v-model="form.protecaoSocialEspecialEstadual"
                            :options="protecaoSocialEspecialEstadualList"
                            label="Diretorias"
                            name="protecaoSocialEspecialEstadual"
                            for="protecaoSocialEspecialEstadual"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>
                    <div class="col-12" v-if="form.superintendencia.value === 3">
                        <q-select
                            v-model="form.vigilanciaCapacitacao"
                            :options="vigilanciaCapacitacaoList"
                            label="Diretorias"
                            name="vigilanciaCapacitacao"
                            for="vigilanciaCapacitacao"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>


                    <div class="col-12" v-if="form.regional.value === 1">
                        <q-select
                            v-model="form.funcao"
                            :options="funcaoDesempenhadaList"
                            label="Função desempenhada"
                            name="funcao"
                            for="funcao"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>
                    <div class="col-12" v-if="form.funcao === 'Outro'">
                        <q-input
                            v-model="form.funcaoOutro"
                            label="Função Outro"
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
                </div>

                <!-- MUNICIPAL -->
                <div class="col-12 row q-col-gutter-y-md" v-if="form.regional.value === 2">
                    <div class="col-12">
                        <q-select
                            v-model="form.orgao"
                            :options="orgaoList"
                            label="Orgão"
                            name="orgao"
                            for="orgao"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>

                    <div class="col-12">
                        <q-select
                            v-model="form.municipio"
                            :options="filterMunicipios"
                            label="Município onde atua"
                            name="municipio"
                            for="municipio"
                            outlined
                            :rules="[isRequired]"
                            disable
                        />
                    </div>

                    <!-- Opções de input dependendo do valor do campo Orgão -->
                    <div class="col-12" v-if="form.orgao.value === 1">
                        <q-select
                            v-model="form.areadeAtuacao"
                            :options="areadeAtuacaoList1"
                            label="Área de atuação"
                            name="areadeAtuacao"
                            for="areadeAtuacao"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>

                    <!-- Opções de input dependendo do valor do campo Área de atuação -->
                    <div class="col-12" v-if="form.orgao.value === 1 && form.areadeAtuacao.value === 1">
                        <q-select
                            v-model="form.servicosPrograma"
                            :options="protecaoSocialList"
                            label="Serviço/Programa"
                            name="servicosPrograma"
                            for="servicosPrograma"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>

                    <!-- Opções de input dependendo do valor do campo Serviço/Programa -->
                    <template v-if="form.servicosPrograma.value === 4">
                        <div class="col-12">
                            <q-select
                                v-model="form.beneficiosMunicipal"
                                :options="beneficioslList"
                                label="Benefício"
                                name="beneficiosMunicipal"
                                for="beneficiosMunicipal"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                        <div class="col-12" v-if="form.beneficiosMunicipal === 'Outro'">
                            <q-input
                                v-model="form.beneficiosMunicipalOutro"
                                label="Outro - Benefícios"
                                name="beneficiosMunicipalOutro"
                                for="beneficiosMunicipalOutro"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                    </template>

                    <!-- Opções de input dependendo do valor do campo Orgão -->
                    <div class="col-12" v-if="form.orgao.value === 2">
                        <q-select
                            v-model="form.representante"
                            :options="representanteList"
                            label="Representante"
                            name="representante"
                            for="representante"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>

                    <!-- Opções de input dependendo do valor do campo Representante -->
                    <div class="col-12" v-if="form.representante.value === 1">
                        <q-select
                            v-model="form.areaRepresentada"
                            :options="areaRepresentadaGovernamentalList"
                            label="Área representada"
                            name="areaRepresentada"
                            for="areaRepresentada"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>

                    <div class="col-12" v-if="form.representante.value === 1 && form.areaRepresentada === 'Outro'">
                        <q-input
                            v-model="form.areaRepresentadaOutro"
                            label="Outro - Área representada"
                            name="areaRepresentadaOutro"
                            for="areaRepresentadaOutro"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>

                    <div class="col-12" v-if="form.representante.value === 2">
                        <q-select
                            v-model="form.areaRepresentada"
                            :options="areaRepresentadaCivilList"
                            label="Área representada"
                            name="areaRepresentada"
                            for="areaRepresentada"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>

                    <div class="col-12" v-if="form.orgao.value === 3">
                        <q-select
                            v-model="form.areadeAtuacao"
                            :options="areadeAtuacaoList2"
                            label="Área de Atuação"
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
                            :options="areadeAtuacaoList2"
                            label="Área de Atuação"
                            name="areadeAtuacao"
                            for="areadeAtuacao"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>

                    <div class="col-12" v-if="form.areadeAtuacao.value === 2">
                        <q-select
                            v-model="form.protecaoSocialEspecialMunicipal"
                            :options="protecaoSocialEspecialMunicipalList"
                            label="Nível de Complexidade"
                            name="protecaoSocialEspecialMunicipal"
                            for="protecaoSocialEspecialMunicipal"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>

                    <!-- Opções de input dependendo do valor do campo Proteção Social Especial -->
                    <div class="col-12" v-if="form.protecaoSocialEspecialMunicipal.value === 1">
                        <q-select
                            v-model="form.servicosPrograma"
                            :options="socialEspecialMediaComplexidadeList"
                            label="Serviço/Programa"
                            name="servicosPrograma"
                            for="servicosPrograma"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>

                    <div class="col-12" v-if="form.areadeAtuacao.value === 2 && form.protecaoSocialEspecialMunicipal.value === 2">
                        <q-select
                            v-model="form.servicosPrograma"
                            :options="socialEspecialAltaComplexidadeList"
                            label="Serviço/Programa"
                            name="servicosPrograma"
                            for="servicosPrograma"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>

                    <!-- Opções de input dependendo do valor do campo Área de atuação -->
                    <div class="col-12" v-if="form.areadeAtuacao.value === 3">
                        <q-select
                            v-model="form.servicosPrograma"
                            :options="gestaoDoSuasList"
                            label="Serviço/Programa"
                            name="servicosPrograma"
                            for="servicosPrograma"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>

                    <div class="col-12" v-if="form.areadeAtuacao.value === 3 && form.servicosPrograma === 'Outro'">
                        <q-input
                            v-model="form.servicosProgramaOutro"
                            label="Outro - Serviço/Programa"
                            name="servicosProgramaOutro"
                            for="servicosProgramaOutro"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>

                    <!-- Opções de input dependendo do valor do campo Área de atuação -->
                    <div class="col-12" v-if="form.areadeAtuacao.value === 4">
                        <div class="col-12" v-if="form.areadeAtuacao.value === 4 && form.servicosPrograma === 'Outro'">
                            <q-input
                                v-model="form.servicosProgramaOutro"
                                label="Outro - Serviço/Programa"
                                name="servicosProgramaOutro"
                                for="servicosProgramaOutro"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                        <q-select
                            v-model="form.servicosPrograma"
                            :options="gestaoFinanceiraOrcamentariaSuasList"
                            label="Serviço/Programa"
                            name="servicosPrograma"
                            for="servicosPrograma"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>
                    <template v-if="false">
                        <div class="col-12">
                            <q-select
                                v-model="form.areaRepresentada"
                                :options="areaRepresentadaList"
                                label="Área Representada"
                                name="areaRepresentada"
                                for="areaRepresentada"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                        <div class="col-12" v-if="areaRepresentadaOutro">
                            <q-input
                                v-model="areaRepresentadaOutro"
                                label="Outro - Área Representada"
                                name="areaRepresentadaOutro"
                                for="areaRepresentadaOutro"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                    </template>

                    <div class="col-12" v-if="form.areaRepresentada !== ''">
                        <q-select
                            v-model="form.cargo"
                            :options="cargoList"
                            label="Cargo"
                            name="cargo"
                            for="cargo"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>
                    <div class="col-12">
                        <q-select
                            v-model="form.funcao"
                            :options="funcaoDesempenhadaList"
                            label="Função desempenhada"
                            name="funcao"
                            for="funcao"
                            outlined
                            :rules="[isRequired]"
                        />
                    </div>
                </div>

                <div class="col-12" v-if="form.orgao.value !== 2 && form.orgao.value !== 5">
                    <q-select
                        v-model="form.vinculoEmpregaticio"
                        :options="vinculoEmpregaticioList"
                        label="Vínculo empregaticio"
                        name="vinculoEmpregaticio"
                        for="vinculoEmpregaticio"
                        outlined
                        :rules="[isRequired]"
                    />
                </div>

                <div class="col-12" v-if="form.vinculoEmpregaticio === 'Outro'">
                    <q-input
                        v-model="form.vinculoEmpregaticioOutro"
                        label="Informe qual é o seu vínculo empregatício"
                        name="vinculoEmpregaticioOutro"
                        for="vinculoEmpregaticioOutro"
                        outlined
                        :rules="[isRequired]"
                    />
                </div>

                <div class="col-12" v-if="form.regional.value === 2">
                    <q-toggle
                        v-model="form.possuiRepresentacao"
                        label="Possui também alguma representação em conselho de assistência social (municipal ou estadual)?"
                    />
                </div>

                <div class="col-12" v-if="form.possuiRepresentacao">
                    <q-select
                        v-model="form.representacaoConselho"
                        :options="representacaoConselhoList"
                        label="Conselho"
                        name="representacaoConselho"
                        for="representacaoConselho"
                        outlined
                        :rules="[isRequired]"
                    />
                </div>

                <div class="col-12" v-if="form.possuiRepresentacao">
                    <q-select
                        v-model="form.representacaoTitularidade"
                        :options="representacaoTitularidadeList"
                        label="Titularidade"
                        name="representacaoTitularidade"
                        for="representacaoTitularidade"
                        outlined
                        :rules="[isRequired]"
                    />
                </div>

                <div class="col-12" v-if="form.possuiRepresentacao">
                    <q-select
                        v-model="form.representacaoRepresentacao"
                        :options="representacaoRepresentacaoList"
                        label="Representação"
                        name="representacaoRepresentacao"
                        for="representacaoRepresentacao"
                        outlined
                        :rules="[isRequired]"
                    />
                </div>

                <div class="col-12" v-if="form.possuiRepresentacao">
                    <q-select
                        v-model="form.representacaoSegmento"
                        :options="representacaoSegmentoList"
                        label="Seguimento"
                        name="representacaoSegmento"
                        for="representacaoSegmento"
                        outlined
                        :rules="[isRequired]"
                    />
                </div>

                <div class="col-12" v-if="form.possuiRepresentacao">
                    <q-select
                        v-model="form.representacaoAreaRepresentada"
                        :options="representacaoAreaRepresentadaList"
                        label="Área Representada"
                        name="representacaoAreaRepresentada"
                        for="representacaoAreaRepresentada"
                        outlined
                        :rules="[isRequired]"
                    />
                </div>

                <div class="col-12" v-if="form.representacaoAreaRepresentada === 'Outros'">
                    <q-input
                        v-model="form.outrosRepresentacaoAreaRepresentada"
                        label="Informe qual é o sua área representada"
                        name="outrosRepresentacaoAreaRepresentada"
                        for="outrosRepresentacaoAreaRepresentada"
                        outlined
                        :rules="[isRequired]"
                    />
                </div>

            </div>
        </q-card-section>
    </q-card>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "ProfessionalData",
    data() {
        return {
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

            },
            parceirosInscInternaList: [],
            regionalList: [
                {value: 1, label: "Estadual"},
                {value: 2, label: "Municipal"},
            ],
            /* ESTADUAL */
            creasRegionalList: [
                {value: 1, label: "CREAS Regional Alto Jequitinhonha"},
                {value: 2, label: "CREAS Regional Médio/Baixo Jequitinhonha"},
                {value: 3, label: "CREAS Regional Mucuri"},
                {value: 4, label: "CREAS Regional Vale do Rio Doce"},
            ],

            outrosPublicosList: [
                {value: 1, label: "Minitério Público"},
                {value: 2, label: "Direitos Humanos"},
                {value: 3, label: "Defesa Civil"},
                {value: 4, label: "Saúde"},
                {value: 5, label: "Educação"},
                {value: 6, label: "Esportes"},
                {value: 7, label: "Trabalho e Emprego"},
                {value: 8, label: "Outros"},
            ],
            filterMunicipios: [],
            filterLotacao: [],
            superintendenciaList: [
                {value: 1, label: "Superintendência de Proteção Social Básica"},
                {value: 2, label: "Superintendência de Proteção Social Especial"},
                {value: 3, label: "Superintendência de Vigilância e Capacitação"},
                {value: 4, label: "Assessoria de gestão do Fundo Estadual de Assistência Social",},
                {value: 5, label: "Gabinete"},
            ],
            protecaoSocialBasicaList: [
                "Diretoria de Serviços e Benefícios Socioassistenciais",
                "Diretoria de Gestão do Cadastro Único e Programas Socioassistenciais",
                "Não se aplica",
            ],
            protecaoSocialEspecialEstadualList: [
                "Diretoria de Proteção Social Especial de Média Complexidade",
                "Diretoria de Proteção Social Especial de Alta Complexidade",
                "Não se aplica",
            ],
            vigilanciaCapacitacaoList: [
                "Diretoria de Vigilância Socioassistencial",
                "Diretoria de Educação Permanente do SUAS",
                "Diretoria de Gestão Descentralizada e Regulação do SUAS",
                "Não se aplica",
            ],
            vinculoEmpregaticioList: [
                "Comissionado",
                "Contratado",
                "Efetivo",
                "Estatutário",
                "Estagiário",
                "Temporário",
                "Outro",
            ],
            funcaoList: [
                "Profissional de Nível Superior",
                "Profissional de Nível Médio",
                "Superintendente",
                "Diretor(a)",
                "Estagiário",
                "Auxiliar/Assessor",
                "Coordenação",
                "Outro",
            ],
            funcaoDesempenhadaList: [
                "Profissional de Nível Superior",
                "Profissional de Nível Médio",
                "Gestor de assistência social",
                "Coordenador",
                "Conselheiro",
                "Estagiário",
                "Secretaria Executiva",
                "Assessor(a)",
            ],
            diretoriaRegionalDesSocialList: [
                "Almenara",
                "Araçuaí",
                "Curvelo",
                "Diamantina",
                "Divinópolis",
                "Governador Valadares",
                "Ituiutaba",
                "Juiz de Fora",
                "Metropolitana",
                "Montes Claroes",
                "Muriaé",
                "Paracatu",
                "Passos",
                "Patos de Minas",
                "Poços de Caldas",
                "Salinas",
                "São João Del Rei",
                "Teófilo Otoni",
                "Timóteo",
                "Uberaba",
                "Uberlândia",
                "Varginha",
            ],
            /* MUNICIPAL */
            orgaoList: [
                {value: 1, label: "Secretaria Municipal de Assistência Social"},
                {value: 2, label: "Conselho Municipal de Assistência Social"},
                {value: 3, label: "Entidades e Organizações de Assistência Social"},
                {value: 4, label: "Outras secretarias/orgãos da Prefeitura"},
                {value: 5, label: "Conselho Tutelar"},
            ],
            areadeAtuacaoList1: [
                {value: 1, label: "Proteção Social Básica"},
                {value: 2, label: "Proteção Social Especial"},
                {value: 3, label: "Gestão do SUAS"},
                {value: 4, label: "Gestão Financeira e Orçamentária do SUAS"},
            ],
            areadeAtuacaoList2: [
                {value: 5, label: "Atendimento"},
                {value: 6, label: "Assessoramento"},
                {value: 7, label: "Defesa e garantia de direitos"},
            ],
            protecaoSocialList: [
                {value: 1,label: "Serviço de Proteção e Atendimento Integral à Família (PAIF)",},
                {value: 2,label: "Serviço de Convivência e Fortalecimento de Vínculos (SCFV)",},
                {value: 3,label:"Serviço de Proteção Social Básica no Domicílio para pessoas com deficiência e idosas",},
                {value: 4,label: "Gestão de Benefícios Socioassistenciais/Cad. Único",},
            ],
            beneficioslList: [
                "Programa Bolsa Família e/ou outra ação de transferência de renda",
                "Benefício de Prestação Continuada (BPC)",
                "Benefício Eventuais",
                "Outro",
            ],
            protecaoSocialEspecialMunicipalList: [
                {value: 1, label: "Média Complexidade"},
                {value: 2, label: "Alta Complexidade"},
            ],
            socialEspecialMediaComplexidadeList: [
                "Serviço de Proteção e Atendimento Especializado a Famílias e Indivíduos (PAEFI)",
                "Serviço Especializado em Abordagem Social",
                "Serviço de Proteção Social a adolescentes em cumprimentos de medida socioeducativa de Liberdade Assistida (LA) e Prestação a Serviços à Comunidade (PSC)",
                "Serviço de Proteção Social Especial para Pessoas com Deficiência, Idosas e suas Famílias",
                "Serviço Especializado para Pessoas em Situação de Rua",
            ],
            socialEspecialAltaComplexidadeList: [
                "Serviço de Acolhimento Institucional",
                "Serviço de Acolhimento em República",
                "Serviço de Acolhimento em Família Acolhedora",
                "Serviço de proteção em situações de calamidades públicas e de emergências",
            ],
            gestaoDoSuasList: [
                "Vigilância Socioassistencial(Monitoramento)",
                "Gestão do Trabalho/Educação Permanente do SUAS",
                "Regulação do SUAS",
                "Outro",
            ],
            gestaoFinanceiraOrcamentariaSuasList: [
                "Gestão Financeira e Orçamentária(FMAS)",
                "Outro",
            ],
            conselheiroList: [
                {value: 1, label: "Representação"},
                {value: 2, label: "Área Representada"},
                {value: 3, label: "Cargo"},
            ],
            representanteList: [
                {value: 1, label: "Governamental"},
                {value: 2, label: "Sociedade Civil"},
            ],
            areaRepresentadaGovernamentalList: [
                "Assistência Social",
                "Saúde",
                "Educação",
                "Trabalho e Emprego",
                "Fazenda",
                "Habitação",
                "Planejamento",
                "Assessoria/Gabinete da Prefeitura",
                "Outro",
            ],
            areaRepresentadaCivilList: [
                {value: 1, label: "Usuário"},
                {value: 2, label: "Trabalhador"},
                {value: 3, label: "Entidade"},
            ],
            cargoList: [
                {value: 1, label: "Titular"},
                {value: 2, label: "Suplente"},
                {value: 3, label: "Presidente"},
                {value: 4, label: "Vice-Presidente"},
                {value: 5, label: "Membro"},
            ],
            representacaoConselhoList: [
                "Conselho Estadual de Assistência Social (CEAS)",
                "Conselho Municipal de Assistência Social (CMAS)"
            ],
            representacaoTitularidadeList: [
                "Titular",
                "Suplente",
                "Presidente",
                "Vice-Presidente",
                "Apenas Membro",
            ],
            representacaoRepresentacaoList: ["Governamental", "Não governamental"],
            representacaoSegmentoList: [
                "Representante de Governo",
                "Representante dos Usuários ou de organização de usuários da assistência social",
                "Representante de entidades e organizações de assistência Social",
                "Representante entidades de trabalhadores do setor",
            ],
            representacaoAreaRepresentadaList: [
                "Assistência Social",
                "Saúde",
                "Educação",
                "Trabalho e Emprego",
                "Fazenda",
                "Habitação",
                "Planejamento",
                "Assessoria/Gabinete da Prefeitura",
                "Usuário",
                "Trabalhador",
                "Entidade",
                "Outros",
            ],
        };
    },
    computed: {
        ...mapGetters(["user"]),
        areaRepresentadaOutro() {
            return this.areaRepresentada === "Outro";
        },
    },
    methods: {
        isRequired(value) {
            return !!value || "Campo obrigatório";
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
                console.log(error);
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
                console.log(error);
            }
        },
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
