import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import CarrerasView from '../views/CarrerasView.vue'
import MateriasView from '../views/MateriasView.vue'
import ProfesoresView from '../views/ProfesoresView.vue'
import AulasView from '../views/AulasView.vue'
import CalendarioView from '../views/CalendarioView.vue'
import ComponentsView from '../views/ComponentsView.vue'
import LoginView from '../views/LoginView.vue'
import { authService } from '../services/api'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      name: 'login',
      component: LoginView,
      meta: { public: true }
    },
    {
      path: '/',
      name: 'home',
      component: HomeView,
      meta: { requiresAuth: true }
    },
    {
      path: '/components',
      name: 'components',
      component: ComponentsView,
      meta: { requiresAuth: true }
    },
    {
      path: '/carreras',
      name: 'carreras',
      component: CarrerasView,
      meta: { requiresAuth: true }
    },
    {
      path: '/materias',
      name: 'materias',
      component: MateriasView,
      meta: { requiresAuth: true }
    },
    {
      path: '/profesores',
      name: 'profesores',
      component: ProfesoresView,
      meta: { requiresAuth: true }
    },
    {
      path: '/aulas',
      name: 'aulas',
      component: AulasView,
      meta: { requiresAuth: true }
    },
    {
      path: '/calendario',
      name: 'calendario',
      component: CalendarioView,
      meta: { requiresAuth: true }
    }
  ]
})

// Guard de navegación para proteger rutas
router.beforeEach((to, from, next) => {
  const isAuthenticated = authService.isAuthenticated()
  
  if (to.meta.requiresAuth && !isAuthenticated) {
    next('/login')
  } else if (to.path === '/login' && isAuthenticated) {
    next('/')
  } else {
    next()
  }
})

export default router
