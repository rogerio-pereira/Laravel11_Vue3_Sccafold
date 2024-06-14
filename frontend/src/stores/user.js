import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import router from '@/router'

export const useUserStore = defineStore('user', () => {
    const user = ref({
        id: null    
    })

    const isGuest = computed(() => {
        return user.value.id === null
    })

    function logout() {
        axios.post('/logout', {})
            .then(() => {
                user.value = {
                        id: null  
                    }
                router.push({name: 'login'})
            })
            .catch(error => {
                console.log(error.response.data)
            })
    }

  return { user, logout, isGuest }
})