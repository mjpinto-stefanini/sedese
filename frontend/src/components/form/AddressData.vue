<template>
	<q-card flat>
		<q-card-section>
			<div class="row q-col-gutter-md">
				<div class="col-12">
					<q-input
						v-model="form.zip_code"
						label="Cep"
						name="zip_code"
						for="zip_code"
						outlined
						clear-icon="close"
						clearable
						mask="#####-###"
						@blur="getAddressByZipCode"
						:rules="[isRequired]"
					/>
				</div>
				<div class="col-12">
					<q-input
						v-model="form.street"
						label="Logradouro"
						name="street"
						for="street"
						outlined
						clear-icon="close"
						clearable
						:rules="[isRequired]"
					/>
				</div>
				<div class="col-4">
					<q-input
						v-model="form.number"
						label="Numero"
						name="number"
						for="number"
						outlined
						clear-icon="close"
						clearable
						ref="number"
						:rules="[isRequired, isNumber]"
					/>
				</div>
				<div class="col-8">
					<q-input
						v-model="form.complement"
						label="Complemeto"
						outlined
						clear-icon="close"
						clearable
					/>
				</div>
				<div class="col-8">
					<q-input
						v-model="form.city"
						label="Cidade"
						name="city"
						for="city"
						outlined
						clear-icon="close"
						clearable
						:rules="[isRequired]"
					/>
				</div>
				<div class="col-4">
					<q-select
						v-model="form.state"
						:options="stateFiltered"
						label="UF"
						name="state"
						for="state"
						outlined
						use-input
						input-debounce="0"
						@filter="onStateFilter"
						clear-icon="close"
						clearable
						:rules="[isRequired]"
					/>
				</div>
			</div>
		</q-card-section>
	</q-card>
</template>

<script>
import axios from "axios";

export default {
	name: "AddressData",
	data() {
		return {
			form: {
				zip_code: "",
				street: "",
				number: "",
				complement: "",
				neighborhood: "",
				city: "",
				state: "",
			},
			stateFiltered: [],
			stateList: [
				"AC",
				"AL",
				"AP",
				"AM",
				"BA",
				"CE",
				"DF",
				"ES",
				"GO",
				"MA",
				"MT",
				"MS",
				"MG",
				"PA",
				"PB",
				"PR",
				"PE",
				"PI",
				"RJ",
				"RN",
				"RS",
				"RO",
				"RR",
				"SC",
				"SP",
				"SE",
				"TO",
			],
			baseUrlViaCep: "https://viacep.com.br/ws/",
		};
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
		onStateFilter(val, update) {
			if (val === "") {
				update(() => {
					this.stateFiltered = this.stateList;
				});
			}
			update(() => {
				const needle = val.toLowerCase();
				this.stateFiltered = this.stateList.filter((v) =>
					v.toLowerCase().includes(needle)
				);
			});
		},
		async getAddressByZipCode() {
			try {
				const { data, status } = await axios.get(
					`${this.baseUrlViaCep}${this.form.zip_code}/json/`
				);
				if (status === 200) {
					this.form.street = data.logradouro;
					this.form.neighborhood = data.bairro;
					this.form.complement = data.complemento;
					this.form.city = data.localidade;
					this.form.state = data.uf;
					this.$refs.number.focus();
				}
			} catch (error) {
				console.log(error);
			}
		},
	},
	watch: {
		form: {
			handler() {
				this.$emit("address", this.form);
			},
			deep: true,
		},
	},
};
</script>

<style></style>
