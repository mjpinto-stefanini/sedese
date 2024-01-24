<template>
	<q-card flat>
		<q-card-section>
			<div class="row q-col-gutter-md">
				<div class="col-12">
					<q-input
						v-model="form.email"
						label="Email*"
						outlined
						clear-icon="close"
						name="email"
						for="email"
						disable
						clearable
						type="email"
						:rules="[isRequired]"
					/>
				</div>
				<div class="col-12">
					<q-input
						v-model="form.phone"
						label="Telefone Residencial"
						outlined
						clear-icon="close"
						mask="(##) ####-####"
						:rules="[isPhoneNumber]"
						min="11"
						max="14"
						clearable
						type="tel"
					/>
				</div>
				<div class="col-6">
					<q-input
						v-model="form.cell_phone"
						label="Nº Celular*"
						name="cell_phone"
						for="cell_phone"
						outlined
						clear-icon="close"
						mask="(##) # ####-####"
						:rules="[isRequired, isCellPhoneNumber]"
						min="11"
						max="14"
						clearable
						type="tel"
					>
					</q-input>
				</div>
				<div class="col-6">
					<q-select
						v-model="form.cell_phone_whatsapp"
						name="cell_phone_whatsapp"
						for="cell_phone_whatsapp"
						label="Este número possui WhatsApp?"
						:options="['Sim', 'Não']"
						:rules="[isRequired]"
						outlined
					/>
				</div>
				<div class="col-12">
					<q-input
						v-model="form.institutional_phone"
						label="Telefone Institucional"
						outlined
						clear-icon="close"
						clearable
						type="tel"
						mask="(##) ####-####"
						min="11"
						max="14"
					/>
				</div>
				<div class="col-12">
					<q-input
						v-model="form.institutional_email"
						label="Email Institucional"
						outlined
						clear-icon="close"
						clearable
						type="email"
						:rules="[isEmail]"
					/>
				</div>
			</div>
		</q-card-section>
	</q-card>
</template>

<script>
export default {
	name: "ContactData",
	data() {
		return {
			form: {
				email: "",
				phone: "",
				cell_phone: "",
				institutional_phone: "",
				institutional_email: "",
                cell_phone_whatsapp: [],
				error: false,
				checkZip: "1"
			},
		};
	},
	methods: {
		isRequired(value) {
			return !!value || "Campo obrigatório";
		},
		isCellPhoneNumber(value) {
			if(value){
				return (
					(value && /^\(\d{2}\) \d \d{4}-\d{4}$/.test(value)) || "Não permitido outros caracteres"
				);
			}

		},
		isPhoneNumber(value) {
			if(value){
				return (
					(value && /^\(\d{2}\) \d{4}-\d{4}$/.test(value)) || "Não permitido outros caracteres"
				);
			}
		},
		isNumber(value) {
			return (
				(value && /^\d+$/.test(value)) || "Somente números"
			);
		},
		notLessThanNormal(value) {
			return (
				(value && value.length <= 14) || "Máximo de 14 caracteres"
			);
		},
		notLessThan(value) {
			return (
				(value && value.length <= 17) || "Máximo de 17 caracteres"
			);
		},
		notMoreThan(value) {
			return (
				(value && value.length >= 11) || "Mínimo de 11 caracteres"
			);
		},
		notMoreThanNormal(value) {
			return (
				(value && value.length >= 14) || "Mínimo de 14 caracteres"
			);
		},
		isEmail(value) {
			if(value){
				return (
					(value && /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)) || "E-mail deve ser válido"
				);
			}
		},
	},
	watch: {
		form: {
			handler() {
				this.$emit("contact", this.form);
			},
			deep: true,
		},
	},
	created() {
		this.form.email = JSON.parse(localStorage.getItem("user")).email;
	},
};
</script>

<style></style>
