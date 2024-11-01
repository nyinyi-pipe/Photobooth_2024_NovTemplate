<template>
  <Head title="Manage All Tickets" />
  <AdminLayout>
    <div class="py-2 py-md-0">
      <h1 class="mb-3">Manage All Tickets</h1>

      <div class="row justify-content-center">
        <div class="col-12 col-md-12">
          <div class="p-3 border rounded shadow-md">
            <div class="d-flex justify-content-between">
              <!-- <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" type="button"
                  id="dropdownDate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{ selectedDate }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownDate">
                  <a class="dropdown-item" @click="filterDate(today)">{{ today }} (Today)</a>
                  <a class="dropdown-item" @click="filterDate('All')">All Tickets</a>
                </div>
              </div> -->

              <div>
                <label for="datepicker" style="margin-right: 5px"
                  >Select a Date:</label
                >
                <flat-pickr
                  id="datepicker"
                  style="padding: 5px; width: 120px; text-align: center"
                  v-model="selectedDate"
                />
                <button
                  style="margin-left: 6px"
                  type="button"
                  class="btn btn-outline-success"
                  @click="clearFilter"
                >
                  Clear
                </button>
              </div>
              <van-button
                color="#7232dd"
                data-bs-toggle="modal"
                class="mb-3"
                data-bs-target="#addTicketModal"
                >Generate Ticket</van-button
              >

              <div
                class="modal fade"
                id="addTicketModal"
                tabindex="-1"
                aria-hidden="true"
              >
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5">New Ticket</h1>
                      <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                      ></button>
                    </div>
                    <div class="modal-body">
                      <form id="addtricketform">
                        <div class="mb-3">
                          <label for="date" class="form-label"
                            >Ticket Date</label
                          >
                          <input
                            type="date"
                            class="form-control"
                            v-model="ticketDate"
                            id="date"
                          />
                          <InputError
                            class="mt-2"
                            :message="errors.ticket_by_date"
                          />
                        </div>
                        <!-- <div class="mb-3">
                          <label for="duration" class="form-label">Ticket Duration </label>
                          <input type="number" class="form-control" v-model="ticketDuration" id="duration">
                          <InputError class="mt-2" :message="errors.ticket_duration" />
                        </div> -->
                        <div class="mb-3">
                          <label for="mount" class="form-label"
                            >Ticket Price
                          </label>
                          <input
                            type="number"
                            class="form-control"
                            v-model="ticketMount"
                            id="mount"
                          />
                          <InputError
                            class="mt-2"
                            :message="errors.ticket_mount"
                          />
                        </div>
                        <div class="mb-3">
                          <label for="number" class="form-label"
                            >Number of Tickets
                          </label>
                          <input
                            type="number"
                            class="form-control"
                            v-model="ticketType"
                            id="number"
                          />
                          <InputError
                            class="mt-2"
                            :message="errors.ticket_type"
                          />
                        </div>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button
                        type="button"
                        form="addtricketform"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal"
                        @click="formReset"
                      >
                        Close
                      </button>
                      <button
                        type="submit"
                        form="addtricketform"
                        class="btn btn-outline-primary"
                        v-if="!added"
                        @click="addTicket"
                      >
                        Add
                      </button>
                      <button
                        type="button"
                        form="addtricketform"
                        class="btn btn-outline-success"
                        v-if="added"
                        data-bs-dismiss="modal"
                        @click="print"
                      >
                        Print
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Ticket Code</th>
                    <th>Ticket Price</th>
                    <th>Generate Date</th>
                    <th>Available Days</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody
                  v-for="ticket in mainTickets"
                  :style="{
                    'background-color': ticket.ticket_used ? '#efefef' : '',
                  }"
                >
                  <tr>
                    <th>{{ ticket.id }}</th>
                    <th>{{ ticket.ticket_code }}</th>
                    <th>{{ priceFormat(ticket.ticket_mount) }}</th>
                    <th>{{ ticket.ticket_by_date }}</th>
                    <th>{{ ticket.ticket_duration }}</th>
                    <th>{{ ticket.ticket_used ? "Used" : "Valid" }}</th>
                    <th class="d-flex gap-2">
                      <button
                        class="btn btn-sm btn-outline-success"
                        @click="ticketEdit(ticket.id)"
                      >
                        Edit
                      </button>
                      <button
                        class="btn btn-sm btn-outline-danger"
                        @click="ticketDelete(ticket.id)"
                      >
                        Delete
                      </button>
                    </th>
                  </tr>
                </tbody>
              </table>
              <!-- <Bootstrap5Pagination align="right" :data="mainTickets" @pagination-change-page="getItems">
              </Bootstrap5Pagination> -->
            </div>
          </div>
        </div>

        <div
          class="modal fade"
          id="editModal"
          tabindex="-1"
          aria-labelledby="editModalLabel"
          aria-hidden="true"
        >
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">
                  Ticket - {{ editTicketForm.editTicketTitle }}
                </h1>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="modal-body">
                <form id="editTicket">
                  <div class="mb-3">
                    <label for="date" class="form-label">Ticket Date</label>
                    <input
                      type="date"
                      class="form-control"
                      v-model="editTicketForm.ticketDateEdit"
                      id="date"
                    />
                  </div>
                  <!-- <div class="mb-3">
                    <label for="duration" class="form-label">Ticket Duration </label>
                    <input type="number" class="form-control" v-model="editTicketForm.ticketDurationEdit" id="duration">
                  </div> -->
                  <div class="mb-3">
                    <label for="mount" class="form-label">Ticket Mount </label>
                    <input
                      type="number"
                      class="form-control"
                      v-model="editTicketForm.ticketMount"
                      id="mount"
                    />
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  form="editTicket"
                  class="btn btn-outline-secondary btn-sm"
                  data-bs-dismiss="modal"
                >
                  Close
                </button>
                <button
                  type="button"
                  form="editTicket"
                  class="btn btn-outline-primary btn-sm"
                  @click="updatedTicket"
                >
                  Update
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
<script setup>
// import { Bootstrap5Pagination } from 'laravel-vue-pagination';

