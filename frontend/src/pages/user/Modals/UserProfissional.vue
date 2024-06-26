<template>
    <q-dialog v-model="modalAbrir">
        <q-card style="width: 80%; max-width: 80vw;">
            <q-card-section>
                <h6 style="margin:0px; padding: 0px;"><q-icon name="sym_o_home_work" color="primary" /> Editar Dados
                    Profissionais <sup class="text-white">{{ profissional.regional }}</sup></h6>
            </q-card-section>
            <q-card-section>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <q-select
                            outlined
                            v-model="profissionalData.regional"
                            :options="services"
                            label="Âmbito de Atuação"
                            :rules="[isRequired]"
                            lazy-rules
                            style="padding: 0 5px"
                            emit-value
                            map-options
                        >
                            <template v-slot:prepend>
                                <q-icon name="corporate_fare" class="cursor-pointer" />
                            </template>
                            <template v-slot:no-option>
                                <q-item>
                                    <q-item-section class="text-grey">
                                        Nenhum item disponível
                                    </q-item-section>
                                </q-item>
                            </template>
                            <template v-slot:options="{ option, selected }">
                                <q-item :key="option.value" v-if="option.value === '1' || option.value === '2'">
                                    <q-item-section>
                                        <q-item-label v-if="selected">
                                            {{ option.label }}
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
                            </template>
                        </q-select>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12" v-if="profissionalData.regional === 2 || profissionalData.regional === 'Municipal'">
                        <q-select
                            outlined
                            v-model="user.secretaria"
                            :options="filterMunicipios"
                            label="Município"
                            name="municipio"
                            :rules="[isRequired]"
                            lazy-rules
                            emit-value
                            map-options
                            @update:model-value="handleSelectionChangeMinicipio"
                        >
                            <template v-slot:prepend>
                                <q-icon name="mdi-domain" class="cursor-pointer" />
                            </template>

                            <template v-slot:no-option>
                                <q-item>
                                    <q-item-section class="text-grey">
                                        Sem resultados!
                                    </q-item-section>
                                </q-item>
                            </template>
                        </q-select>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12"  v-if="profissionalData.regional === 1 || profissionalData.regional === 'Estadual'">
                        <q-select
                            outlined
                            v-model="profissionalData.lotacao"
                            :options="filterLotacao"
                            label="Lotação"
                            :rules="[isRequired]"
                            lazy-rules
                            emit-value
                            map-options
                            input-debounce="0"
                            @update:model-value="handleSelectionChange"
                        >
                            <template v-slot:prepend>
                                <q-icon name="mdi-domain" class="cursor-pointer" />
                            </template>

                            <template v-slot:no-option>
                                <q-item>
                                    <q-item-section class="text-grey">
                                        Sem resultados!
                                    </q-item-section>
                                </q-item>
                            </template>
                        </q-select>
                    </div>
                </div>
            </q-card-section>
            <q-card-section>
                <div class="row q-col-gutter-y-md">
                    <!-- ESTADUAL -->
                    <div class="col-12 row q-col-gutter-y-md" v-if="profissionalData.regional === 1 || profissionalData.regional === 'Estadual'">
                        <div class="col-12">
                            {{ profissionalData.lotacao }} || {{ profissionalData.outros_publicos }} || {{ profissionalData.outros_publicos_others }} || {{ profissionalData.creas_regional }}
                        </div>
                        <div class="col-12" v-if="profissionalData.lotacao === 'Subsecretaria de Assistência Social'">
                            <q-select
                                v-model="profissionalData.superintendencia"
                                :options="parametros.superintendenciaList"
                                label="Superintendência/Assessoria*"
                                name="superintendencia"
                                for="superintendencia"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>

                        <div class="col-12" v-if="profissionalData.lotacao === 'Diretoria Regional de Desenvolvimento Social'">
                            <q-select
                                v-model="profissionalData.diretoria_regional_des_social"
                                :options="parametros.diretoriaRegionalDesSocialList"
                                label="Diretoria*"
                                name="diretoriaRegionalDesSocial"
                                for="diretoriaRegionalDesSocial"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>

                        <div class="col-12" v-if="profissionalData.lotacao === 'CREAS Regional'">
                            <q-select
                                v-model="profissionalData.creas_regional"
                                :options="parametros.creasRegionalList"
                                label="Unidade*"
                                name="creasRegional"
                                for="creasRegional"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                        <div class="col-12" v-if="profissionalData.lotacao === 'Outros Públicos'">
                            <q-select
                                v-model="profissionalData.outros_publicos"
                                :options="parametros.outrosPublicosList"
                                name="outrosPublicos"
                                for="outrosPublicos"
                                label="Órgão de Atuação*"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                        <div class="col-12" v-if="profissionalData.outros_publicos?.value === 8 || profissionalData.outros_publicos === 'Outros'">
                            <q-input
                                v-model="profissionalData.outros_publicos_others"
                                label="Informe qual é o seu órgão de atuação*"
                                name="outrosPublicosOutro"
                                for="outrosPublicosOutro"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                        <div class="col-12" v-if="profissionalData.superintendencia?.value === 1 || profissionalData.superintendencia === 'Diretoria de Serviços e Benefícios Socioassistenciais'">
                            <q-select
                                v-model="profissionalData.protecao_social_basica"
                                :options="parametros.protecaoSocialBasicaList"
                                label="Diretoria*"
                                name="protecaoSocialBasica"
                                for="protecaoSocialBasica"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>

                        <div class="col-12" v-if="profissionalData.superintendencia?.value === 2 || profissionalData.superintendencia === 'Diretoria de Gestão do Cadastro Único e Programas Socioassistenciais'">
                            <q-select
                                v-model="profissionalData.protecao_social_especial"
                                :options="parametros.protecaoSocialEspecialEstadualList"
                                label="Diretoria*"
                                name="protecaoSocialEspecialEstadual"
                                for="protecaoSocialEspecialEstadual"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                        <div class="col-12" v-if="profissionalData.superintendencia?.value === 3 || profissionalData.superintendencia === 'Não se aplica'">
                            <q-select
                                v-model="profissionalData.vigilancia_capacitacao"
                                :options="parametros.vigilanciaCapacitacaoList"
                                label="Diretoria*"
                                name="vigilanciaCapacitacao"
                                for="vigilanciaCapacitacao"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                        <div class="col-12" v-if="profissionalData.lotacao === 'Ceas'">
                            <q-select
                                v-model="profissionalData.funcao"
                                :options="parametros.funcaoDesempenhadaCeasList"
                                label="Função desempenhada*"
                                name="funcao"
                                for="funcao"
                                outlined
                                :rules="[isRequired]"
                                @update:model-value="limparCamposCeasFuncaoDesempenhada()"
                            />
                        </div>
                        <div class="col-12" v-else>
                            <q-select
                                v-model="profissionalData.funcao"
                                :options="parametros.funcaoDesempenhadaList"
                                label="Função desempenhada*"
                                name="funcao"
                                for="funcao"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                        <div class="col-12" v-if="profissionalData.funcao === 'Conselheiro'">
                            <q-select
                                v-model="profissionalData.representacao"
                                :options="parametros.funcaoDesempenhadaSecratariaList"
                                label="Segmento*"
                                name="segmento"
                                for="segmento"
                                outlined
                                :rules="[isRequired]"
                                @update:model-value="limparCamposCeasSegmento()"
                            />
                        </div>
                        <div class="col-12" v-if="profissionalData.representacao === 'Governamental'">
                            <div class="col-12">
                                <q-select
                                    v-model="profissionalData.representacao_segmento"
                                    :options="parametros.representacaoRepresentacaoList"
                                    label="Representação*"
                                    name="representação"
                                    for="representação"
                                    outlined
                                    :rules="[isRequired]"
                                    @update:model-value="limparCamposCeasRepresentacao()"
                                />
                            </div>
                            <div class="col-12" v-if="profissionalData.seguimento_governo === 'Assistência Social'">
                                <q-select
                                    v-model="profissionalData.representacao_area_representada"
                                    :options="parametros.representacaoAreaRepresentadaList"
                                    label="Área Representada*"
                                    name="representacaoAreaRepresentada"
                                    for="representacaoAreaRepresentada"
                                    outlined
                                    clearable
                                    :rules="[isRequired]"
                                />
                            </div>

                            <div class="col-12" v-if="profissionalData.representacao_area_representada === 'Outros'">
                                <q-input
                                    v-model="profissionalData.representacao_area_representada_outros"
                                    label="Informe qual é o sua área representada*"
                                    name="outrosRepresentacaoAreaRepresentada"
                                    for="outrosRepresentacaoAreaRepresentada"
                                    outlined
                                    :rules="[isRequired]"
                                />
                            </div>
                        </div>

                        <div class="col-12" v-if="profissionalData.seguimento_governo === 'Outro'">
                            <q-input
                                v-model="profissionalData.representacao_segmento"
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
                        <div class="col-12" v-if="profissionalData.representacao?.value === 2 || profissionalData.representacao === 'Sociedade Civil'">
                            <q-select
                                v-model="profissionalData.representacao"
                                :options="parametros.representacaoSegmentoList"
                                label="Representação*"
                                name="representação"
                                for="representação"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                        <div class="col-12" v-if="profissionalData.funcao === 'Outro'">
                            <q-input
                                v-model="profissionalData.funcao_outro"
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

                        <div class="col-12" v-if="profissionalData.funcao === 'Conselheiro'">
                            <q-select
                                v-model="profissionalData.representacao_titularidade"
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
                    <div class="col-12 row q-col-gutter-y-md" v-if="profissionalData.regional === 2 || profissionalData.regional === 'Municipal'">
                        <div class="col-12">
                            <q-select
                                v-model="profissionalData.orgao"
                                label="Orgão*"
                                name="orgao"
                                for="orgao"
                                outlined
                                :options="parametros.orgaoList"
                                :rules="[isRequired]"
                            />
                        </div>
                        <div class="col-12" v-if="profissionalData.orgao?.value === 2 || profissionalData.orgao === 'Conselho Municipal de Assistência Social'">
                            <q-select
                                v-model="profissionalData.funcao"
                                :options="parametros.funcaoDesempenhadaCeasList"
                                label="Função desempenhada*"
                                name="funcao"
                                for="funcao"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                        <div class="col-12" v-else-if="profissionalData.orgao?.value && profissionalData.orgao?.value !== 5 || profissionalData.orgao === 'Conselho Tutelar'">
                            <q-select
                                v-model="profissionalData.funcao"
                                :options="parametros.funcaoDesempenhadaList"
                                label="Função desempenhada*"
                                name="funcao"
                                for="funcao"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                        <div class="col-12" v-if="profissionalData.funcao === 'Conselheiro'">
                            <q-select
                                v-model="profissionalData.representante"
                                :options="parametros.representanteList"
                                label="Segmento*"
                                name="representante"
                                for="representante"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                        <div class="col-12" v-if="profissionalData.orgao?.value === 1 || profissionalData.orgao === 'Secretaria Municipal de Assistência Social'">
                            <q-select
                                v-model="profissionalData.area_de_atuacao"
                                :options="parametros.areadeAtuacaoList1"
                                label="Área de atuação*"
                                name="areadeAtuacao"
                                for="areadeAtuacao"
                                outlined
                                clearable
                                :rules="[isRequired]"
                            />

                            <div class="col-12" v-if="profissionalData.area_de_atuacao?.value === 1 || profissionalData.area_de_atuacao === 'Proteção Social Básica'">
                                <q-select
                                    v-model="profissionalData.servicos_programa"
                                    :options="parametros.protecaoSocialList"
                                    label="Serviço/Programa*"
                                    name="servicosPrograma"
                                    for="servicosPrograma"
                                    outlined
                                    :rules="[isRequired]"
                                />
                            </div>

                            <div class="col-12" v-if="profissionalData.servicos_programa?.value === 4 || profissionalData.servicos_programa === 'Gestão de Benefícios Socioassistenciais/Cad. Único'">
                                <div class="col-12">
                                    <q-select
                                        v-model="profissionalData.beneficios_municipal"
                                        :options="parametros.beneficioslList"
                                        label="Benefício*"
                                        name="beneficiosMunicipal"
                                        for="beneficiosMunicipal"
                                        outlined
                                        :rules="[isRequired]"
                                    />
                                </div>
                                <div class="col-12" v-if="profissionalData.beneficios_municipal === 'Outro'">
                                    <q-input
                                        v-model="profissionalData.beneficios_municipal_outro"
                                        label="Outro - Benefícios*"
                                        name="beneficiosMunicipalOutro"
                                        for="beneficiosMunicipalOutro"
                                        outlined
                                        :rules="[isRequired]"
                                    />
                                </div>
                            </div>

                            <div class="col-12" v-if="profissionalData.representante?.value === 1 || profissionalData.representante === 'Governamental'">
                                <div class="col-12">
                                    <q-select
                                        v-model="profissionalData.area_representada"
                                        :options="parametros.representacaoGovernamentalConselheiroList"
                                        label="Representação*"
                                        name="areaRepresentada"
                                        for="areaRepresentada"
                                        outlined
                                        clearable
                                        :rules="[isRequired]"
                                    />
                                </div>
                                <div class="col-12" v-if="profissionalData.area_representada === 'Outro'">
                                    <q-input
                                        v-model="profissionalData.area_representada_outros"
                                        label="Outro - Área representada*"
                                        name="areaRepresentadaOutro"
                                        for="areaRepresentadaOutro"
                                        outlined
                                        :rules="[isRequired]"
                                    />
                                </div>
                            </div>

                            <div class="col-12" v-if="profissionalData.representante?.value === 2 || profissionalData.representante === 'Sociedade Civil'">
                                <q-select
                                    v-model="profissionalData.area_representada"
                                    :options="parametros.areaRepresentadaCivilList"
                                    label="Representação*"
                                    name="areaRepresentada"
                                    for="areaRepresentada"
                                    outlined
                                    :rules="[isRequired]"
                                />
                            </div>
                        </div>
                        <div class="col-12" v-if="profissionalData.orgao?.value === 3 || profissionalData.orgao === 'Entidades e Organizações de Assistência Social'">
                            <q-select
                                v-model="profissionalData.area_de_atuacao"
                                :options="parametros.areadeAtuacaoList2"
                                label="Área de Atuação*"
                                name="areadeAtuacao"
                                for="areadeAtuacao"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>

                        <div class="col-12" v-if="profissionalData.area_de_atuacao?.value === 1 || profissionalData.area_de_atuacao ==='Proteção Social Básica'">
                            <q-select
                                v-model="profissionalData.area_de_atuacao"
                                :options="parametros.areadeAtuacaoList2"
                                label="Área de Atuação*"
                                name="areadeAtuacao"
                                for="areadeAtuacao"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>

                        <div class="col-12" v-if="profissionalData.area_de_atuacao?.value === 2 || profissionalData.area_de_atuacao === 'Proteção Social Especial'">
                            <q-select
                                v-model="profissionalData.protecaoSocialEspecialMunicipal"
                                :options="parametros.protecao_social_especial_municipal"
                                label="Nível de Complexidade*"
                                name="protecaoSocialEspecialMunicipal"
                                for="protecaoSocialEspecialMunicipal"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>

                        <div class="col-12" v-if="profissionalData.protecao_social_especial_municipal?.value === 1 || profissionalData.protecao_social_especial_municipal === 'Média Complexidade'">
                            <div class="col-12">
                                <q-select
                                    v-model="profissionalData.servicos_programa"
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
                            <div class="col-12" v-if="profissionalData.area_de_atuacao?.value === 2 || profissionalData.area_de_atuacao === 'Proteção Social Especial'">
                                <q-select
                                    v-model="profissionalData.servicos_programa"
                                    :options="parametros.socialEspecialAltaComplexidadeList"
                                    label="Serviço/Programa*"
                                    name="servicosPrograma"
                                    for="servicosPrograma"
                                    outlined
                                    :rules="[isRequired]"
                                />
                            </div>
                        </div>

                        <div class="col-12" v-if="profissionalData.area_de_atuacao?.value === 3 || profissionalData.area_de_atuacao === 'Gestão do SUAS'">
                            <div class="col-12">
                                <q-select
                                    v-model="profissionalData.servicos_programa"
                                    :options="parametros.gestaoDoSuasList"
                                    label="Serviço/Programa*"
                                    name="servicosPrograma"
                                    for="servicosPrograma"
                                    outlined
                                    :rules="[isRequired]"
                                />
                            </div>

                            <div class="col-12" v-if="profissionalData.servicos_programa === 'Outro'">
                                <q-input
                                    v-model="profissionalData.servicos_programa_outro"
                                    label="Outro - Serviço/Programa*"
                                    name="servicosProgramaOutro"
                                    for="servicosProgramaOutro"
                                    outlined
                                    :rules="[isRequired]"
                                />
                            </div>
                        </div>

                        <div class="col-12" v-if="profissionalData.area_de_atuacao?.value === 4 || profissionalData.area_de_atuacao === 'Gestão Financeira e Orçamentária do SUAS'">
                            <div class="col-12" v-if="profissionalData.servicos_programa === 'Outro'">
                                <q-input
                                    v-model="profissionalData.servicos_programa_outro"
                                    label="Outro - Serviço/Programa*"
                                    name="servicosProgramaOutro"
                                    for="servicosProgramaOutro"
                                    outlined
                                    :rules="[isRequired]"
                                />
                            </div>
                            <div class="col-12">
                                <q-select
                                    v-model="profissionalData.servicos_programa"
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
                                    v-model="profissionalData.area_de_atuacao"
                                    :options="parametros.representacaoAreaRepresentadaList"
                                    label="Área Representada*"
                                    name="areaRepresentada"
                                    for="areaRepresentada"
                                    outlined
                                    :rules="[isRequired]"
                                />
                            </div>
                            <div class="col-12" v-if="profissionalData.area_representada_outros">
                                <q-input
                                    v-model="profissionalData.area_representada_outros"
                                    label="Outro - Área Representada*"
                                    name="areaRepresentadaOutro"
                                    for="areaRepresentadaOutro"
                                    outlined
                                    :rules="[isRequired]"
                                />
                            </div>
                        </div>

                        <div class="col-12" v-if="profissionalData.area_representada !== ''">
                            <q-select
                                v-model="profissionalData.cargo"
                                :options="parametros.cargoList"
                                label="Titularidade*"
                                name="cargo"
                                for="cargo"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                        <div class="col-12" v-if="profissionalData.funcao === 'Secretaria Executiva'">
                            <q-select
                                v-model="profissionalData.vinculo_empregaticio"
                                :options="parametros.vinculoEmpregaticioList"
                                label="Vínculo empregaticio*"
                                name="vinculoEmpregaticio"
                                for="vinculoEmpregaticio"
                                outlined
                                :rules="[isRequired]"
                                @update:model-value="limparVinculoEmpregaticio()"
                            />
                        </div>
                        <div class="col-12" v-if="profissionalData.vinculo_empregaticio === 'Outro' && profissionalData.funcao === 'Secretaria Executiva'">
                            <q-input
                                v-model="profissionalData.vinculo_empregaticio_outro"
                                label="Informe qual é o seu vínculo empregatício*"
                                name="vinculoEmpregaticioOutro"
                                for="vinculoEmpregaticioOutro"
                                outlined
                                :rules="[isRequired]"
                            />
                        </div>
                        <div class="col-12" v-if="profissionalData.orgao?.value !== 5 || profissionalData.orgao !== 'Conselho Tutelar'">
                            <q-toggle
                                v-model="possuiRepresentacao"
                                label="Possui também alguma representação em conselho de assistência social (municipal ou estadual)?"
                            />
                        </div>
                        <div class="col-12" v-if="possuiRepresentacao">
                            <div class="col-12" v-if="profissionalData.orgao?.value === 2 || profissionalData.orgao === 'Conselho Municipal de Assistência Social'">
                                <q-select
                                    v-model="profissionalData.representacao_conselho"
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
                                    v-model="profissionalData.representacao_conselho"
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
                                    v-model="profissionalData.representacao_representacao"
                                    :options="parametros.representanteList"
                                    label="Segmento*"
                                    name="representacaoRepresentacao"
                                    for="representacaoRepresentacao"
                                    outlined
                                    :rules="[isRequired]"
                                />
                            </div>
                            <div class="col-12" v-if="profissionalData.representacao_conselho?.value === 1 || profissionalData.representacao_conselho === 'Conselho Estadual de Assistência Social (CEAS)'">
                                <div class="col-12" v-if="profissionalData.representacao_representacao?.value === 1 || profissionalData.representacao_representacao === 'Governamental'">
                                    <q-select
                                        v-model="profissionalData.representacao_segmento"
                                        :options="parametros.representacaoRepresentacaoList"
                                        label="Representação*"
                                        name="representacaoSegmento"
                                        for="representacaoSegmento"
                                        outlined
                                        clearable
                                        :rules="[isRequired]"
                                    />
                                </div>

                                <div class="col-12" v-if="profissionalData.representacao_representacao.value === 2 || profissionalData.representacao_representacao === 'Sociedade Civil'">
                                    <q-select
                                        v-model="profissionalData.representacao_segmento"
                                        :options="parametros.representacaoSegmentoList"
                                        label="Representação*"
                                        name="representacaoSegmento"
                                        for="representacaoSegmento"
                                        outlined
                                        clearable
                                        :rules="[isRequired]"
                                    />
                                </div>
                                <div class="col-12" v-if="profissionalData.representacao_segmento?.value === 1 || profissionalData.representacao_segmento === 'Usuários de Assistencia Social'">
                                    <q-select
                                        v-model="profissionalData.representacao_area_representada"
                                        :options="parametros.representacaoAreaRepresentadaList"
                                        label="Área Representada*"
                                        name="representacaoAreaRepresentada"
                                        for="representacaoAreaRepresentada"
                                        outlined
                                        clearable
                                        :rules="[isRequired]"
                                    />
                                </div>

                                <div class="col-12" v-if="profissionalData.representacao_area_representada === 'Outros'">
                                    <q-input
                                        v-model="profissionalData.representacao_area_representada_outros"
                                        label="Informe qual é o sua área representada*"
                                        name="outrosRepresentacaoAreaRepresentada"
                                        for="outrosRepresentacaoAreaRepresentada"
                                        outlined
                                        :rules="[isRequired]"
                                    />
                                </div>
                            </div>
                            <div class="col-12" v-else>
                                <div class="col-12" v-if="profissionalData.representacao_representacao?.value === 1 || profissionalData.representacao_representacao === 'Usuários de Assistencia Social'">
                                    <q-select
                                        v-model="profissionalData.representacao_segmento"
                                        :options="parametros.representacaoGovernamentalConselheiroList"
                                        label="Representação*"
                                        name="representacaoSegmento"
                                        for="representacaoSegmento"
                                        outlined
                                        clearable
                                        :rules="[isRequired]"
                                    />
                                </div>
                                <div class="col-12" v-if="profissionalData.representacao_representacao?.value === 2 || profissionalData.representacao_representacao === 'Sociedade Civil'">
                                    <q-select
                                        v-model="profissionalData.representacao_segmento"
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
                                    v-model="profissionalData.representacao_titularidade"
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
                </div>
            </q-card-section>

            <q-card-actions>
                <q-btn outlined label="Cancelar" color="red" @click="limparFiltrosPagina" v-close-popup
                    style="float: left !important; margin-left:10px;" />
                <q-btn outlined label="Salvar" color="green" @click="salvarDadosProfissionais"
                    style="float: right !important;" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script>
