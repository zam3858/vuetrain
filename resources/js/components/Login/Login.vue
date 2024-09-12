<script setup>
import {ref} from 'vue'
import { useRouter } from 'vue-router'; 

let email = ref('')
let password = ref('')

const router = useRouter()

const submit = () => {
    const data = { email: email.value, password: password.value }
    
    axios.post('/api/sanctum/token', data)
    .then(response => {
      // save auth token to browser
      localStorage.setItem('token', response.data)
      axios.defaults.headers.common['Authorization'] = 'Bearer ' . response.data
      router.push('/dashboard')
    })
    .catch(error => {
      console.error('Error creating item:', error)
    });
}

</script>

<template>
    Welcome Login

    <div class="mb-3 row">
        <label for="email" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
            <input type="text" v-model="email" class="form-control"  placeholder="Email">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="name" class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-10">
            <input type="password" v-model="password" class="form-control" placeholder="Password">
        </div>
    </div>
    <div class="mb-3 row">
        <button @click="submit" class="btn btn-primary col-2">Create</button>
    </div>
    
</template>
