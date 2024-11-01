<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Welcome" />

    <div
    class="container"
    >
       <div class="min-vh-100 d-flex justify-content-center align-items-center gap-2">
            <Link :href="route('login')" class="btn btn-dark">Admin</Link>
            <Link :href="route('customer.dashboard')" class="btn btn-outline-dark">Customer</Link>
       </div>
    </div>
</template>
