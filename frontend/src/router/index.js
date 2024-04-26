import { createRouter, createWebHistory } from "vue-router";

// Importando os componentes de maneira mais organizada
const AuthLayout = () => import("@/layouts/AuthLayout.vue");
const MainPage = () => import("@/pages/MainPage.vue");
const DashboardPage = () => import("@/pages/DashboardPage.vue");
const UsersPage = () => import("@/pages/UsersPage.vue");
const ViewPage = () => import("@/pages/user/ViewPage.vue");
const NewActionPage = () => import("@/pages/NewActionPage.vue");
const ActionsPage = () => import("@/pages/ActionsPage.vue");
const NewClassPage = () => import("@/pages/NewClassPage.vue");
const ClassesPage = () => import("@/pages/ClassesPage.vue");
const PartnersMainPage = () => import("@/pages/PartnersMainPage.vue");
const ViewPartner = () => import("@/pages/partners/ViewPartner.vue");
const SignInPage = () => import("@/pages/SignInPage.vue");
const SignUpPage = () => import("@/pages/SignUpPage.vue");
const ForgotPasswordPage = () => import("@/pages/ForgotPasswordPage.vue");
const RecoverPasswordPage = () => import("@/pages/RecoverPasswordPage.vue");
const ConfirmarEmail = () => import("@/pages/ConfirmarEmail.vue");

const Page404 = () => import("@/pages/404Page.vue");

const routes = [
  {
    path: "",
    component: AuthLayout,
    children: [
      { path: "", redirect: "signin" },
      { path: "404", name: "404", component: Page404 },
      { path: "signin", name: "SignIn", component: SignInPage },
      { path: "signup", name: "SignUp", component: SignUpPage },
      { path: "forgotpassword", name: "ForgotPassword", component: ForgotPasswordPage },
      { path: "recoverpassword/:token", name: "RecoverPassword", component: RecoverPasswordPage },
      { path: "confirmar-email/:token", name: "ConfirmarEmail", component: ConfirmarEmail, props: (route) => {
        const token = route.params.token;
        return { token }
      } },
    ],
  },
  {
    path: "",
    component: () => import("@/layouts/UserLayout.vue"),
    children: [
      { path: "main", name: "Main", component: MainPage },
      { path: "dashboard", name: "Dashboard", component: DashboardPage },
    ],
  },
  {
    path: "",
    component: () => import("@/layouts/AdminLayout.vue"),
    children: [
      { path: "users", name: "Users", component: UsersPage },
      { path: "user/:id", name: "User", component: ViewPage },
      { path: "createaction", name: "NewActionPage", component: NewActionPage },
      { path: "acoes", name: "Actions", component: ActionsPage },
      { path: "createclass", name: "NewClassPage", component: NewClassPage },
      { path: "turmas", name: "Classes", component: ClassesPage },
      { path: "listaparceiros", name: "PartnersMainPage", component: PartnersMainPage },
      { path: "parceiro/:id", name: "ViewPartner", component: ViewPartner },
    ],
  },
  { path: "/:catchAll(.*)", redirect: "404" },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

let isAuthenticated = false;

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !isAuthenticated) {
    next({ name: 'SignIn' });
  } else {
    next();
  }
});

// Evitar que a página volte quando o botão do navegador é pressionado
history.pushState(null, null, location.href);
window.onpopstate = function () {
    history.go(1);
};

export default router;