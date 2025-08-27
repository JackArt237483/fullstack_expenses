import { useAuthStore } from "@/stores/auth.js";
// help functions with api
export const fetchWithAuth = async (url,options={}) =>{
  const auth = useAuthStore()

  if (!auth.token) throw new Error('❌ Нет токена');

  // включить все заголовки для запроса
  const headers = {
    ...(options.headers || {}),
    Authorization: `Bearer ${auth.token}`,
    'Content-Type': 'application/json'
  }

  console.log(`Так смотри токен такой ${auth.token}`)
  const res = await fetch(url,{
    ...options,
    headers
  })

  if (!res.ok) throw new Error(`Ошибка запроса: ${res.status}`)
  // Возвращаешь тело ответа в виде JSON
  return await res.json()
}
