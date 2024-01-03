import axios from "axios";

export default {
	install: (app) => {
		app.config.globalProperties.$http = axios.create({
			// baseURL: "http://200.198.62.82:9000/api/v1/",
			//baseURL: "http://api-sedese.stefanini.test/api/v1/",
			baseURL: process.env.VUE_APP_API_URL
		});
		app.config.globalProperties.$http.interceptors.request.use(
			(config) => {
				const token = localStorage.getItem("token");
				console.log("🚀 ~ file: axios.js:11 ~ process.env.HOST_API", process.env.VUE_APP_API_URL)
				if (token) config.headers.Authorization = `Bearer ${token}`;
				return config;
			},
			(error) => Promise.reject(error)
		);
		app.config.globalProperties.$http.interceptors.response.use(
			(response) => response,
			(error) => Promise.reject(error)
		);
	},
};
