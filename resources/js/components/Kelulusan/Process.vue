<script setup>
import {ref, onMounted} from 'vue'
import { useRoute , useRouter } from 'vue-router'; 

let name = ref('')
let email = ref('')
let id = ref('')
let status = ref('approved')
let remark = ref('')
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

const process = () => {
    const data = { status: status.value, remark: remark.value }

    axios.put('/api/kelulusan/' + id.value, data, { headers: { 'Authorization': 'Bearer ' + token } })
    .then(response => {
      router.push('/kelulusan')
    })
    .catch(error => {
        errormessage.value = error.response.data
    });
}

</script>

<template>
   Proses Kelulusan Pengguna
    
    <div v-if="errormessage">
        {{ errormessage  }}
    </div>

    <div class="">
        <label class="form-label">Name</label>
        <div class="form-control">{{ name }}</div>
    </div>

    <div class="">
        <label class="form-label">Email</label>
        <div class="form-control">{{ email }}</div>
    </div>

    <div>
        <label class="form-label">Kelulusan</label>

        <input type="radio" id="approve" value="approved" v-model="status" />
        <label for="one">Lulus</label>

        <input type="radio" id="approve" value="rejected" v-model="status" />
        <label for="two">Tolak</label>
    </div>

    <div v-if="status == 'rejected'">
        <label class="form-label">Remark</label>
        <textarea v-model="remark" placeholder="sila berikan remark"></textarea>
    </div>

    <div>
        <button @click="process" class="btn btn-primary" >Update</button>
    </div>

</template>
