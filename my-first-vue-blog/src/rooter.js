import { createRouter, createWebHistory } from 'vue-router'
import LoginApp from './auth/LoginApp.vue'
import RegisterApp from './auth/RegisterApp.vue'
import MyCompteApp from './auth/MyCompteApp.vue'
import AccueilApp from './layouts/accueil/AccueilApp.vue'
import ArticleApp from './composants/ArticleApp.vue'
import ShowArticleApp from './composants/ShowArticleApp.vue'
import CategorieApp from './composants/CategorieApp.vue'
import DashboardAppArticle from './admin/dashboard/DashboardAppArticle.vue'
import DashboardAppCategorie from './admin/dashboard/DashboardAppCategorie.vue'
import DashboardAppCommentaire from './admin/dashboard/DashboardAppCommentaire.vue'
import DashboardAppPage from './admin/dashboard/DashboardAppPage.vue'
import DashboardAppMedia from './admin/dashboard/DashboardAppMedia.vue'
import DashboardAppUser from './admin/dashboard/DashboardAppUser.vue'

const isAuthenticated = () => {
  // Vérifiez si l'utilisateur est authentifié (vous pouvez utiliser votre propre logique ici)
  // Retournez true si l'utilisateur est authentifié, sinon false
  return localStorage.getItem('access_token') !== null; // Par exemple, vérifiez la présence d'un token JWT dans le localStorage
};

const routes = [
  //accueil
  {
    path: '/',
    name: 'app_home',
    props: true,
    component: AccueilApp,
  },

  //login
    {
    path: '/login',
    name: 'app_login',
    props: true,
    component: LoginApp,
  },

  //register
  {
    path: '/register',
    name: 'app_register',
    props: true,
    component: RegisterApp,
  },

  //my compte
  {
    path: '/myCompte/:id',
    name: 'app_my_compte',
    props: true,
    component: MyCompteApp,
  },
  
  //article
  {
    path: '/article',
    name: 'article',
    props: true,
    component: ArticleApp,
  },
    //show article
    {
      path: '/article/show/:id',
      name: 'article_show',
      props: true,
      component: ShowArticleApp,
    },
      //article categorie
  {
    path: '/categorie/:id',
    name: 'article_categorie',
    props: true,
    component: CategorieApp,
  },



  //Dashboard
  //article
  {
    path: '/dashboard/article',
    name: 'dashboard_article',
    props: true,
    component: DashboardAppArticle,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/article/:method',
    name: 'dashboard_article_create',
    props: true,
    component: DashboardAppArticle,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/article/:method/:id',
    name: 'dashboard_article_edit',
    props: true,
    component: DashboardAppArticle,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/article/store',
    name: 'dashboard_article_store',
    props: true,
    component: DashboardAppArticle,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/article/update/:id',
    name: 'dashboard_article_update',
    props: true,
    component: DashboardAppArticle,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/article/destroy/:id',
    name: 'dashboard_article_destroy',
    props: true,
    component: DashboardAppArticle,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },

  //categorie
  {
    path: '/dashboard/categorie',
    name: 'dashboard_categorie',
    props: true,
    component: DashboardAppCategorie,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/categorie/:method',
    name: 'dashboard_categorie_create',
    props: true,
    component: DashboardAppCategorie,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/categorie/:method/:id',
    name: 'dashboard_categorie_edit',
    props: true,
    component: DashboardAppCategorie,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/categorie/store',
    name: 'dashboard_categorie_store',
    props: true,
    component: DashboardAppCategorie,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/categorie/update/:id',
    name: 'dashboard_categorie_update',
    props: true,
    component: DashboardAppCategorie,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/categorie/destroy/:id',
    name: 'dashboard_categorie_destroy',
    props: true,
    component: DashboardAppCategorie,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  
  //commentaire
  {
    path: '/dashboard/commentaire',
    name: 'dashboard_commentaire',
    props: true,
    component: DashboardAppCommentaire,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/commentaire/:method',
    name: 'dashboard_commentaire_create',
    props: true,
    component: DashboardAppCommentaire,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/commentaire/:method/:id',
    name: 'dashboard_commentaire_edit',
    props: true,
    component: DashboardAppCommentaire,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/commentaire/store',
    name: 'dashboard_commentaire_store',
    props: true,
    component: DashboardAppCommentaire,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/commentaire/update/:id',
    name: 'dashboard_commentaire_update',
    props: true,
    component: DashboardAppCommentaire,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/commentaire/destroy/:id',
    name: 'dashboard_commentaire_destroy',
    props: true,
    component: DashboardAppCommentaire,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },

  //page
  {
    path: '/dashboard/page',
    name: 'dashboard_page',
    props: true,
    component: DashboardAppPage,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/page/:method',
    name: 'dashboard_page_create',
    props: true,
    component: DashboardAppPage,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/page/:method/:id',
    name: 'dashboard_page_edit',
    props: true,
    component: DashboardAppPage,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/page/store',
    name: 'dashboard_page_store',
    props: true,
    component: DashboardAppPage,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/page/update/:id',
    name: 'dashboard_page_update',
    props: true,
    component: DashboardAppPage,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/page/destroy/:id',
    name: 'dashboard_page_destroy',
    props: true,
    component: DashboardAppPage,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },

  //media
  {
    path: '/dashboard/media',
    name: 'dashboard_media',
    props: true,
    component: DashboardAppMedia,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/media/:method',
    name: 'dashboard_media_create',
    props: true,
    component: DashboardAppMedia,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/media/:method/:id',
    name: 'dashboard_media_edit',
    props: true,
    component: DashboardAppMedia,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/media/store',
    name: 'dashboard_media_store',
    props: true,
    component: DashboardAppMedia,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/media/update/:id',
    name: 'dashboard_media_update',
    props: true,
    component: DashboardAppMedia,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/media/destroy/:id',
    name: 'dashboard_media_destroy',
    props: true,
    component: DashboardAppMedia,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },

  //user
  {
    path: '/dashboard/user',
    name: 'dashboard_user',
    props: true,
    component: DashboardAppUser,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/user/:method',
    name: 'dashboard_user_create',
    props: true,
    component: DashboardAppUser,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/user/:method/:id',
    name: 'dashboard_user_edit',
    props: true,
    component: DashboardAppUser,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/user/store',
    name: 'dashboard_user_store',
    props: true,
    component: DashboardAppUser,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/user/update/:id',
    name: 'dashboard_user_update',
    props: true,
    component: DashboardAppUser,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
  {
    path: '/dashboard/user/destroy/:id',
    name: 'dashboard_user_destroy',
    props: true,
    component: DashboardAppUser,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Permet l'accès à la route si l'utilisateur est authentifié
      } else {
        next('/'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
      }
    }
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router