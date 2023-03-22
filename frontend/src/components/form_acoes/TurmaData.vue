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
										/>
								</div>
								<div class="col-8">
										<q-input
											v-model="form_turma.nome"
											label="Nome"
											outlined
											clear-icon="close"
											clearable
										/>
								</div>
								<div class="col-12">
										<q-select
											v-model="form_turma.turma_ferramenta_id"
											:options="ferramentaFiltered"
											label="Ferramenta"
											outlined
											use-input
											input-debounce="0"
											clear-icon="close"
											clearable />
								</div>
								<div class="col-3">
										<q-input
											v-model="form_turma.turma_data_inicio"
											label="Data de início"
											outlined
											clear-icon="close"
											clearable
										/>
								</div>
								<div class="col-3">
										<q-input
											v-model="form_turma.turma_data_fim"
											label="Data de término"
											outlined
											clear-icon="close"
											clearable
										/>
								</div>
								<div class="col-3">
										<q-input
											v-model="form_turma.carga_horaria_aula"
											label="Carga horária por aula"
											outlined
											clear-icon="close"
											clearable
										/>
								</div>
								<div class="col-3">
										<q-input
											v-model="form_turma.carga_horaria_total"
											label="Carga horária total"
											outlined
											clear-icon="close"
											clearable
										/>
								</div>
								<div class="col-4">
										<q-input
											v-model="form_turma.turma_periodo"
											label="Período"
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
										/>
								</div>
								<div class="col-4">
										<q-input
											v-model="form_turma.inscricoes_data_fim"
											label="Data de término das inscrições"
											outlined
											clear-icon="close"
											clearable
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
										<q-input
											v-model="form_turma.criterio_certificacao"
											label="Critério de certificação"
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
										/>
								</div>
								<div class="col-6">
										<q-input
											v-model="form_turma.intramunicipais"
											label="Quantidade de vagas intramunicipais"
											outlined
											clear-icon="close"
											clearable
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
										/>
								</div>
								<div class="col-4">
										<q-input
											v-model="form_turma.turma_endereco_numero"
											label="Número"
											outlined
											clear-icon="close"
											clearable
										/>
								</div>
								<div class="col-4">
										<q-input
											v-model="form_turma.turma_endereco_complemento"
											label="Complemnto"
											outlined
											clear-icon="close"
											clearable
										/>
								</div>
								<div class="col-4">
										<q-input
											v-model="form_turma.turma_endereco_bairro"
											label="Bairro"
											outlined
											clear-icon="close"
											clearable
										/>
								</div>
								<div class="col-4">
										<q-input
											v-model="form_turma.turma_endereco_cidade"
											label="Cidade"
											outlined
											clear-icon="close"
											clearable
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
						ferramentaFiltered: [],
				};
		},
}
</script>

<style></style>
