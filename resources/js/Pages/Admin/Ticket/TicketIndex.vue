<template>
    <Head title="Manage All Tickets" />
    <AdminLayout>
    <div class="py-2 py-md-0">
    <h1 class="mb-3">Manage All Tickets</h1>
    <div class="row justify-content-center">
    <div class="col-12 col-md-12">
    <div class="p-3 border rounded shadow-md" >
    <div class="d-flex justify-content-end">
    <van-button color="#7232dd" data-bs-toggle="modal" class="mb-3" data-bs-target="#addTicketModal">Generate Ticket</van-button>

<div class="modal fade" id="addTicketModal" tabindex="-1"  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" >New Ticket</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addtricketform">
        <div class="mb-3">
    <label for="date" class="form-label">Ticket Date</label>
    <input type="date" class="form-control" v-model="ticketDate" id="date" >
    <InputError class="mt-2" :message="errors.ticket_by_date" />
  </div>
  <div class="mb-3">
    <label for="duration" class="form-label">Ticket Duration <span class="text-muted"> (for day:)</span></label>
    <input type="number" class="form-control" v-model="ticketDuration" id="duration" >
    <InputError class="mt-2" :message="errors.ticket_duration" />
  </div>
  <div class="mb-3">
    <label for="mount" class="form-label">Ticket Amount </label>
    <input type="number" class="form-control" v-model="ticketMount" id="mount" >
    <InputError class="mt-2" :message="errors.ticket_mount" />
  </div>
  <div class="mb-3">
    <label for="type" class="form-label">Ticket Type </label>
     <select class="form-select" v-model="ticketType">
      <option v-for="option in options" :value="option.value">
        {{ option.text }}
      </option>
    </select>
    <InputError class="mt-2" :message="errors.ticket_type" />
  </div>
  <div class="mb-3">
    <div class="d-flex justify-content-between">
    <label class="form-label">Generate Code</label>
    <button @click="generateCode" class="btn btn-dark">Generate</button>
    </div>
    <InputError class="mt-2" :message="errors.ticket_code"  />
    <div class="d-flex justify-content-between mt-2" :class="[isActive ? 'd-none' : 'd-flex']">
      <h5 id="showCode" class="mb-0"></h5>
      <button class="btn btn btn-outline-dark" @click="copyToClipboard">Copy</button>
    </div>
  </div>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" form="addtricketform" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" form="addtricketform" class="btn btn-outline-primary" @click="addTicket">Add</button>
      </div>
    </div>
  </div>
</div>
    </div>
        <DataTable :items="tickets" :columns="columns" :option="option">
            <th>#</th>
            <th>Code</th>
            <th>Amount</th>
            <th>Generate Date</th>
            <th>Duration Days</th>
            <th>Ticket Type</th>
            <th>Ticket Status</th>
            <th>Action</th>
        </DataTable>
    </div>
    </div>



<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Ticket - {{editTicketForm.editTicketTitle}}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editTicket">
          <div class="mb-3">
            <label for="date" class="form-label">Ticket Date</label>
            <input type="date" class="form-control" v-model="editTicketForm.ticketDateEdit" id="date" >
          </div>
          <div class="mb-3">
            <label for="duration" class="form-label">Ticket Duration <span class="text-muted"> (for day:)</span></label>
            <input type="number" class="form-control" v-model="editTicketForm.ticketDurationEdit" id="duration" >
          </div>
          <div class="mb-3">
            <label for="mount" class="form-label">Ticket Mount </label>
            <input type="number" class="form-control" v-model="editTicketForm.ticketMount" id="mount" >
          </div>
          <div class="mb-3">
            <label for="type" class="form-label">Ticket Type </label>
            <select class="form-select" v-model="editTicketForm.ticketType">
              <option v-for="option in options" :value="option.value" >
                {{ option.text }}
              </option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" form="editTicket" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
        <button type="button" form="editTicket" class="btn btn-outline-primary btn-sm" @click="updatedTicket">Update</button>
      </div>
    </div>
  </div>
</div>
    </div>
    </div>
    </AdminLayout>



