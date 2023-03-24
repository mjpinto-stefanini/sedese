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
<!--@click="step === 4 ? sendForm() : $refs.stepper.next()"-->
<script>
import { Notify } from 'quasar';
import PersonalData from "../components/form/PersonalData.vue";
import AddressData from "@/components/form/AddressData.vue";
import ContactData from "@/components/form/ContactData.vue";
import ProfessionalData from "@/components/form/ProfessionalData.vue";
export default {
	name: "MainPage",
	data() {
		console.log('personalData', PersonalData);

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
		async testesss(personalData) {
			console.log('personalDatapersonalDatapersonalDatapersonalDatapersonalData', personalData);
			let erro = 0;
			/*for (let value of Object.values(personalData)) {
				if (!isEmpty(personalData[value])) {  ++erro; }
				console.log('value', value);
			}*/

			Object.keys(personalData).forEach(key => {
				//console.log(`AAAkey: ${key}, value: ${personalData[key]}`);
				if (isVisibleAndNotEmpty(key) === false) {  ++erro; }
			});
			console.log('erroerro', erro);
			console.log('typeof personalData', typeof personalData);
			/*
			personalData.forEach(function(nome, i) {
				console.log('[forEach]', nome, i);
			})*/
			return erro;
		},
		async validPersonalData($refs) {
			const errroReturn = this.testesss(this.personalData);
			const cast = Promise.resolve(errroReturn);
			//.then(function(result) {
			cast.then(function (value) {
				if (value == 0) {
					$refs.stepper.next();
				}
			}).catch(
				console.log('ops valuevalue')
			);
		},
		validForm(step, $refs) {
			this.validPersonalData($refs);
			/*
			if (result) {
				$refs.stepper.next();
			}
			console.log('resultresultresult', result);
			*/

			//this.personalData.$refs.form.validate();
			//this.personalData.validate();
			//console.log('this.$refs', this.$refs);

			//$event => step === 4 ? sendForm() : $refs.stepper.mext()
			//$event => step === 4 ? sendForm() : $refs.stepper.mext()

		},
		setData() {
			this.jsonData = {
				personal: this.personalData,
				address: this.addressData,
				contact: this.contactData,
				professional: this.professionalData,
			};
		},
		async sendForm() {
			const values = {
				personal: { ...this.personalData },
				address: { ...this.addressData },
				contact: { ...this.contactData },
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
			} catch (error) {
				this.$q.notify({
						//message: "Erro ao salvar os dados!",
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
	let elementFind = '[name = "' + element + '"]';
	console.log('elementFind', elementFind);

	if (document.querySelector(elementFind) === null) {
		return null;
	}

	console.log('document.querySelector(elementFind).value', document.querySelector(elementFind).value);
	let el = document.querySelector(elementFind);
	console.log('elelelel', el);

	/*
	document.querySelector(elementFind).classList.add("q-field--error");

	document.body.classList.add('bg-light')
	*/
	Notify.create({
		timeout: 2000,
		position: 'center',
		color: 'primary',
		message: 'Preencher todos os campos'
	});

	console.log('elel', el);
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

	if (!isEmpty(document.querySelector(elementFind).value)) {
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
