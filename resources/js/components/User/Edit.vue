<script setup>
import {ref, onMounted} from 'vue'
import { useRoute , useRouter } from 'vue-router'; 

let name = ref('')
let email = ref('')
let id = ref('')
let errormessage = ref("")
let audits = ref([])

const router = useRouter()

onMounted(() => {
    getUser()
})
const token = localStorage.getItem('token');

const getUser = () => {
    const route = useRoute()
    

    axios.get('/api/users/' + route.params.id, 
        { headers: { 'Authorization': 'Bearer ' + token } }
    ).then(response => {
        id.value = response.data.id
        name.value = response.data.name
        email.value = response.data.email
        audits.value = response.data.audits

    }).catch(error => {
      if (error.response.status == 404) {
        errormessage.value = "Could not find user"
      } else {

      }

      errormessage.value = error.message
    });
}

const update = () => {
    const data = { id: id.value, name: name.value , email: email.value }

    axios.put('/api/users/' + id.value, data, { headers: { 'Authorization': 'Bearer ' + token } })
    .then(response => {
      console.log('Item updated:', response.data)
      router.push('/users')
    })
    .catch(error => {
        errormessage.value = error.response.data.message
    });
}

</script>

<template>
    Update User
    
    <div v-if="errormessage">
        {{ errormessage  }}
    </div>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <input type="text" v-model="name" placeholder="Name">
                </td>
                <td>
                    <input type="text" v-model="email"  placeholder="Email">
                </td>
            </tr>
            <tr>
                <td>
                    <button @click="update" >Update</button>
                </td>
            </tr>
        </tbody>
    </table>

    <ul>
        <li v-for="audit in audits">
            <table class="table table-compact">
                <td>{{ audit.old_values.name }}</td>
                <td>{{ audit.new_values.name }}</td>
            </table>
        </li>
    </ul>
</template>
