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
					@click="validForm(step, $refs) "
					color="primary"
					:label="step === 4 ? 'Salvar' : 'Avançar'"
					no-caps
					unelevated
					padding="md xl"
				/>
			</q-card-section>
		</q-card>
	</q-page>
</template>

<script>
import { Notify } from 'quasar';
import PersonalData from "../components/form/PersonalData.vue";
import AddressData from "@/components/form/AddressData.vue";
import ContactData from "@/components/form/ContactData.vue";
import ProfessionalData from "@/components/form/ProfessionalData.vue";
export default {
	name: "MainPage",
	data() {
		return {
			step: 1,
			personalData: {},
			addressData: {},
			contactData: {},
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
				professional: this.professionalData,
			};
			return jsonData;
		},
	},
	methods: {
		forms(step) {
			const formFromStep = {
				1: this.personalData,
				2: this.addressData,
				3: this.contactData,
				4: this.professionalData,
			}

			return formFromStep[step];
		},
		async sendForm() {
			const values = {
				personal: { ...this.personalData },
				address: { ...this.addressData },
				contact: { ...this.contactData },
				professional: { ...this.professionalData },
			};

			//try {
				const user_id = JSON.parse(localStorage.getItem("user")).id;
				console.log('try');
				console.log(values);
				const { status, data } = await this.$http.patch(
					`users/${user_id}/secondstage`,
					values
				);
				console.log('aqui',data);

				if (status === 201 || status === 200) {
					this.$q.notify({
						message: "Dados salvos com sucesso!",
						color: "positive",
						position: "top",
					});
					this.$router.push({ name: "SignIn" });
					console.log(data);
				}
			//} catch (error) {
				//console.log('catch');
				//console.log(error);
				// this.$q.notify({
				//	message: error.response.data.message,
				//	color: "negative",
				//	position: "top",
				//});
			//}
		},
		async checkAllInputs(formFields) {
			if (!/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/.test(formFields.name )) {
				Notify.create({
					timeout: 2000,
					position: 'center',
					color: 'danger',
					message: 'O campo Nome deve conter apenas letras'
				});
				return 1;
			}

			if (formFields.issuingBody && !/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/.test(formFields.issuingBody)) {
				Notify.create({
					timeout: 2000,
					position: 'center',
					color: 'danger',
					message: 'O campo órgão emissor deve conter apenas letras'
				});
				return 1;
			}

			if (!/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/.test(formFields.city )) {
				Notify.create({
					timeout: 2000,
					position: 'center',
					color: 'danger',
					message: 'O campo cidade deve conter apenas letras'
				});
				return 1;
			}

			if (Object.keys(formFields).length === 0) {
				Notify.create({
					timeout: 2000,
					position: 'center',
					color: 'danger',
					message: 'Por favor, preencha todos os campos'
				});
				return 1;
			}

			let erro = 0;

			Object.keys(formFields).forEach(key => {

				if (isVisibleAndNotEmpty(key) === false) {  
					++erro; 

					Notify.create({
					timeout: 2000,
					position: 'center',
					color: 'danger',
					message: 'Por favor, preencha os campos corretamente'
				});
				}
			});

			return erro;
		},
		async resolveCheckForm(step) {
			let selectForm = this.forms(step);

			const errroReturn = this.checkAllInputs(selectForm);
			const resolveResult = Promise.resolve(errroReturn);

			return resolveResult;
		},
		async validForm(step, $refs) {
			const dados = await this.resolveCheckForm(step);
			if (dados == 0 && step <= 3) {
				$refs.stepper.next();
			}
			if (dados == 0 && step === 4) {
				this.sendForm();
			}
		},
		setData() {
			this.jsonData = {
				personal: this.personalData,
				address: this.addressData,
				contact: this.contactData,
				professional: this.professionalData,
			};
		},
	},
	watch: {
		personalData: {
			handler() {
				this.setData();
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
		/* RepresentationsData, */
	},
};

function isVisibleAndNotEmpty(element)
{
	if (document.getElementById(element) === null) {
		return null;
	}

	let el = document.getElementById(element);

	if (el === null || el === undefined) {
		return false;
	}

    let t1 = el.currentStyle ? el.currentStyle.visibility : getComputedStyle(el, null).visibility;
	let t2 = el.currentStyle ? el.currentStyle.display : getComputedStyle(el, null).display;

    if (t1 === "hidden" || t2 === "none") {
        return false;
	}

    while (!(/body/i).test(el)) {
        el = el.parentNode;
        t1 = el.currentStyle ? el.currentStyle.visibility : getComputedStyle(el, null).visibility;
        t2 = el.currentStyle ? el.currentStyle.display : getComputedStyle(el, null).display;
        if (t1 === "hidden" || t2 === "none") {
            return false;
        }
	}

	let checkInputValue = document.getElementById(element).value;

	if (checkInputValue === '') {
		checkInputValue = document.querySelector('[name = "' + element + '"]').value
	}

	if (!isEmpty(checkInputValue)) {
		document.querySelector('[for = "' + element + '"]').classList.remove('q-field--float', 'q-field--labeled', 'q-field--with-bottom');
		document.querySelector('[for = "' + element + '"] div div').classList.add('text-negative');
		document.querySelector('[for = "' + element + '"]').classList.add('q-field', 'row', 'no-wrap', 'items-start', 'q-field--outlined', 'q-select', 'q-field--auto-height', 'q-select--with-input', 'q-select--without-chips', 'q-select--single', 'q-field--labeled', 'q-field--error', 'q-field--highlighted', 'q-field--with-bottom');

		return false;
	}

    return true;
}

function isEmpty(input) {
	if (input === '' || input === null) {
		return false;
	}
	return true;
}
</script>
