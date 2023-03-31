<template>
    <q-card flat>
        <q-card-section>
            <div class="row q-col-gutter-md">
                <div class="col-4">
                    <q-input
                      v-model="form_acao.ano"
                      label="Ano"
                      outlined
                      clear-icon="close"
                      clearable
                      :rules="[isRequired, isNumber]"
                      mask="####"
                    />
                </div>
                <div class="col-8">
                    <q-input
                      v-model="form_acao.nome"
                      label="Nome"
                      maxlength="200"
                      outlined
                      clear-icon="close"
                      clearable
                    />
                </div>
                <div class="col-12">
                    <q-select
                      v-model="form_acao.tematica"
                      label="Tematica"
                      :options="tematicaList"
                      outlined
                      use-input
                      clear-icon="close"
                      clearable
                    />
                </div>
                <div class="col-6">
                    <q-select
                      v-model="form_acao.tipologia"
                      :options="tipologiaFiltered"
                      label="Tipologia"
                      outlined
                      use-input
                      input-debounce="0"
                      clear-icon="close"
                      clearable
                    />
                </div>
                <div class="col-6">
                    <q-select
                      v-model="form_acao.modalidade"
                      :options="modalidadeFiltered"
                      label="Modalidade"
                      outlined
                      use-input
                      input-debounce="0"
                      clear-icon="close"
                      clearable
                    />
                </div>
                <div class="col-4">
                    <q-input
                      v-model="form_acao.num_vagas"
                      label="Vagas"
                      outlined
                      clear-icon="close"
                      clearable
                      :rules="[isRequired, isNumber]"
                      mask="#######"
                    />
                </div>
                <div class="col-4">
                    <q-input
                      v-model="form_acao.data_inicio"
                      label="Data inicio"
                      outlined
                      clear-icon="close"
                      clearable
                      :rules="[isRequired, isDate]"
                      mask="##/##/####"
                    />
                </div>
                <div class="col-4">
                    <q-input
                      v-model="form_acao.data_fim"
                      label="Data fim"
                      outlined
                      clear-icon="close"
                      clearable
                      :rules="[isRequired, isDate]"
                      mask="##/##/####"
                    />
                </div>
                <div class="col-6">
                    <q-select
                      v-model="form_acao.acao_regionalizada"
                      :options="acaoRegFiltered"
                      label="Acão regionalizada"
                      outlined
                      use-input
                      input-debounce="0"
                      clear-icon="close"
                      clearable
                    />
                </div>
                <div class="col-6">
                    <q-select
                      v-model="form_acao.modalidade"
                      :options="areasList"
                      label="Areas envolvidas/responsaveis"
                      outlined
                      use-input
                      input-debounce="0"
                      clear-icon="close"
                      clearable
                    />
                </div>
            </div>
        </q-card-section>
    </q-card>
</template>

