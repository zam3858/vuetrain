<script setup>
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <header>
    
  </header>
  <div class="wrapper">
    <nav>
        <RouterLink to="/vue">Home</RouterLink>
        <RouterLink to="/dashboard">Dashboard</RouterLink>
        <RouterLink to="/users">User</RouterLink>
    </nav>
    <RouterView />
  </div>

  
</template>
