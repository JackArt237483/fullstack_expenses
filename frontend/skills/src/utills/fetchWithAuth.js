import { useAuthStore } from "@/stores/auth.js";
// help functions with apiз
export const fetchWithAuth = async (url,options={}) =>{
  const auth = useAuthStore()

  // включить все заголовки для запроса
  const headers = {
    ...(options.headers || {}),
    Authorization: auth.token,
    'Content-Type': 'application/json'
  }
  const res = await  fetch(url,{
    ...options,
    headers
  })

  if(!res.ok) throw new Error(`Ошибка запроса: ${res.status}`)
  // Возвращаешь тело ответа в виде JSON
  return await res.json()
}
