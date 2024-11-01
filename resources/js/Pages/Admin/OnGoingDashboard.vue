<template>
    <div class="vh-100 d-flex flex-column align-items-center justify-content-center">
        <h1 class="text-warning display-1">Coming Soon</h1>
        <div class="w-50 d-flex justify-content-center gap-3">
            <Link :href="route('logout')" method="post"  class="btn btn-outline-danger "> LogOut</Link>
            <Link :href="route('ticket.index')" class="btn btn-outline-primary "> Ticket</Link>
        </div>
    </div>
</template>
<script setup>
import { Link,Head,router } from '@inertiajs/vue3';

</script>