<script>
export default {
    name: "FormAcaoData",
    data() {
        return {
            form_acao: {
                ano: "",
                nome: "",
                tipo: "",
                tematica: "",
                tipologia: "",
                modalidade: "",
                data_inicio: "",
                data_fim: "",
                num_vagas: "",
                acao_regionalizada: "",
                areas_envolvidas: "",
            },
            tipoFiltered: [
                { label: "Capacitação", value: "acao_tipo_capacitacao" },
                { label: "Formação", value: "acao_tipo_formacao" },
                { label: "Apoio Técnico", value: "acao_tipo_apoio_tecnico" },
            ],
            allTipologia: [],
            tipologiaFiltered: [],
            modalidadeFiltered: [
                { label: "Presencial", value: "acao_modalidade_presencial" },
                { label: "Híbrida/Semipresencial", value: "acao_modalidade_hibrida" },
                { label: "EAD", value: "acao_modalidade_ead" },
                { label: "EAD - Restrito", value: "acao_modalidade_eadrestrito" },
                { label: "EAD - Livre", value: "acao_modalidade_eadlivre" },
            ],
            acaoRegFiltered: [
                { label: "Sim", value: "acao_regionalizada_sim" },
                { label: "Não", value: "acao_regionalizada_nao" },
                { label: "Não se aplica", value: "acao_regionalizada_nsa" },
            ],
            areasEnvFiltered: [],
            tematicaList: [
              'ATUAÇÃO NO CONTEXTO DE COVID-19',
              'BENEFÍCIO DE PRESTAÇÃO CONTINUADA (BPC)',
              'BENEFÍCIOS EVENTUAIS',
              'BOLSA MERENDA',
              'CADASTRO ÚNICO E PROGRAMA BOLSA FAMÍLIA',
              'CALAMIDADE PÚBLICA OU EMERGÊNCIAS',
              'CONTROLE SOCIAL',
              'DIAGNOSTICO SOCIOTERRITORIAL, INDICADORES, MONITORAMENTO E AVALIAÇÃO DO SUAS',
              'DISTRIBUIÇÃO DE CESTAS BÁSICAS PELA SEDESE',
              'ENTIDADES SOCIOASSISTENCIAIS',
              'GESTÃO DO SUAS',
              'GESTÃO FINANCEIRA E ORÇAMENTÁRIA (RECURSOS DE COFINANCIAMENTO FEDERAL UTILIZAÇÃO, PRESTAÇÃO DE CONTAS, ETC)',
              'IGD PBF',
              'IGD SUAS',
              'ORIENTAÇÕES GERAIS SOBRE A PROTEÇÃO SOCIAL BÁSICA',
              'ORIENTAÇÕES GERAIS SOBRE A PROTEÇÃO SOCIAL ESPECIAL',
              'ORIENTAÇÕES GERAIS SOBRE A PROTEÇÃO SOCIAL ESPECIAL DE ALTA COMPLEXIDADE ORIENTAÇÕES GERAIS SOBRE A PROTEÇÃO SOCIAL ESPECIAL DE E MÉDIA COMPLEXIDADE',
              'PAEFI -SERVIÇO DE PROTEÇÃO E ATENDIMENTO ESPECIALIZADO A FAMILIAS E INDIVIDUOS',
              'PISO MINEIRO (UTILIZAÇÃO, PLANO DE SERVIÇOS, DEMONSTRATIVO, ETC); PREENCHIMENTO DE SISTEMAS DE INFORMAÇÃO DO SUAS',
              'PROGRAMA ACESSUAS TRABALHO',
              'PROGRAMA BPC NA ESCOLA',
              'PROGRAMA PERCURSOS GERAIS - APROXIMACAO SUAS',
              'PSAC - ADULTOS E FAMÍLIAS',
              'PSAC - CRIANÇAS E ADOLESCENTES',
              'PSAC - IDOSOS',
              'PSAC - MULHER EM SITUAÇÃO DE VIOLÊNCIA',
              'PSAC - PESSOAS COM DEFICIÊNCIA',
              'PSB - PAIF - SERVIÇO DE PROTEÇÃO E ATENDIMENTO INTEGRAL A FAMILIAS',
              'PSB - SCFV - SERVIÇO DE CONVIVÊNCIA E FORTALECIMENTO DE VÍNCULOS E SISC.',
              'PSB - SERVIÇO DE PROTEÇÃO SOCIAL BÁSICA NO DOMICILIO PARA PESSOAS COM DEFICIENCIA E IDOSAS: PSEMC - CERTIDÕES DA FEBEM',
              'PSEMC - MEDIDAS SOCIOEDUCATIVAS EM MEIO ABERTA',
              'PSEMC - POPULAÇÃO EM SITUAÇÃO DE RUA PSEMC - POVOS E COMUNIDADES TRADICIONAIS: PSEMC - PROGRAMA DE ERRADICAÇÃO DO TRABALHO INFANTIL (PETI)',
              'PSEMC - VIOLÊNCIA CONTRA A PESSOA COM DEFICIÊNCIA',
              'PSEMC - VIOLÊNCIA CONTRA CRIANÇAS E ADOLESCENTES (GERAIS)',
              'PSEMC - VIOLÊNCIA CONTRA IDOSA',
              'PSEMC - VIOLÊNCIA CONTRA MULHER',
              'PSEMC - VIOLÊNCIA SEXUAL CONTRA CRIANÇAS E ADOLESCENTES',
              'RECURSOS EMERGENCIAI PARA ENFRENTAMENTO AO COVID19',
              'REDE CUIDAR',
              'RENDA MINAS',
              'SERVIÇO DE ACOLHIMENTO EM REPULICA',
              'SERVIÇOS SOCIOASSISTENCIAIS NO PERÍODO ELEITORAL',
              'SISTEMAS DE GERENCIAMENTO DO CADCINICO E PBF (V.7, SIBEC, SICON, SIGPBF, CECAD, ETC)',
              'SUAS E O SISTEMA DE JUSTIÇA TRABALHO ESCRAVO',
              'TRÁFICO HUMANO',
              'VIGILÂNCIA SOCIOASSISTENCIAL',
              'ORIENTAÇÕES GERAIS SOBRE A EDUCAÇÃO PERMANENTE NO SUAS',
              'AUXÍLIO EMERGENCIAL MINEIRA',
              'MROSC',
              'VIGILÂNCIA SOCIOASSISTENCIAL',
              'TRABALHO SOCIAL COM FAMÍLIAS E BENEFÍCIOS SOCIOASSISTENCIAS',
              'AUXÍLIO BRASIL',
              'OUTROS',
            ],
          areasList: [
            'Subsecretaria de Assistência Social',
            'Superintendência de Proteção Social Básica; Diretoria de Serviços e Benefícios Socioassistenciais',
            'Diretoria de Gestão do Cadastro Único e Programas Socioassistenciais; Superintendência de Proteção Social Especial',
            'Diretoria de Proteção Social Especial de Média Complexidade',
            'Diretoria de Proteção Social Especial de Alta Complexidade',
            'Superintendência de Vigilância e Capacitação',
            'Diretoria de Vigilância Socioassistencial',
            'Diretoria de Educação Permanente do SUAS',
            'Diretoria de Gestão Descentralizada e Regulação do SUAS',
            'Assessoria de gestão do Fundo Estadual de Assistência Social',
          ],
        }
    },
    methods: {

      isRequired(value) {
        return !!value || "Campo obrigatório";
      },
      isNumber(value) {
        return (
            (value && /^\d+$/.test(value)) || "Somente números"
        );
      },
      isDate(value) {
        return (
            (value && /^[0-9]{2}[/]{1}[0-9]{2}[/]{1}[0-9]{4}$/.test(value)) || "Somente números"
        );
      },

        async getTipologias() { // http://200.198.62.82:9000/api/v1/tipologias
            try {
                const { data, status } = await this.$http.get(
                  `tipologias`
                );
                if (status === 200) {
                    console.log('>>>', data, status);
                    this.allTipologia = data.map(ele => {
                        return {
                            ...ele,
                            label: ele.nome,
                            value: ele.id
                        }
                    });
                    this.tipologiaFiltered = this.allTipologia;
                }
            } catch (error) {
                console.log(error);
            }
        },
    },
    created() {
        this.getTipologias();
    }
}
</script>

<style></style>