import { isRequired } from "../../../mixins/validates";
import ApiDataUser from "../../../mixins/users";
import accountMixin from "../../../mixins/accountMixin";
import * as parametros from '../../../mixins/parameters';

export default {
    name: "UserProfissionalModal",
    props: {
        modalDadosProfissional: {
            type: Boolean,
            required: true,
        },
        dadosUser: {
            type: Object,
            required: true,
        },
    },
    created() {
        this.getMunicipios();
        this.getLotacao();
    },
    data() {
        return {
            parametros,
            modalAbrir: false,
            stateFiltered: [],
            services: parametros.regionalList,
            filterMunicipios: [],
            filterLotacao: [],
            profissionalData: [],
            possuiRepresentacao: false
        };
    },
    mixins: [accountMixin, ApiDataUser],
    watch: {
        modalDadosProfissional(newVal) {
            this.modalAbrir = newVal;
        },
        modalAbrir(newVal) {
            this.$emit('update:modalDadosProfissional', newVal);
        },
        dadosUser: {
            handler(newVal) {
                if (newVal.profissional) {
                    this.profissionalData = newVal.profissional;
                    this.possuiRepresentacao = !!newVal.profissional.representacao_conselho;
                }
            },
            deep: true,
            immediate: true
        }
    },
    computed: {
        user() {
            const userData = this.dadosUser.user || {};
            userData['secretaria'] = this.dadosUser.secretaria.nome;
            return userData;
        },
        profissional() {
            return this.dadosUser.profissional || {};
        }
    },
    methods: {
        isRequired(value) {
            return isRequired(value);
        },
        limparFiltrosPagina() {
            this.$router.go();
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
                this.validandoToken(error);
                return error;
            }
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
                this.validandoToken(error);
                return error;
            }
        },
        async salvarDadosProfissionais() {
            let params = {
                'user_id': this.user.id,
                'profession': this.profissionalData,
                'secretary': this.user.secretaria,
                'service': this.profissionalData.regional
            }

            try {
                const result = await this.$http.post('professionals/updatebyuser', params);
                if (result.status === 200) {
                    this.$q.notify({
                        message: 'Dados Profissionais atualizados!',
                        color: "positive",
                        position: "top",
                    });
                }
                this.$router.go();
            } catch (error) {
                this.validandoToken(error);
            }
        },
        selectedLotacaoLabel(values) {
            if (values) {
                const selectedOption = this.filterLotacao.find(option => option.value === this.profissionalData.lotacao);
                const resultOption = selectedOption ? selectedOption.label : null;
                this.profissionalData.lotacao = resultOption;
            }
        },
        selectedLotacaoLabelMunicipios(values) {
            if (values) {
                const selectedOption = this.filterMunicipios.find(option => option.value === this.user.secretaria);
                const resultOption = selectedOption ? selectedOption.label : null;
                this.user.secretaria = resultOption;
            }
        },
        handleSelectionChangeMinicipio(value) {
            this.profissionalData['municipio_id'] = value;
            this.user.secretaria = value
        },
        handleSelectionChange(value) {
            this.selectedLotacaoLabel(value);
        },
        limparCamposCeasFuncaoDesempenhada() {
            if (this.profissionalData.funcao === 'Secretaria Executiva') {
                this.profissionalData.representacao = '';
                this.profissionalData.representacao_titularidade = '';
                this.profissionalData.representacao_area_representada = '';
                this.profissionalData.representacao_area_representada_outros = '';
            }
            if (this.profissionalData.funcao === 'Conselheiro') {
                this.profissionalData.representacao = '';
            }
        },
        limparCamposCeasSegmento() {
            this.profissionalData.representacao_segmento = '';
            this.profissionalData.representacao_area_representada = '';
            this.profissionalData.representacao_titularidade = '';
            if (this.profissionalData.representacao_area_representada !== 'Outros') {
                this.profissionalData.representacao_area_representada_outros === '';
            }
        },
        limparCamposCeasRepresentacao() {
            this.profissionalData.representacao_area_representada = '';
        },
        limparVinculoEmpregaticio() {
            this.profissionalData.vinculo_empregaticio_outro = '';
        }
    }
}
</script>