<template>
    <v-card>
        <v-card-item>
            <v-card-title class='text-center'>
                Register
            </v-card-title>
        </v-card-item>

        <v-card-text>
            <v-text-field 
                label="Name"
                v-model='form.name'
                prepend-icon="mdi-account"
                clearable
            />

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

            <v-text-field 
                label="Confirmation"
                v-model='form.password_confirmation'
                prepend-icon="mdi-asterisk"
                clearable
            />
        </v-card-text>

        <v-card-actions class='mb-4'>
            <v-row class='text-center'>
                <v-btn @click="register" color='primary' class='mx-auto' variant='elevated'>
                    Button 
                </v-btn>
            </v-row>{{text}}


        </v-card-actions>
    </v-card>
</template>

<script setup>
    import { ref,computed } from 'vue'
    import axios from 'axios'
    const form = ref({
        'name': '',
        'email': '',
        'password': '',
        'password_confirmation': '',
    })
    const text = computed(() => import.meta.env.VITE_BACKEND_URL)
    function register() {
        axios.post('/register', form.value)
            .then(response => {
                console.log(response)
            })
            .catch(error => {
                console.log(error.response.data)
            })
    }
</script>
<style scoped>
    
</style>