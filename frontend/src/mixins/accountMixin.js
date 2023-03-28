import { mapActions } from "vuex";

export default {
  methods: {
    ...mapActions(["ActionSetUser"]),

    async logIn() {
      try {
        this.$q.loading.show();
        const { data, status } = await this.$http.post("auth/login", this.form);
        if (status === 200 || status === 201) {

          localStorage.setItem("token", data.authorization.token);
          localStorage.setItem("user", JSON.stringify(data.user));
          if (data.user.is_admin === 1) this.$router.push("/users");
          else if (data.user.second_stage === 1) this.$router.push("/dashboard");
          else this.$router.push({ name: "Main" });
        }
      } catch (error) {
          this.$q.notify({
              message: error.response.data.message,
              color: "negative",
              position: "top",
          });
      } finally {
        this.$q.loading.hide();
      }
    },
    async signUp() {
      try {
        const {status } = await this.$http.post(
          "auth/register",
          this.form
        );
        if (status === 200 || status === 201) {
            this.$q.notify({
                message: "Usuario registrado, em instantes você receberá um email com as instruções para ativar sua conta",
                type: "positive",
            }, 5000);
          this.$router.push({ name: "SignIn" });

        }
      }  catch (error) {
          this.$q.notify({
              message: error.response.data.message,
              color: "negative",
              position: "top",
          });
      }
    },
    async forgotPassword() {
      this.loadingForgotPassword = true;
      try {
        const {data, status} = await this.$http.post(
          "auth/forgot",
          this.form
        );
          console.log('data', data);

          console.log('status', status);
        if (status === 200 || status === 201) {
            this.$q.notify({
                message: data.message,
                type: "positive",
                position: "top",
            }, 5000);
            this.$router.push({ name: "SignIn" });

        }
      }  catch (error) {
          console.log('error', error);
          this.$q.notify({
              message: error.response.data.message,
              color: "negative",
              position: "top",
          });
      } finally {
        setTimeout(() => {
          this.loadingForgotPassword = false;
        }, 2000);
      }
    },
    async onRecoverPassword() {
        this.loadingRecoverPassword = true;
        try {
            const {data, status} = await this.$http.post(
            "auth/reset",
            this.form
            );
            if (status === 200 || status === 201) {
                this.$router.push({ name: "SignIn" });
                this.$q.notify({
                    message: data.response.data.message,
                    type: "positive",
                    position: "top",
                });
            }
        }  catch (error) {
            this.$q.notify({
                message: error.response.data.message,
                color: "negative",
                position: "top",
            });
         } finally {
             setTimeout(() => {
             this.loadingRecoverPassword = false;
             }, 2000);
         }
    },
    async onValidateEmail() {
      this.loadingValidateEmail = true;
      try {
          const {data, status} = await this.$http.get(
              "/users/confirm-email/" + this.form.token,
              this.form
          );
          if (status === 200 || status === 201) {
              this.$router.push({ name: "SignIn" });
              this.$q.notify({
                  message: data.response.data.message,
                  type: "positive",
                  position: "top",
              });
          }
      }  catch (error) {
          this.$q.notify({
              message: error.response.data.message,
              color: "negative",
              position: "top",
          });
      } finally {
          setTimeout(() => {
              this.loadingValidateEmail = false;
          }, 2000);
      }
    }
  },
};
