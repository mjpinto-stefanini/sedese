<template>
    <q-page class="flex flex-center bg-grey-1">
        <q-card flat bordered style="width: 900px">
            <q-card-section>
                <q-stepper
                  flat
                  v-model="step"
                  ref="stepper"
                  color="primary"
                  animated
                  alternative-labels
                  keep-alive>
                    <q-step
                      :name="1"
                      title="Ação"
                      icon="acount_circle"
                      :done="step > 1" >
                        <acao-data
                          @personal="(val) => {acaoData = val;}"/>
                    </q-step>
                    <q-step
                      :name="2"
                      title="Polo"
                      icon="add_location_alt"
                      :done="step > 2">
                        <polo-data
                          @address="(val) => {poloData = val;}"/>
                    </q-step>
                    <q-step
                      :name="3"
                      title="Turma"
                      icon="groups"
                      :done="step > 3">
                        <turma-data
                          @contact="(val) => {turmaData = val;}"/>
                    </q-step>
                </q-stepper>
            </q-card-section>
            <q-separator spaced />
            <q-card-section class="row justify-end q-gutter-sm q-px-md">
                <q-btn
                  v-if="step > 1"
                  flat
                  color="primary"
                  @click="$refs.stepper.previous()"
                  label="Voltar"
                  no-caps
                  unelevated
                  padding="md xl"
                />
                <q-btn
                  @click="step === 3 ? sendForm() : $refs.stepper.next()"
                  color="primary"
                  :label="step === 3 ? 'Salvar' : 'Avançar'"
                  no-caps
                  unelevated
                  padding="md xl"
                />
            </q-card-section>
        </q-card>
    </q-page>
</template>

<script>
import AcaoData from "../components/form_acoes/AcaoData.vue";
import PoloData from "@/components/form_acoes/PoloData.vue";
import TurmaData from "@/components/form_acoes/TurmaData.vue";
export default {
    name: "NewActionPage",
    data() {
        return {
            step: 1,
            acaoData: {},
            poloData: {},
            turmaData: {},
            jsonData: "",
        };
    },
    computed: {
        finalData() {
            let jsonData = {
                acao: this.acaoData,
                polo: this.poloData,
                turma: this.turmaData,
            };
            return jsonData;
        },
    },
    methods: {
        setData() {
            this.jsonData = {
                acao: this.acaoData,
                polo: this.poloData,
                turma: this.turmaData,
            };
        },
        async sendForm() {
            const values = {
                acao: { ...this.acaoData},
                polo: { ...this.poloData},
                turma: { ...this.turmaData},
            };

            try {
                const user_id = JSON.parse(localStorage.getItem("user")).id;
                const { status, data } = await this.$http.patch(
                  `users/${user_id}/secondstage`,
                  values
                );
                if (status === 201 || status === 200) {
                    this.$q.notify({
                        message: "Dados salvos com sucesso!",
                        color: "positive",
                        position: "top",
                    });
                    console.log(data);
                }
            }   catch (error) {
                this.$q.notify({
                    message: error.response.data.message,
                    color: "negative",
                    position: "top",
                });
            }
        },
    },
    watch: {
        personalData: {
            handler() {
                // this.setData();
                console.log("personalData");
            },
            deep: true,
        },
        addressData: {
            handler() {
                this.setData();
            },
            deep: true,
        },
        contactData: {
            handler() {
                this.setData();
            },
            deep: true,
        },
        representationData: {
            handler() {
                this.setData();
            },
            deep: true,
        },
        professionalData: {
            handler() {
                this.setData();
            },
            deep: true,
        },
    },

    components: {
        AcaoData,
        PoloData,
        TurmaData,
    },
};
</script>
