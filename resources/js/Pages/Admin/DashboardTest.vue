<template>
    <Head title="Dashboard" />

    <AdminLayout>
        <h1 class="mb-3"> Dashboard </h1>
        <div class="row py-3 gap-3 justify-content-center">
            <div class="col-12">
                <div class="p-3 border rounded shadow-md" >
                    <DataTable :items="staffs" :option="option" :columns="staffsColumns" >
                        <th>#</th>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                    </DataTable>
                </div>
            </div>
            <div v-if="role" class="col-12">
                <div class="p-3 border rounded shadow-md" >
                    <DataTable :items="tickets" :option="option" :columns="ticketColumns">
                        <th>#</th>
                        <th>Ticket Code</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </DataTable>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from "@/Components/admin/Layout/AdminLayout.vue";
import DataTable from "@/Components/admin/Datatable/DataTable.vue";
import priceFormat from "@/composables/priceFormat";
import { Head ,usePage} from '@inertiajs/vue3';
import {ref,onMounted} from "vue";

const option = ref({responsive:true,autoWidth:false});

  let role = ref(null)
onMounted(() => {
    role.value =  usePage().props.auth.user.roles[0].name == 'admin';
  })
defineProps(['staffs','tickets'])
const staffsColumns = [
                {data:null, render: function(data,type,row,meta)
                {return `${meta.row+1}`}},
                {data:'avatar',render:function(data,type,row,meta){
                    return `<img src=${location.origin+"/avatars/"+row.avatar} style="width:40px;height:40px;border-radius:50%;object-fit:cover;"/>`;
                }},
                {data:'name'},
                {data:'email'},
                {data:'roles',render:function(data,type,row,meta){
                    return `${row.roles[0].name.toUpperCase()}`;
                }},
            ];
const ticketColumns = ref([
                {data:null, render: function(data,type,row,meta)
                {return `${meta.row+1}`}},
                {data:'ticket_code'},
                {data:'ticket_used', render: function(data,type,row,meta){return `${row.ticket_used ? "Used" : "Valid"}`}},
                {data:'ticket_mount', render: function(data,type,row,meta){
                    return `${priceFormat(row.ticket_mount)}`;
                }},
                {data:'ticket_by_date'}
            ]);;

</script>