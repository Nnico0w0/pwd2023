import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import CarrerasView from '../views/CarrerasView.vue'
import MateriasView from '../views/MateriasView.vue'
import ProfesoresView from '../views/ProfesoresView.vue'
import AulasView from '../views/AulasView.vue'
import ReservasView from '../views/ReservasView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/carreras',
      name: 'carreras',
      component: CarrerasView
    },
    {
      path: '/materias',
      name: 'materias',
      component: MateriasView
    },
    {
      path: '/profesores',
      name: 'profesores',
      component: ProfesoresView
    },
    {
      path: '/aulas',
      name: 'aulas',
      component: AulasView
    },
    {
      path: '/reservas',
      name: 'reservas',
      component: ReservasView
    }
  ]
})

export default router
