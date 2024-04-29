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
					keep-alive
				>
					<q-step
						:name="1"
						title="Dados Pessoais"
						icon="sym_o_person"
						:done="step > 1"
					>
						<personal-data
							@personal="
								(val) => {
									setData();
									personalData = val;
								}
							"
						/>
					</q-step>
					<q-step
						:name="2"
						title="Residenciais"
						icon="sym_o_home_work"
						:done="step > 2"
					>
						<address-data
							@address="
								(val) => {
									addressData = val;
								}
							"
						/>
					</q-step>

					<q-step :name="3" title="Contato" icon="sym_o_call" :done="step > 3">
						<contact-data
							@contact="
								(val) => {
									contactData = val;
								}
							"
						/>
					</q-step>

					<q-step
						:name="4"
						title="Profissionais"
						icon="sym_o_work"
						:done="step > 4"
					>
						<professional-data
							@professional="
								(val) => {
									professionalData = val;
								}
							"
						/>
					</q-step>

					<q-step
						:name="5"
						title="Representações"
						icon="sym_o_group"
						:done="step > 5"
					>
						<representations-data
							@representation="
								(val) => {
									representationData = val;
								}
							"
						/>
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
					@click="step === 5 ? sendForm() : $refs.stepper.next()"
					color="primary"
					:label="step === 5 ? 'Salvar' : 'Avançar'"
					no-caps
					unelevated
					padding="md xl"
				/>
			</q-card-section>
		</q-card>
	</q-page>
</template>

<script>
import PersonalData from "../components/form/PersonalData.vue";
import AddressData from "@/components/form/AddressData.vue";
import ContactData from "@/components/form/ContactData.vue";
import ProfessionalData from "@/components/form/ProfessionalData.vue";
// import RepresentationsData from "@/components/form/RepresentationsData.vue";
export default {
	name: "NewClassPage",
	data() {
		return {
			step: 1,
			personalData: {},
			addressData: {},
			contactData: {},
			representationData: {},
			professionalData: {},
			jsonData: "",
		};
	},
	computed: {
		finalData() {
			let jsonData = {
				personal: this.personalData,
				address: this.addressData,
				contact: this.contactData,
				representation: this.representationData,
				professional: this.professionalData,
			};
			return jsonData;
		},
	},
	methods: {
		setData() {
			this.jsonData = {
				personal: this.personalData,
				address: this.addressData,
				contact: this.contactData,
				representation: this.representationData,
				professional: this.professionalData,
			};
		},
		async sendForm() {
			const values = {
				personal: { ...this.personalData },
				address: { ...this.addressData },
				contact: { ...this.contactData },
				representation: { ...this.representationData },
				professional: { ...this.professionalData },
			};

			try {
				const user_id = JSON.parse(localStorage.getItem("user")).id;
				const { status } = await this.$http.patch(
					`users/${user_id}/secondstage`,
					values
				);
				if (status === 201 || status === 200) {
					this.$q.notify({
						message: "Dados salvos com sucesso!",
						color: "positive",
						position: "top",
					});
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
				//console.log("personalData");
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
		PersonalData,
		AddressData,
		ContactData,
		ProfessionalData,
		//RepresentationsData,
	},
};
</script>
