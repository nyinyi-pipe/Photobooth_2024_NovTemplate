<template>
    <Head title="Template" />

    <AdminLayout>
        <div class="py-2 py-md-0">
            <h1 class="mb-3">Template Management</h1>

            <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="message">
                <strong>Danger! : </strong>
                <span>{{ message }}</span>
                <button type="button" class="btn-close" aria-label="Close" @click="message = ''"></button>
            </div>

            <div class="p-3 border rounded shadow-md">
                <div class="d-flex justify-content-end">
                    <button class="btn btn-success" @click="openAddTemplate">Add Template</button>
                    <div v-if="templateData[0]?.id">
                        <!-- <button class="btn btn-warning ms-1" @click="openEditTemplate(templateData[0]?.id)">Edit Template</button> -->
                        <button class="btn btn-danger ms-1" @click="openDeleteTemplate(templateData[0]?.id)">Delete Template</button>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="addStaff" ref="addStaff" tabindex="-1" aria-labelledby="addStaffLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="addStaffLabel">{{ isEditing ? "Edit Template" : "Add Template" }}</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addStaffForm" @submit.prevent="isEditing ? updateTemplate() : submit()">
                                    <div class="mb-3">
                                        <label for="template">Template File</label>
                                        <input type="file" id="template" @change="handleFileUpload" class="form-control" />
                                        <InputError class="mt-2" :message="form.errors.template" />
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" form="addStaffForm" class="btn btn-outline-primary">{{ isEditing ? "Update" : "Save" }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image Preview -->
            <div v-if="imageUrl" class="d-flex justify-content-center align-items-center my-3 border">
                <div class="text-center mb-2">
                    <h5>Template Image Preview:</h5>
                    <img :src="imageUrl" alt="Template Preview" class="img-fluid rounded shadow" style="max-width: 600px;" />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from "@/Components/admin/Layout/AdminLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref, computed, onMounted } from "vue";
import axios from "axios";
import Swal from "sweetalert2";
import bootstrapBundle from "bootstrap/dist/js/bootstrap.bundle";
import InputError from "@/Components/InputError.vue";
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    templateData: Array,
});

const imageUrl = ref(props.templateData[0]?.template ? `/storage/${props.templateData[0].template}` : null);
const addStaffModal = ref(null);
const form = ref({
    template: null,
    errors: {},
});
const message = ref(null);
const isEditing = ref(false);
const currentTemplateId = ref(null);

const openAddTemplate = () => {
    isEditing.value = false;
    addStaffModal.value.show();
};

const openEditTemplate = (id) => {
    isEditing.value = true;
    currentTemplateId.value = id;
    addStaffModal.value.show();
};

const openDeleteTemplate = async (id) => {
    const confirmation = await Swal.fire({
        title: "Are you sure?",
        text: "You will not be able to recover this template!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    });

    if (confirmation.isConfirmed) {
        try {
            await axios.delete(`/admin/template/${id}`);
            Swal.fire("Deleted!", "Your template has been deleted.", "success");
            props.templateData.splice(0, 1);
            imageUrl.value = null;
        } catch (error) {
            Swal.fire("Error", "Failed to delete the template.", "error");
        }
    }
};

const handleFileUpload = (event) => {
    form.value.template = event.target.files[0];
};

const submit = async () => {
    if (!form.value.template) {
        form.value.errors.template = "Please upload a file.";
        return;
    }

    const formData = new FormData();
    formData.append("template", form.value.template);

    try {
        const response = await axios.post("/admin/import/template", formData, {
            headers: { "Content-Type": "multipart/form-data" },
        });

        if (response.data.status === true) {
            Swal.fire("Success", "Template added successfully", "success");
            form.value.template = null;
            form.value.errors = {};
            document.getElementById('addStaffForm').reset();
            addStaffModal.value.hide();

            const newTemplateData = response.data.data;
            if (newTemplateData && newTemplateData.template) {
                props.templateData.splice(0, 1, newTemplateData);
                imageUrl.value = `/storage/${newTemplateData.template}`;
            } else {
                console.error("Template data is missing or incorrectly structured in the response.");
            }
        } else {
            message.value = response.data.error;
            addStaffModal.value.hide();
        }
    } catch (error) {
        form.value.errors = error.response?.data.errors || {};
    }
};

const updateTemplate = async () => {
    if (!form.value.template) {
        form.value.errors.template = "Please upload a file.";
        return;
    }

    const formData = new FormData();
    formData.append("template", form.value.template);

    try {
        const response = await axios.post(`/admin/template/${currentTemplateId.value}`, formData, {
            headers: { "Content-Type": "multipart/form-data" },
        });

        if (response.data.status === true) {
            Swal.fire("Success", "Template updated successfully", "success");
            form.value.template = null;
            form.value.errors = {};
            document.getElementById('addStaffForm').reset();
            addStaffModal.value.hide();

            const updatedTemplateData = response.data.data;
            if (updatedTemplateData && updatedTemplateData.template) {
                props.templateData.splice(0, 1, updatedTemplateData);
                imageUrl.value = `/storage/${updatedTemplateData.template}`;
            } else {
                console.error("Updated template data is missing or incorrectly structured.");
            }
        } else {
            message.value = response.data.error;
            addStaffModal.value.hide();
        }
    } catch (error) {
        form.value.errors = error.response?.data.errors || {};
    }
};

onMounted(() => {
    addStaffModal.value = new bootstrapBundle.Modal("#addStaff");
});
</script>
