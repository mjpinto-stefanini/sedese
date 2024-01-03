<template>
		<q-card flat>
				<q-card-section>
						<div class="row q-col-gutter-md">
								<div class="col-4">
										<q-input
											v-model="form_turma.quantidade_turma"
											label="Quantidade de turmas"
											outlined
											clear-icon="close"
											clearable
                      maxlength="5"
                      :rules="[isRequired, isNumber]"
                      mask="#####"
										/>
								</div>
								<div class="col-8">
										<q-input
											v-model="form_turma.nome"
											label="Nome"
                      maxlength="200"
											outlined
											clear-icon="close"
											clearable
										/>
								</div>
								<div class="col-12">
										<q-select
											v-model="form_turma.turma_ferramenta_id"
											:options="ferramentaFiltered"
											label="Ferramenta Utilizada"
                      @filter="onFerramentaFilter"
											outlined
											use-input
											input-debounce="0"
											clear-icon="close"
											clearable />
								</div>

                <div class="col-12" v-if="form_turma.turma_ferramenta_id === 'Outras'">
                  <q-input
                      v-model="form_turma.turma_ferramenta_outra"
                      placeholder="informe a ferramenta utilizada"
                      outlined
                      counter
                      maxlength="30"
                      clear-icon="close"
                      clearable
                      :rules="[isRequired]"
                  />
                </div>

								<div class="col-4">
										<q-input
											v-model="form_turma.turma_data_inicio"
											label="Data de início"
											outlined
											clear-icon="close"
											clearable
                      :rules="[isRequired, isDate]"
                      mask="##/##/####"
										/>
								</div>
								<div class="col-4">
										<q-input
											v-model="form_turma.turma_data_fim"
											label="Data de término"
											outlined
											clear-icon="close"
											clearable
                      :rules="[isRequired, isDate]"
                      mask="##/##/####"
										/>
								</div>
								<div class="col-4">
										<q-input
											v-model="form_turma.carga_horaria_total"
											label="Carga horária total (hrs)"
                      :rules="[isRequired, isNumber]"
                      maxlength="10"
											outlined
											clear-icon="close"
											clearable
                      mask="##########"
										/>
								</div>
								<div class="col-4">
										<q-select
											v-model="form_turma.turma_periodo"
											label="Período da Turma"
                      :options="periodoList"
											outlined
											clear-icon="close"
											clearable
										/>
								</div>
								<div class="col-4">
										<q-input
											v-model="form_turma.inscricoes_data_inicio"
											label="Data de início das inscrições"
											outlined
											clear-icon="close"
											clearable
                      :rules="[isRequired, isDate]"
                      mask="##/##/####"
										/>
								</div>
								<div class="col-4">
										<q-input
											v-model="form_turma.inscricoes_data_fim"
											label="Data de término das inscrições"
											outlined
											clear-icon="close"
											clearable
                      :rules="[isRequired, isDate]"
                      mask="##/##/####"
										/>
								</div>

								<div class="col-12">
										<q-input
											v-model="form_turma.perfil_participantes"
											label="Perfil dos participantes"
											outlined
											clear-icon="close"
											clearable
										/>
								</div>
								<div class="col-12">
										<q-select
											v-model="form_turma.criterio_certificacao"
											label="Critério de certificação"
                      :options="criteriosList"
											outlined
											clear-icon="close"
											clearable
										/>
								</div>
						</div>
				</q-card-section>
				<label>Vagas</label>
				<q-separator />
				<q-card-section>
						<div class="row q-col-gutter-md">
								<div class="col-6">
										<q-input
											v-model="form_turma.quantidade_vagas_estaduais"
											label="Quantidade de vagas estaduais"
											outlined
											clear-icon="close"
											clearable
                      maxlength="5"
                      :rules="[isRequired, isNumber]"
                      mask="#####"
										/>
								</div>
								<div class="col-6">
										<q-input
											v-model="form_turma.intramunicipais"
											label="Quantidade de vagas intramunicipais"
											outlined
											clear-icon="close"
											clearable
                      maxlength="5"
                      :rules="[isRequired, isNumber]"
                      mask="#####"
										/>
								</div>
						</div>
				</q-card-section>
				<label>Endereço</label>
				<q-separator />
				<q-card-section>
						<div class="row q-col-gutter-md">
								<div class="col-8">
										<q-input
											v-model="form_turma.turma_endereco_logradouro"
											label="Endereço"
											outlined
											clear-icon="close"
											clearable
                      maxlength="100"
										/>
								</div>
								<div class="col-4">
										<q-input
											v-model="form_turma.turma_endereco_numero"
											label="Número"
											outlined
											clear-icon="close"
											clearable
                      maxlength="5"
                      :rules="[isRequired, isNumber]"
                      mask="#####"
										/>
								</div>
								<div class="col-7">
										<q-input
											v-model="form_turma.turma_endereco_complemento"
											label="Complemento"
											outlined
											clear-icon="close"
											clearable
                      maxlength="100"
										/>
								</div>
								<div class="col-5">
										<q-input
											v-model="form_turma.turma_endereco_bairro"
											label="Bairro"
											outlined
											clear-icon="close"
											clearable
                      maxlength="100"
										/>
								</div>
								<div class="col-8">
										<q-input
											v-model="form_turma.turma_endereco_cidade"
											label="Cidade"
											outlined
											clear-icon="close"
											clearable
                      maxlength="100"
										/>
								</div>
                <div class="col-4">
                  <q-input
                      v-model="form_turma.turma_endereco_cep"
                      label="CEP"
                      outlined
                      clear-icon="close"
                      clearable
                      minlength="9"
                      :rules="[isRequired, isCep]"
                      mask="#####-###"
                  />
                </div>
						</div>

				</q-card-section>
				<q-separator />
		</q-card>
