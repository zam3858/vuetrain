<script setup>
import {onMounted, ref} from 'vue'

let users = ref([])

const getUsers = () => {
    axios.get('/api/users')
    .then((response) => {
        users.value = response.data
    })
}

onMounted(() => {
    getUsers()
})

</script>

<template>
    User

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="user in users" :key="user.id">
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
            </tr>
        </tbody>
    </table>
</template>
