import { createStore } from "vuex";

export default createStore({
	state: {
		user: null,
	},
	getters: {
		user: (state) => state.user,
	},
	mutations: {
		SET_USER(state, payload) {
			state.user = payload;
		}
	},
	actions: {
		ActionSetUser({ commit }, payload) {
			commit("SET_USER", payload);
		}
	},
	modules: {},
});