</template>
<script setup>
import DataTable from "@/Components/admin/Datatable/DataTable.vue";
import bootstrapBundle from "bootstrap/dist/js/bootstrap.bundle";
import priceFormat from '@/composables/priceFormat';
import {reactive,ref,onMounted} from "vue";
import { Link,Head,router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import InputError from '@/Components/InputError.vue';
import AdminLayout from '@/Components/admin/Layout/AdminLayout.vue';
import axios from 'axios';

defineProps(['tickets'])

const option = ref({responsive:true,autoWidth:false,dom:'Bfrtip'});

const columns = [
                {data:null, render: function(data,type,row,meta)
                {return `${meta.row+1}`}},
                {data:'ticket_code'},
                {data:null,render:function(data,type,row,meta){
                    return `${priceFormat(row.ticket_mount)}`;
                }},
                {data:'ticket_by_date'},
                {data:'ticket_duration'},
                {data:'ticket_type'},
                {data:null,render:function(data,type,row,meta){
                    return `<div class="form-check form-switch">
                    <input class="form-check-input statuses"  data-id="${row.id}" ${row.status == 1 ? 'checked' : '' }   type="checkbox" role="switch" style="width:3em;height:1.5em;">
                  </div>`
                }},
                {data:null,render:function(data,type,row,meta){
                    return `<div class="d-flex gap-2">
                    <button class="btn btn-sm btn-outline-success editStatuses" dataId="${row.id}">Edit</button>
                    <button class="btn btn-sm btn-outline-danger" >Delete</button>
                  </div>`
                }}
            ];

const options = ref([
  { text: 'Ticket', value: 'Ticket' },
  { text: 'Cash', value: 'Cash' },
])

let isActive = ref(true);
let ticketDate = ref("");
let ticketMount = ref(null);
let ticketType = ref(null);
let ticketDuration = ref(null);
let errors = ref({})
const modal =ref(null);
const editTicketForm = reactive({
    ticketDateEdit : null,
    ticketDurationEdit : null,
    editTicketTitle : null,
    editTicketId : null,
    ticketMount:null,
    ticketType:null
})
onMounted(() => {
        modal.value = new bootstrapBundle.Modal("#editModal");
        const statuses = document.querySelectorAll(".statuses")
        statuses.forEach((status)=>{
            status.addEventListener('click',function(e){
                console.log(e.target.checked);
                    let data = {status:1}
                    if(!e.target.checked){
                        data.status = 0;
                    }
                    let id = e.target.getAttribute('data-id');
                    router.patch(`/admin/ticket/status/${id}`,data,{
  onSuccess:()=>{
            const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                            })

                Toast.fire({
                icon: 'success',
                title: `Ticket status updated.`
                })
                },
                onError:()=>{
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
                footer: '<a href="">Why do I have this issue?</a>'
                })
                }
                })
                })
            })


        const editStatuses = document.querySelectorAll(".editStatuses")
        editStatuses.forEach((status)=>{
            status.addEventListener('click',async function(e){
                const id = status.getAttribute("dataId");
                const data = await fetch('/admin/ticket/'+id);
                const {ticket} = await data.json();
                editTicketForm.ticketDateEdit = ticket.ticket_by_date
                editTicketForm.ticketDurationEdit = ticket.ticket_duration
                editTicketForm.editTicketTitle = ticket.ticket_code;
                editTicketForm.editTicketId = ticket.id;
                editTicketForm.ticketMount = ticket.ticket_mount;
                editTicketForm.ticketType = ticket.ticket_type;

                modal.value.show();
            })
            })

        })




const addTicket = (e) =>{
  e.preventDefault();
  let generateCode = document.getElementById("showCode").innerText;

  const datas = {
    ticket_by_date:ticketDate.value,
    ticket_mount:ticketMount.value,
    ticket_duration:ticketDuration.value,
    ticket_type:ticketType.value,
    ticket_code:generateCode
  }
  router.post('/admin/ticket', datas,{
    onSuccess: () => {
      ticketDate.value = "";
      ticketDuration.value = "";
      ticketMount.value = "";
      generateCode = "";
      isActive.value = true;
    const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 3000,
                  timerProgressBar: true,
                  didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                  }
                })

Toast.fire({
  icon: 'success',
  title: 'Added new a ticket successfully.'
})
    },
    onError:(err)=>{
      errors.value = err;
    }
  })
}

const ticketEdit = async (id) => {
  const data = await fetch('/admin/ticket/'+id);
  const {ticket} = await data.json();
  editTicketForm.ticketDateEdit = ticket.ticket_by_date
  editTicketForm.ticketDurationEdit = ticket.ticket_duration
  editTicketForm.editTicketTitle = ticket.ticket_code;
  editTicketForm.editTicketId = ticket.id;
  editTicketForm.ticketMount = ticket.ticket_mount;
  editTicketForm.ticketType = ticket.ticket_type;

  modal.value.show();
}

const updatedTicket = () => {
  router.patch(`/admin/ticket/${editTicketForm.editTicketId}`,editTicketForm,{
  onSuccess:()=>{
   const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 3000,
                  timerProgressBar: true,
                  didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                  }
                })

Toast.fire({
  icon: 'success',
  title: `${editTicketForm.editTicketTitle} has been updated.`
})
modal.value.hide();
  },
  onError:()=>{
  Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'Something went wrong!',
  footer: '<a href="">Why do I have this issue?</a>'
})
  }
  })
}

const ticketDelete = (id) => {
  Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
      router.delete('/admin/ticket/'+id,{
        onSuccess: () => {
        Swal.fire(
              'Deleted!',
              'Your ticket has been deleted.',
              'success'
            )
        },
        onError:()=>{
Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'Something went wrong!',
})
        }
      })
    
    
  }
})
}

const generateCode =  async (e) => {
  e.preventDefault();
  try{
    const datas = await fetch('/admin/generate-code')
    const code = await datas.json();
    showCode.value = code.code;
    document.getElementById("showCode").innerText = code.code
    isActive.value = !isActive.value;
  }catch(err){
    console.log(err.message());
  }
}

const copyToClipboard = async (e) => {
  e.preventDefault();
  try {
    await navigator.clipboard.writeText(document.getElementById("showCode").innerText);
    const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 3000,
                  timerProgressBar: true,
                  didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                  }
                })

Toast.fire({
  icon: 'success',
  title: `copied!`
})
  } catch (err) {
    console.error('Failed to copy!', err);
  }
};

</script>

