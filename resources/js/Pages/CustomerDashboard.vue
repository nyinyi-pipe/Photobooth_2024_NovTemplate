<template>
    <Head title="Dashboard" />
    <AppLayout>
        <h1 class="text-primary">Customer</h1>
        <Camera/>
    </AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/Customer/AppLayout.vue';
import Camera from '@/Components/Camera.vue';
import { Link } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';

</script>