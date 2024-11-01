<template>
  <Head title="Staff" />

  <AdminLayout>
    <div class="py-2 py-md-0">
      <h1 class="mb-3">Staff Approvement</h1>
      <div class="p-3 border rounded shadow-md">
        <div class="d-flex justify-content-end">
          <button class="btn btn-success" @click="openAddStaff">
            Add Staff
          </button>
        </div>
        <DataTable :items="users" :columns="columns" :option="option">
          <th>#</th>
          <th>Avatar</th>
          <th>Name</th>
          <th>Email</th>
          <th>Approvement</th>
        </DataTable>

        <div
          class="modal fade"
          id="addStaff"
          ref="addStaff"
          tabindex="-1"
          aria-labelledby="addStaffLabel"
          aria-hidden="true"
        >
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="addStaffLabel">Add Staff</h1>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="modal-body">
                <form id="addStaffForm" @submit.prevent="submit">
                  <div class="mb-3">
                    <label for="name">Name</label>
                    <input
                      type="text"
                      id="name"
                      placeholder="name"
                      v-model="form.name"
                      class="form-control"
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                  </div>
                  <div class="mb-3">
                    <label for="email">Email</label>
                    <input
                      type="email"
                      id="email"
                      placeholder="email"
                      v-model="form.email"
                      class="form-control"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                  </div>
                  <div class="mb-3">
                    <label for="password">Password</label>
                    <input
                      type="password"
                      id="password"
                      placeholder="password"
                      v-model="form.password"
                      class="form-control"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                  </div>
                  <div class="mb-3">
                    <label for="password_confirmation">Confirm Password</label>
                    <input
                      type="password"
                      id="password_confirmation"
                      placeholder="password confirm"
                      v-model="form.password_confirmation"
                      class="form-control"
                    />
                    <InputError
                      class="mt-2"
                      :message="form.errors.password_confirmation"
                    />
                  </div>
                  <div class="mb-3">
                    <label for="avatar">Avatar</label>
                    <input
                      type="file"
                      id="avatar"
                      @input="form.avatar = $event.target.files[0]"
                      class="form-control"
                    />
                    <progress
                      v-if="form.progress"
                      :value="form.progress.percentage"
                      max="100"
                    >
                      {{ form.progress.percentage }}%
                    </progress>
                    <InputError class="mt-2" :message="form.errors.avatar" />
                  </div>
                  <div class="mb-3">
                    <label>Choose Role</label>
                    <VueMultiselect
                      v-model="form.setRole"
                      :options="roles"
                      :close-on-select="true"
                      :clear-on-select="false"
                      placeholder="Select Role"
                      label="name"
                      track-by="name"
                    />
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  form="addStaffForm"
                  class="btn btn-outline-secondary"
                  data-bs-dismiss="modal"
                >
                  Close
                </button>
                <button
                  type="submit"
                  form="addStaffForm"
                  class="btn btn-outline-primary"
                >
                  Save
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
import VueMultiselect from "vue-multiselect";
import AdminLayout from "@/Components/admin/Layout/AdminLayout.vue";
import DataTable from "@/Components/admin/Datatable/DataTable.vue";
import bootstrapBundle from "bootstrap/dist/js/bootstrap.bundle";
import { useForm, Head } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import { ref, onMounted } from "vue";
import axios from "axios";
import Swal from "sweetalert2";

defineProps(["users", "roles"]);

const option = ref({ responsive: true, autoWidth: false, dom: "Bfrtip" });

const columns = [
  {
    data: null,
    render: function (data, type, row, meta) {
      return `${meta.row + 1}`;
    },
  },
  {
    data: "avatar",
    render: function (data, type, row, meta) {
      return `<img src=${
        location.origin + "/avatars/" + row.avatar
      } style="width:40px;height:40px;border-radius:50%;object-fit:cover;"/>`;
    },
  },
  { data: "name" },
  { data: "email" },
  {
    data: null,
    render: function (data, type, row, meta) {
      return `<div class="form-check form-switch">
                    <input class="form-check-input statuses"  data-id="${
                      row.id
                    }" ${
        row.status == 1 ? "checked" : ""
      }   type="checkbox" role="switch" style="width:3em;height:1.5em;">
                  </div>`;
    },
  },
];
const addStaffModal = ref(null);
const form = useForm({
  name: null,
  email: null,
  password: null,
  password_confirmation: null,
  avatar: null,
  setRole: null,
});

const openAddStaff = () => {
  addStaffModal.value.show();
};
const submit = () => {
  form.post("/register", {
    onFinish: () => {
      form.name = null;
      form.email = null;
      form.password = null;
      form.password_confirmation = null;
      form.avatar = null;
      form.setRole = null;
      addStaffModal.value.hide();
    },
  });
};

onMounted(() => {
  addStaffModal.value = new bootstrapBundle.Modal("#addStaff");
  const statuses = document.querySelectorAll(".statuses");
  statuses.forEach((status) => {
    status.addEventListener("click", function (e) {
      let data = { status: 1 };
      if (!e.target.checked) {
        data.status = 0;
      }
      let id = e.target.getAttribute("data-id");
      axios.patch("/admin/staffs/" + id, data).then((res) => {
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
          icon: `${data.status == 1 ? "success" : "error"}`,
          title: `${res.data.msg}`,
        });
      });
    });
  });
});
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
