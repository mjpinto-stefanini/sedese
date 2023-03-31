<template>
	<q-page class="flex flex-center bg-grey-1">
		<q-form @submit="onForgotPassword">
			<q-card flat bordered style="width: 448px" class="q-pa-md">
				<q-card-section>
					<div class="text-h5 text-center">Recupera senha</div>
				</q-card-section>
				<q-card-section class="q-gutter-sm">
					<q-input
						outlined
						v-model="form.email"
						label="Email"
						type="email"
						:mask="isEmail"
						lazy-rules
					>
						<template v-slot:prepend>
							<q-icon name="mdi-email-outline" class="cursor-pointer" />
						</template>
					</q-input>
<!--					put a row div align center -->
                    <div class="row justify-center">
                        Ou
                    </div>

					<q-input
						outlined
						v-model="form.cpf"
						label="CPF"
						mask="###.###.###-##"
						lazy-rules
					>
						<template v-slot:prepend>
							<q-icon
								name="mdi-card-account-details-outline"
								class="cursor-pointer"
							/>
						</template>
					</q-input>
				</q-card-section>
				<q-card-section class="q-pt-none">
					<q-btn
						label="Enviar"
						color="primary"
						class="full-width q-py-md q-mb-md"
						no-caps
						:loading="loadingForgotPassword"
						unelevated
						type="submit"
					/>

					<q-btn
						label="Cancelar"
						color="primary"
						outline
						class="full-width q-py-md"
						no-caps
						unelevated
						to="signin"
					/>
				</q-card-section>
			</q-card>
		</q-form>
	</q-page>
</template>

<script>
//import axios from 'axios';
import accountMixin from "../mixins/accountMixin";
export default {
	name: "ForgotPasswordPage",
	mixins: [accountMixin],
	data() {
		return {
			form: {
				email: "",
				cpf: "",
			},
			loadingForgotPassword: false,
		};
	},
methods: {
        isEmail(value) {
            return (
              (value && /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)) || "E-mail deve ser válido"
            );
        },


  async onForgotPassword() {
    let response = await this.forgotPassword();
    if (response?.response?.status === 201) {
      this.$q.notify({
        type: response.response.data.type,
        message: response.response.data.message,
      });
    }
  },
    }
};
</script>

<style></style>
