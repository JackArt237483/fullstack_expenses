import { createRouter, createWebHistory } from 'vue-router'

// Импорты компонентов
import HomeView from '../views/HomeView.vue'

// Создание роутера
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/about',
      name: 'about',
      // ленивый импорт — создаст отдельный файл
      component: () => import('../views/HomeView.vue')
    },
    {
      path: '/expenses',
      name: 'expenses',
      component: () => import('../views/ExpensesView.vue')
    },
    // 404 fallback (опционально)
    {
      path: '/:pathMatch(.*)*',
      name: 'not-found',
      component: () => import('../views/NotFound.vue')
    }
  ]
})

export default router
