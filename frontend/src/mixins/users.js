export default {
  data() {
    return {
      baseURL: process.env.VUE_APP_API_URL,
    }
  },
  methods: {
    async userData(UserId) {
      try {
        const { data, status } = await this.apiUser(UserId, 'users');
        if (data) {
          return {
            status: true,
            dados: data
          };
        }
        if (status !== 200) {
          return { status: false };
        }
      } catch (error) {
        this.validandoToken(error);
        return { status: false };
      }
    },
    async personalData(UserId) {
      try {
        const { data, status } = await this.apiUser(UserId, 'personal');
        if (data) {
          return {
            status: true,
            dados: data
          };
        }
        if (status !== 200) {
          return { status: false };
        }
      } catch (error) {
        this.validandoToken(error);
        return { status: false };
      }
    },
    async contactData(UserId) {
      try {
        const { data, status } = await this.apiUser(UserId, 'contact');
        if (data) {
          return {
            status: true,
            dados: data
          };
        }
        if (status !== 200) {
          return { status: false };
        }
      } catch (error) {
        this.validandoToken(error);
        return { status: false };
      }
    },
    async getUserAddress(UserId) {
      try {
        const { data, status } = await this.apiUser(UserId, 'address');
        if (data) {
          return {
            status: true,
            dados: data
          };
        }
        if (status !== 200) {
          return { status: false };
        }
      } catch (error) {
        this.validandoToken(error);
        return { status: false };
      }
    },
    async getUserProfessionals(UserId) {
      try {
        const { data, status } = await this.apiUser(UserId, 'professionals');

        if (data) {
          return {
            status: true,
            dados: data
          };
        }
        if (status !== 200) {
          return { status: false };
        }
      } catch (error) {
        this.validandoToken(error);
        return { status: false };
      }
    },
    async validandoToken(error) {
        if (error.response?.status && error.response?.status === 401 || error.response?.statusText?.toLowerCase?.() == 'unauthorized') {
            localStorage.clear();
            this.$router.push({ name: "SignIn" });
            return;
        } else {
            this.$q.notify({
                message: error.message,
                color: "negative",
                position: "top",
            });
        }
    },
  },
  created() {},
  mounted() { },
};
