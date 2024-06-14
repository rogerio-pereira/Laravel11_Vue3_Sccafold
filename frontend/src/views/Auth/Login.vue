<template>
    <v-card>
        <v-card-item>
            <v-card-title class='text-center'>
                Login
            </v-card-title>
        </v-card-item>

        <v-card-text>
            <v-text-field 
                label="Email"
                v-model='form.email'
                prepend-icon="mdi-at"
                clearable
            />

            <v-text-field 
                label="Password"
                v-model='form.password'
                prepend-icon="mdi-asterisk"
                clearable
            />
        </v-card-text>

        <v-card-actions class='mb-4'>
            <v-row class='text-center'>
                <v-btn @click="login" color='primary' class='mx-auto' variant='elevated'>
                    Button 
                </v-btn>
            </v-row>


        </v-card-actions>
    </v-card>
</template>

<script setup>
    import { ref,computed } from 'vue'
    import axios from 'axios'
    import { useUserStore } from '@/stores/user'
    import router from '@/router'
    const userStore = useUserStore()
    const form = ref({
        'email': '',
        'password': '',
    })
    function login() {
        axios.post('/login', form.value)
            .then(response => {
                userStore.user = response.data.user
                router.push({name: 'home'})
            })
            .catch(error => {
                console.log(error.response.data)
            })
    }
</script>

<style scoped>
    
</style>