</template>

<script>

export  default {
		name: "FormTurmaData",
		data() {
				return {
						form_turma: {
								quantidade_turma: "",
								nome: "",
								turma_endereco_id: "",
								turma_endereco_logradouro: "",
								turma_endereco_numero: "",
								turma_endereco_complemento: "",
								turma_endereco_bairro: "",
								turma_endereco_cep: "",
								turma_endereco_cidade: "",
								turma_endereco_estado: "",
								turma_ferramenta_id: "",
                isFerramenta: false,
                turma_ferramenta_outra: "",
								turma_data_inicio: "",
								turma_data_fim: "",
								carga_horaria_aula: "",
								carga_horaria_total: "",
								turma_periodo: "",
								quantidade_vagas_estaduais: "",
								intramunicipais: "",
								inscricoes_data_inicio: "",
								inscricoes_data_fim: "",
								perfil_participantes: "",
								criterio_certificacao: "",
						},
            isDeficiency: false,
            ferramentaFiltered: [],
            ferramentaList: [
              "Plataforma EducaSUAS",
              "Google Meet",
              "Teams",
              "Blog do SUAS",
              "Outras",
            ],
          periodoList: [
            'Manhã',
            'Tarde',
            'Integral',
            'Não se aplica',
          ],
          criteriosList: [
            'Presença/Participação',
            'Aprovado/Reprovado',
            'Presença e atividade avaliativa',
          ],
				};
		},
    methods: {
      setData() {
        this.jsonData = {
          acao: this.acaoData,
          polo: this.poloData,
          turma: this.turmaData,
        };
      },
      isRequired(value) {
        return !!value || "Campo obrigatório";
      },
      isNumber(value) {
        return (
            (value && /^\d+$/.test(value)) || "Somente números"
        );
      },
      isCep(value) {
        if ([...value].length > 8) {
          return (
              (value && /^[0-9]+(-[0-9]+)+$/.test(value)) || "CEP inválido"
          );
        }
        return "CEP inválido";
      },
      isDate(value) {
        console.log(value);
        return (
            (value && /^[0-9]{2}[/]{1}[0-9]{2}[/]{1}[0-9]{4}$/.test(value)) || "Somente números"
        );
      },
      onFerramentaFilter(val, update) {
        if (val === "") {
          update(() => {
            this.ferramentaFiltered = this.ferramentaList;
          });
        }
        update(() => {
          const needle = this.parseStringFilter(val);
          this.ferramentaFiltered = this.ferramentaList.filter((v) =>
              this.parseStringFilter(v).includes(needle)
          );
        });
      },
      parseStringFilter(text) {
        const er = /[^a-z0-9]/gi;
        return text
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .replace(er, "")
            .toLowerCase();
      },
    },
    computed: {
      activeFerramentaOthers() {
        return this.turma_ferramenta_id === "Outras";
      },
    },
}
</script>

<style></style>
