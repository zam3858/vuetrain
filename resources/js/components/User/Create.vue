<script setup>
import {ref} from 'vue'
import { useRouter } from 'vue-router'; 

let name = ref('')
let email = ref('')

const router = useRouter()
const token = localStorage.getItem('token')
const submit = () => {
    const data = { name: name.value, email: email.value }
    
    axios.post('/api/users', data, { headers: { 'Authorization': 'Bearer ' + token } })
    .then(response => {
      console.log('Item created:', response.data)
      
      router.push('/users')
    })
    .catch(error => {
      console.error('Error creating item:', error)
    });
}

</script>

<template>
    Create User

    <div class="mb-3 row">
        <label for="name" class="col-sm-2 col-form-label">Name</label>
        <div class="col-sm-10">
            <input type="text" v-model="name" class="form-control" placeholder="Name">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="email" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
            <input type="text" v-model="email" class="form-control"  placeholder="Email">
        </div>
    </div>
    <div class="mb-3 row">
        <button @click="submit" class="btn btn-primary col-2">Create</button>
    </div>
    
</template>
