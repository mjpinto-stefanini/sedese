import { mapActions } from "vuex";

export default {
  data() {
    return {
      baseURL: process.env.VUE_APP_API_URL,
    }
  },
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
        if (error.response?.status && error.response?.status === 401 || error.response?.statusText?.toLowerCase?.() == 'unauthorized') {
          this.$q.notify({
            message: error.response.data.message,
            color: error.response.data.type,
            position: "top",
          });
          return;
        }

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
        const {status} = await this.$http.post("auth/register",this.form);
        if (status === 200 || status === 201) {
          this.$q.notify({
            message: "Usuario registrado, em instantes você receberá um email com as instruções para ativar sua conta",
            type: "positive",
          }, 5000);
          this.$router.push({ name: "SignIn" });
        }
      } catch (error) {
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

        if (status === 200 || status === 201) {
          this.$q.notify({
            message: data.message,
            type: "positive",
            position: "top",
          }, 5000);
          this.$router.push({ name: "SignIn" });
        }
      }  catch (error) {
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
    },
    async apiUser(UserId, route, method = 'get', parameters = '') {
      try {
        if (method == 'get') {
          return await this.$http.get(`${this.baseURL}${route}/${UserId}/user`);
        }
        if(method == 'post') {
          return await this.$http.post(`${this.baseURL}${route}/${UserId}/user`, parameters);
        }
      } catch (error) {
        if (error.response?.status && error.response?.status === 401 || error.response?.statusText?.toLowerCase?.() == 'unauthorized') {
          localStorage.clear();
          this.$router.push({ name: "SignIn" });
          return;
        } else {
          this.$q.notify({
            message: error.response.data.message,
            color: "negative",
            position: "top",
          });
        }

      } finally {
        setTimeout(() => {
          this.loadingValidateEmail = false;
        }, 2000);
      }
    },
    async apiGlobal(route, method = 'get', parameters = '') {
      try {
        if (method == 'get') {
          return await this.$http.get(`${this.baseURL}${route}${parameters}`);
        }

        if (method == 'post') {
          if (parameters == '') {
            this.$q.notify({
              message: 'Ops, sem parametros',
              color: "negative",
              position: "top",
            });
          }
          return await this.$http.post(`${this.baseURL}${route}`, parameters);
        }

      }  catch (error) {
        if (error.response?.status && error.response?.status === 401 || error.response?.statusText?.toLowerCase?.() == 'unauthorized') {
          localStorage.clear();
          this.$router.push({ name: "SignIn" });
          return;
        } else {
          this.$q.notify({
            message: error.response.data.message,
            color: "negative",
            position: "top",
          });
        }

      } finally {
        setTimeout(() => {
          this.loadingValidateEmail = false;
        }, 2000);
      }
    },
    async checkAuthenticationAndCallApi() {
      try {
        const isAuthenticated = await this.isAuthenticated();

        if (!isAuthenticated && this.$route.name !== "SignUp" && this.$route.name !== 'SignIn') {
          // Verifica se a rota atual é SignUp antes de redirecionar para SignIn
          localStorage.clear();
          this.$router.push({ name: 'SignIn' });
          return;
        }
      } catch (error) {
        if (error.response?.status && error.response?.status === 401 || error.response?.statusText?.toLowerCase?.() == 'unauthorized') {
          localStorage.clear();
          this.$router.push({ name: "SignIn" });
          return;
        } else {
          this.$q.notify({
            message: "Seu tempo de login expirou, faça login novamente!",
            color: "negative",
            position: "top",
          });
        }
      } finally {
        setTimeout(() => {
          this.loadingValidateEmail = false;
        }, 2000);
      }
    },
    async secretaryById(secretaryId) {
      try {
        const { data } = await this.apiGlobal(`ambitoatuacao/show/${secretaryId}`);
        if (data) {
          return {
            status: true,
            dados: data
          };
        }
        return { status: false };
      } catch (error) {
        this.validandoToken(error);
        return { status: false };
      }
    },
    async isAuthenticated() {
      // Implemente a lógica para verificar se o usuário está autenticado ou não
      // Por exemplo, verifique se há um token de autenticação válido ou se o usuário está logado de alguma outra forma
      // Retorne true se estiver autenticado, caso contrário, retorne false
      // Exemplo de implementação de verificação de autenticação:
      return !! localStorage.getItem('token'); // Verifica se há um token de autenticação no localStorage
    },
  },
  created() {},
  mounted() {
    this.checkAuthenticationAndCallApi();
  },
};
