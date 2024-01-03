<template>
	<q-page class="flex flex-center bg-grey-1">
		<q-form @submit="onValidateEmail">
			<q-card flat bordered style="width: 448px" class="q-pa-md">
				<q-card-section>
					<div class="text-h5 text-center">Validando seu email...</div>
				</q-card-section>
			</q-card>
		</q-form>
	</q-page>
</template>

<script>
//import axios from 'axios';
import accountMixin from "../mixins/accountMixin";
export default {
	name: "ValidateEmailPage",
	mixins: [accountMixin],
	data() {
		return {
			form: {
                token: "",
			},
		};
	},
    methods: {
        isEmail(value) {
            return (
              (value && /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)) || "E-mail deve ser válido"
            );
        },
    },
    created() {
        this.form.token = this.$route.params.token;
    }
};
</script>

<style></style>
