import { createRouter, createWebHistory } from "vue-router";

const routes = [
	{
		path: "",
		component: () =>
			import(/* webpackChunkName: "auth" */ "@/layouts/AuthLayout.vue"),
		children: [
			{ path: "", redirect: "signin" },
			{
				path: "404",
				name: "404",
				component: () =>
					import(/* webpackChunkName: "auth" */ "@/pages/404Page.vue"),
			},
			{
				path: "signin",
				name: "SignIn",
				component: () =>
					import(/* webpackChunkName: "auth" */ "@/pages/SignInPage.vue"),
			},
			{
				path: "signup",
				name: "SignUp",
				component: () =>
					import(/* webpackChunkName: "auth" */ "@/pages/SignUpPage.vue"),
			},
			{
				path: "forgotpassword",
				name: "ForgotPassword",
				component: () =>
					import(
						/* webpackChunkName: "auth" */ "@/pages/ForgotPasswordPage.vue"
					),
			},
			{
				path: "recoverpassword/:token",
				name: "RecoverPassword",
				component: () =>
					import(
						/* webpackChunkName: "auth" */ "@/pages/RecoverPasswordPage.vue"
						),
			},
		],
	},
	{
		path: "",
		component: () =>
			import(/* webpackChunkName: "main" */ "@/layouts/UserLayout.vue"),
		children: [
			{
				path: "main",
				name: "Main",
				component: () =>
					import(/* webpackChunkName: "main" */ "@/pages/MainPage.vue"),
			},
			{
				path: "dashboard",
				name: "Dashboard",
				component: () =>
					import(/* webpackChunkName: "main" */ "@/pages/DashboardPage.vue"),
			},
		],
	},
	{
		path: "",
		component: () =>
			import(/* webpackChunkName: "main" */ "@/layouts/AdminLayout.vue"),
			children: [
				{
					path: "users",
					name: "Users",
					component: () =>
						import(/* webpackChunkName: "main" */ "@/pages/UsersPage.vue"),
				},
				{
					path: "user/:id",
					name: "User",
					component: () =>
						import(/* webpackChunkName: "main" */ "@/pages/user/ViewPage.vue"),
				},
				{
					path: "createaction",
					name: "NewActionPage",
					component: () =>
						import(/* webpackChunkName: "main" */ "@/pages/NewActionPage.vue"),
				},
				{
					path: "acoes",
					name: "Actions",
					component: () =>
						import(/* webpackChunkName: "main" */ "@/pages/ActionsPage.vue"),
				},
				{
					path: "createclass",
					name: "NewClassPage",
					component: () =>
						import(/* webpackChunkName: "main" */ "@/pages/NewClassPage.vue"),
				},
				{
					path: "turmas",
					name: "Classes",
					component: () =>
						import(/* webpackChunkName: "main" */ "@/pages/ClassesPage.vue"),
				},
				{
					path: "listaparceiros",
					name: "PartnersMainPage",
					component: () => import(/* webpackChunkName: "main" */ "@/pages/PartnersMainPage.vue"),
				},
				{
					path: "parceiro/:id",
					name: "ViewPartner",
					component: () => import(/* webpackChunkName: "main" */ "@/pages/partners/ViewPartner.vue")
				},
			],
	},
	{
		path: "/:catchAll(.*)",
		redirect: "404",
	},
];

const router = createRouter({
	history: createWebHistory(process.env.BASE_URL),
	routes,
});

export default router;