import bootstrapBundle from "bootstrap/dist/js/bootstrap.bundle";
import priceFormat from "@/composables/priceFormat";
import { reactive, computed, ref, onMounted, watchEffect, watch } from "vue";
import { Link, Head, router } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import InputError from "@/Components/InputError.vue";
import AdminLayout from "@/Components/admin/Layout/AdminLayout.vue";
import axios from "axios";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";

let mainTickets = ref({});
defineProps({
  tickets: Object,
});

const options = ref([
  { text: "Ticket", value: "Ticket" },
  { text: "Cash", value: "Cash" },
]);

let isActive = ref(true);
let ticketDate = ref("");
let ticketMount = ref(null);
let ticketType = ref(null);
// let ticketDuration = ref(null);
let errors = ref({});
const modal = ref(null);

let added = ref(false);

// const getTodayDate = () => {
//   var today = new Date();

//   // Get the components of the date
//   var month = today.getMonth() + 1; // Months are zero-based, so we add 1
//   var day = today.getDate();
//   var year = today.getFullYear().toString().slice(-2); // Get the last two digits of the year

//   // Format the components as dd/mm/yy
//   var formattedDate = ('0' + day).slice(-2) + '/' + ('0' + month).slice(-2) + '/' + year;

//   return formattedDate;
// }

// let today = getTodayDate();
// console.log(today);

let selectedDate = ref(null);

const editTicketForm = reactive({
  ticketDateEdit: null,
  // ticketDurationEdit: null,
  editTicketTitle: null,
  editTicketId: null,
  ticketMount: null,
  ticketType: null,
});

watch(selectedDate, (newValue, oldValue) => {
  selectedDate.value = newValue;
  getItems();
});

onMounted(() => {
  modal.value = new bootstrapBundle.Modal("#editModal");
  getItems();
});

const clearFilter = () => {
  selectedDate.value = null;
  getItems();
};

const getItems = async () => {
  if (selectedDate.value === null) {
    await axios
      .get(`/api/tickets`)
      .then((response) => {
        mainTickets.value = response.data;
      })
      .catch(({ response }) => {
        console.error(response);
      });
  } else {
    await axios
      .get(`/api/tickets/${selectedDate.value}`)
      .then((response) => {
        mainTickets.value = response.data;
      })
      .catch(({ response }) => {
        console.error(response);
      });
  }
};

