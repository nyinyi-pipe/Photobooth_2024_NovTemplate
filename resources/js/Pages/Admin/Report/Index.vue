<template>
  <Head title="Reports" />

  <AdminLayout>
    <div class="py-2 py-md-0">
      <h1 class="mb-3">Reports</h1>
      <div class="p-3 border rounded shadow-md">
        <DataTable :items="reports" :option="option" :columns="columns">
          <th>#</th>
          <th>Ticket Code</th>
          <th>Status</th>
          <th>Ticket Price</th>
          <th>Ticket Date</th>
        </DataTable>
      </div>
    </div>
  </AdminLayout>
</template>
<script setup>
import AdminLayout from "@/Components/admin/Layout/AdminLayout.vue";
import DataTable from "@/Components/admin/Datatable/DataTable.vue";
import priceFormat from "@/composables/priceFormat";
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";

const columns = ref([
  {
    data: null,
    render: function (data, type, row, meta) {
      return `${meta.row + 1}`;
    },
  },
  { data: "ticket_code" },
  {
    data: "ticket_used",
    render: function (data, type, row, meta) {
      return `${row.ticket_used ? "Used" : "Valid"}`;
    },
  },
  {
    data: "ticket_mount",
    render: function (data, type, row, meta) {
      return `${priceFormat(row.ticket_mount)}`;
    },
  },
  { data: "ticket_by_date" },
]);

const option = ref({ responsive: true, autoWidth: false, dom: "Bfrtip" });
defineProps(["reports"]);
</script>
