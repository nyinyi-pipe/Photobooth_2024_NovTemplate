<template>
    <ClientLayout >
        <div class="d-flex vh-100 justify-content-center align-items-center">
            <div class="p-3 rounded shadow ">
                <h1 class="display-1 text-danger">Pending </h1>
                <div v-if="role == 'admin'" class="d-flex justify-content-center gap-3">
                    <a href="/" class="btn btn-outline-primary">Go To Home</a>
                    <a href="/admin/dashboard" class="btn btn-outline-warning">Refresh</a>
                </div>
                <div v-if="role == 'moderator'" class="d-flex justify-content-center gap-3">
                    <a href="/" class="btn btn-outline-primary">Go To Home</a>
                    <a href="/admin/ticket" class="btn btn-outline-warning">Refresh</a>
                </div>
                <div v-else class="d-flex justify-content-center gap-3">
                    <a href="/" class="btn btn-outline-primary">Go To Home</a>
                    <a href="/ready" class="btn btn-outline-warning">Refresh</a>
                </div>
            </div>
        </div>
    </ClientLayout>
</template>
<script setup>
import ClientLayout from "@/Components/client/Layout/ClientLayout.vue";
import { Head ,usePage} from '@inertiajs/vue3';
import {ref,onMounted} from "vue";

let role = ref(null)
onMounted(() => {
    role.value =  usePage().props.role;
  })
</script>