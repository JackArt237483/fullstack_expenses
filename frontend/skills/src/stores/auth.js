// создаем глобальнео хранилище
import {defineStore} from "pinia"
// хук для выхлва в других компоненнетах
export const useAuthStore = defineStore('auth',{
  // state глобальное где будут хранится данные в приложение
  state: () => ({
    token: localStorage.getItem('token') || null
  }),
  // действия
  actions: {
    // метод устанвоки токена при
    setToken(token){
      // устанвливаешь токен в state
      this.token = token
      localStorage.setItem('token',token)
    },
    // после выхода logout сброс состояния
    clearToken(){
      this.token = null;
      localStorage.removeItem('token')
    },
    // проверка авторизирован юзер
    isAntificated(){
      // то есть простт проверка есть ли юзер или нет
      return !!this.token
    }

  }
})
