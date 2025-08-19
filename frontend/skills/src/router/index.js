import { createRouter, createWebHistory } from 'vue-router'
import HomeView from "@/views/HomeView.vue";
import StartPage from "@/views/StartPage.vue";
import LoginPage from "@/views/LoginPage.vue";
import RegisterPage from "@/views/RegisterPage.vue";


const routes = [
  { path: '/', component: StartPage },
  { path: '/home', component: HomeView},
  { path: '/login', component: LoginPage },
  { path: '/register', component: RegisterPage },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})
export default router

// хук сбрасывания маршрута послк каждго перехода
// to = {} обькт с инфой куда будет происходить перенапраление
// from = потом вот тут откуда была перенаправление
// next = и куда дальше будет переход
router.beforeEach((to,from,next)=>{
 // проверка был ли токен
  const token = localStorage.getItem('token')
  if(to.path === '/home' && !token){
    next('/')
  } else{
    next()
  }
})
