<template>
	<q-page class="flex flex-center bg-grey-1">
		<q-form @submit="onLogin">
			<div class="text-h4 text-center q-mb-lg text-primary">{{ appTitle }}</div>
			<q-card flat bordered style="width: 448px" class="q-pa-md">
				<q-card-section>
					<div class="text-center">
						<q-icon
							name="o_account_circle"
							size="5rem"
							color="primary"
							class="cursor-pointer"
						/>
					</div>
				</q-card-section>
				<q-card-section class="q-gutter-sm">
					<q-input
						outlined
						v-model="form.email"
						label="Email"
						type="email"
						:rules="[isRequired, isEmail]"
						lazy-rules
					>
						<template v-slot:prepend>
							<q-icon name="mdi-email-outline" class="cursor-pointer" />
						</template>
					</q-input>
					<q-input
						outlined
						v-model="form.password"
						lazy-rules
						:rules="[isRequired]"
						label="Senha"
						:type="showPassword ? 'text' : 'password'"
					>
						<template v-slot:prepend>
							<q-icon name="mdi-form-textbox-password" class="cursor-pointer" />
						</template>
						<template v-slot:append>
							<q-icon
								:name="showPassword ? 'mdi-eye-off-outline' : 'mdi-eye-outline'"
								class="cursor-pointer"
								@click="showPassword = !showPassword"
							/>
						</template>
					</q-input>
					<div class="row justify-between" style="margin-top: -12px">
						<q-space />
						<a
							class="text-weight-medium text-primary"
							href="/forgotpassword"
							style="text-decoration: none"
						>
							Esqueceu a senha?
						</a>
					</div>
				</q-card-section>
				<q-card-section class="q-pt-none">
					<q-btn
						label="Login"
						color="primary"
						class="full-width q-py-md q-mb-md"
						no-caps
						unelevated
						type="submit"
					/>
					<q-btn
						label="Criar conta"
						color="primary"
						outline
						class="full-width q-py-md"
						no-caps
						unelevated
						to="/signup"
					/>
				</q-card-section>
			</q-card>
		</q-form>
	</q-page>
</template>

<script>
import accountMixin from "../mixins/accountMixin";

export default {
	name: "SignInPage",
	mixins: [accountMixin],
	data() {
		return {
			form: {
				email: "",
				password: "",
			},
			showPassword: false,
		};
	},
	methods: {
        isEmail(value) {
            return ((value && /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)) || "E-mail deve ser válido");
        },
        isCPf(value) {
            return ((value && /^[0-9]{3}\.[0-9]{3}\.[0-9]{3}-[0-9]{2}$/.test(value)) || "CPF deve ser válido");
        },
        async onLogin() {
			let response = await this.logIn();
			if (response?.response?.status === 401) {
				this.$q.notify({
					type: response.response.data.type,
					message: response.response.data.message,
				})
			}
			if (response?.response?.is_active === 0) {
				this.$q.notify({
					type: 'positive',
					message: "Usuário inativo, entre em contato com o administrador do sistema",
				})
			}
		},
	},
	mounted() {
        if (this.$route.query.message && this.$route.query.type) {
            this.$q.notify({
                type: this.$route.query.type,
                message: this.$route.query.message,
            })
        }
	}
};
</script>

<style></style>
