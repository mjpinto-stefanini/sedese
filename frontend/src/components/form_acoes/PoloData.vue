<template>
    <q-card flat>
        <q-card-section>
            <div class="row q-col-gutter-md">
                <div class="col-4">
                    <q-select
                      outlined
                      v-model="form_polo.regiao_administrativa"
                      :options="regiaoAdmFiltered"
                      label="Região Administrativa"
                      :rules="[isRequired]"
                      lazy-rules
                    >
                    </q-select>
                </div>
                <div class="col-8">
                    <q-select
                      outlined
                      v-model="form_polo.ambito_atuacao"
                      :options="AmbitoAtuacaoFiltered"
                      :label="form_polo.regiao_administrativa.value === 1 ? 'Secretarias do Estado' : 'Município'"
                      @filter="filterFn"
                      :rules="[isRequired]"
                      lazy-rules
                      use-input
                      input-debounce="0"
                    >
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
    </q-card>
</template>

<script>
export default {
    name: "FormPoloData",
    data() {
        return {
            form_polo: {
                regiao_administrativa: "",
                ambito_atuacao: "",
            },
            regiaoAdmFiltered: [
                { label: "Estado", value: 1 },
                { label: "Municipio", value: 2 },
            ],
            allAmbitoAtuacao: [],
            AmbitoAtuacaoFiltered: [],
        };
    },
    methods: {
        filterFn (val, update) {
            if (val === '') {
                update(() => {this.AmbitoAtuacaoFiltered = this.allAmbitoAtuacao})
                return
            }

            update(() => {
                const needle = val.toLowerCase()
                this.AmbitoAtuacaoFiltered = this.allAmbitoAtuacao.filter(v => {
                    return v.nome.toLowerCase().indexOf(needle) > -1
                })
            })
        },

        async onRegister() {
            this.signUp();
        },

        async getAmbitoAtuacao() {
            try {
                const { data, status } = await this.$http.get(
                    `ambitoatuacao/regiaoadm/${this.form_polo?.regiao_administrativa.value === 1 ? '1' : '2'}`
                );
                if (status === 200) {
                    this.allAmbitoAtuacao = data.map(ele => {
                        return {
                            ...ele,
                            label: ele.nome,
                            value: ele.id
                        }
                    });
                    this.AmbitoAtuacaoFiltered = this.allAmbitoAtuacao;
                }
            } catch (error) {
                //console.log(error);
            }
        },
    },

    watch: {
        form_polo: {
            handler() {
                this.getAmbitoAtuacao();
            },
            deep: true,
        },
    },
};
</script>

<style></style>
