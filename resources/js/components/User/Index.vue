<script setup>
import {onMounted, ref} from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

let users = ref([])

let name = ref('')
let email = ref('')

const token = localStorage.getItem('token');

const getUsers = () => {
    axios.get('/api/users', { headers: { 'Authorization': 'Bearer ' + token } } )
    .then((response) => {
        users.value = response.data
    })
}

const setEdit = (userid) => {
    router.push('/users/edit/' + userid)
}

const deleteUser = (userid) => {
    axios.delete('/api/users/' + userid, { headers: { 'Authorization': 'Bearer ' + token } })
    .then(response => {
      console.log('Item Deleted:')
      getUsers()
    })
    .catch(error => {
      console.error('Error creating item:', error)
    });
}

onMounted(() => {
    getUsers()
})

</script>

<template>
    <h2>User List</h2>

    <table class="table table-striped table-sm table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="user in users" :key="user.id">
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>
                    <button @click="setEdit( user.id)" class="btn btn-primary"> edit </button>
                    <button @click="deleteUser( user.id)" class="btn btn-danger"> Del </button>
                </td>
            </tr>
        </tbody>
    </table>
</template>