const ticketStatus = (id) => {
  const tickets = document.querySelectorAll("#ticketStatusRow");

  let data = {
    status: null,
  };
  tickets.forEach((ticket) => {
    if (ticket.getAttribute("data-id") == id) {
      if (ticket.checked) {
        data.status = 1;
      } else {
        data.status = 0;
      }
    }
  });
  router.patch(`/admin/ticket/status/${id}`, data, {
    onSuccess: () => {
      const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener("mouseenter", Swal.stopTimer);
          toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
      });

      Toast.fire({
        icon: "success",
        title: `Ticket status updated.`,
      });
    },
    onError: () => {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Something went wrong!",
        footer: '<a href="">Why do I have this issue?</a>',
      });
    },
  });
};

const formReset = () => {
  ticketDate.value = "";
  // ticketDuration.value = "";
  ticketMount.value = "";
  ticketType.value = "";
  isActive.value = true;
  added.value = false;
};

let ticketCodes;

let print = () => {
  formReset();
  // console.log(ticketCodes);
  const printWindow = window.open("", "_blank");
  printWindow.document.write(
    `
    <html>
      <head>
        <title>Print Tickets</title>
      </head>
      <style>
      .ticket {
        border: 1px solid black;
        padding: 20px 50px;
      }
      </style>
      <body>
        <h3 style="padding: 20px; text-align: center;">Tickets</h3>
        <div style="display: flex; gap: 20px; flex-wrap: wrap" id="tickets"></div>
        <script>
          ${JSON.stringify(ticketCodes)}.forEach(ticketCode => {
            const tickets = document.getElementById('tickets');
            const ticket = document.createElement('div');
            ticket.classList.add("ticket");
            ticket.textContent = ticketCode;
            tickets.appendChild(ticket);
          });
        </` +
      `script>
      </body>
    </html>
  `
  );
  printWindow.document.close();
  printWindow.onafterprint = printWindow.close;
  printWindow.print();
};

const addTicket = (e) => {
  e.preventDefault();

  const datas = {
    ticket_by_date: ticketDate.value,
    ticket_mount: ticketMount.value,
    // ticket_duration: ticketDuration.value,
    number_of_tickets: ticketType.value,
  };
  axios
    .post("/admin/ticket", datas)
    .then((response) => {
      ticketCodes = response.data.ticketCodes;

      added.value = true;
      getItems();
      const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener("mouseenter", Swal.stopTimer);
          toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
      });

      Toast.fire({
        icon: "success",
        title: "Added a new ticket successfully.",
      });
    })
    .catch((error) => {
      console.log(error);
      errors.value = error.response.data.errors;
    });
};

const ticketEdit = async (id) => {
  const data = await fetch("/admin/ticket/" + id);
  const { ticket } = await data.json();
  editTicketForm.ticketDateEdit = ticket.ticket_by_date;
  // editTicketForm.ticketDurationEdit = ticket.ticket_duration
  editTicketForm.editTicketTitle = ticket.ticket_code;
  editTicketForm.editTicketId = ticket.id;
  editTicketForm.ticketMount = ticket.ticket_mount;
  editTicketForm.ticketType = ticket.number_of_tickets;

  modal.value.show();
};

const updatedTicket = () => {
  router.patch(`/admin/ticket/${editTicketForm.editTicketId}`, editTicketForm, {
    onSuccess: () => {
      getItems();
      const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener("mouseenter", Swal.stopTimer);
          toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
      });

      Toast.fire({
        icon: "success",
        title: `${editTicketForm.editTicketTitle} has been updated.`,
      });
      modal.value.hide();
    },
    onError: () => {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Something went wrong!",
        footer: '<a href="">Why do I have this issue?</a>',
      });
    },
  });
};

const ticketDelete = (id) => {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      router.delete("/admin/ticket/" + id, {
        onSuccess: () => {
          Swal.fire("Deleted!", "Your ticket has been deleted.", "success");
          getItems();
        },
        onError: () => {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Something went wrong!",
          });
        },
      });
    }
  });
};
</script>

