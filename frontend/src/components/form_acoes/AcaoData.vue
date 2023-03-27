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
                      outlined
                      clear-icon="close"
                      clearable
                    />
                </div>
                <div class="col-6">
                    <q-select
                      v-model="form_acao.tipo"
                      :options="tipoFiltered"
                      label="Tipo"
                      outlined
                      use-input
                      input-debounce="0"
                      clear-icon="close"
                      clearable
                    />
                </div>
                <div class="col-6">
                    <q-input
                      v-model="form_acao.tematica"
                      label="Tematica"
                      outlined
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
                      :options="areasEnvFiltered"
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
