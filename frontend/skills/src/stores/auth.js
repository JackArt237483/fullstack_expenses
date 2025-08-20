// создаем глобальнео хранилище
import {defineStore} from "pinia"
// хук для выхлва в других компоненнетах
export const useAuthStore = defineStore('auth',{
  // state глобальное где будут хранится данные в приложение
  state: () => ({
    token: localStorage.getItem('token') || null
  }),
  // state для проверки token то есть есть ли он или нет его в системе
  getters: () => ({
    isAntificated: (state) => !!state.token
  }),
  // действия
  actions: {
    // Метод логина: устанавливает токен в память и localStorage
    login(token){
      // устанвливаешь токен в state
      this.token = token
      localStorage.setItem('token',token)
    },
    // Метод выхода: чистит токен из памяти и localStorage
    logout(){
      this.token = null;
      localStorage.removeItem('token')
    }
  }
})
