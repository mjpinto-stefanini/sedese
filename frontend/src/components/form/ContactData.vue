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
						:rules="[isRequired, isPhoneNumber, notLessThanNormal, notMoreThanNormal]"
						clearable
						type="tel"
					/>
				</div>
				<div class="col-6">
					<q-input
						v-model="form.cell_phone"
						label="Nº Celular*"
						outlined
						clear-icon="close"
						mask="(##) # ####-####"
						:rules="[isRequired, isCellPhoneNumber, notLessThan, notMoreThan]"
						clearable
						type="tel"
					>
					</q-input>
				</div>
				<div class="col-6">
						<q-select
								v-model="form.cell_phone_whatsapp"
								label="Este número possui WhatsApp?"
								:options="['Sim', 'Não']"
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
						:rules="[isPhoneNumber, notLessThanNormal, notMoreThanNormal]"
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
			},
		};
	},
		methods: {
				isRequired(value) {
						return !!value || "Campo obrigatório";
				},
				isCellPhoneNumber(value) {
						return (
							(value && /^\(\d{2}\) \d \d{4}-\d{4}$/.test(value)) || "Não permitido outros caracteres"
						);
				},
                isPhoneNumber(value) {
                        return (
                            (value && /^\(\d{2}\) \d{4}-\d{4}$/.test(value)) || "Não permitido outros caracteres"
                        );
                },
				isNumber(value) {
						return (
							(value && /^\d+$/.test(value)) || "Somente números"
						);
				},
                notLessThanNormal(value) {
                    return (
                      (value && value.length <= 14) || "Máximo de 17 caracteres"
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
                        (value && value.length >= 14) || "Mínimo de 11 caracteres"
                    );
                },
				isEmail(value) {
						return (
							(value && /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)) || "E-mail deve ser válido"
						);
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
