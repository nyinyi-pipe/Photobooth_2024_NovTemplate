import { usePage } from '@inertiajs/vue3'

export function hasRole(name){
    return usePage().props.auth.user.roles.includes(name);
}