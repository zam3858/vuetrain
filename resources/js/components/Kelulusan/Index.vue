<script setup>
import {onMounted, ref} from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

let users = ref([])
let axi = ref(axios.defaults.headers)
let name = ref('')
let email = ref('')

const token = localStorage.getItem('token');

const getUsers = () => {
    axios.get('/api/kelulusan', { headers: { 'Authorization': 'Bearer ' + token } } )
    .then((response) => {
        users.value = response.data
    })
}

const setKelulusan = (userid) => {
    router.push('/kelulusan/' + userid)
}

onMounted(() => {
    getUsers()
})

</script>

<template>
    <h2>Senarai Menunggu Prosesan</h2>

    <table class="table table-striped table-sm table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="user in users" :key="user.id">
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.status }}</td>
                <td>
                    <button @click="setKelulusan( user.id)" class="btn btn-primary"> Process </button>
                </td>
            </tr>
        </tbody>
    </table>
</template>
