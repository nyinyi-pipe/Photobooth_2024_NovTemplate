<template>
    <DataTable 
        :data="items" :columns="columns" class="table table-striped table-bordered display"
        :options="option"
    >
        <thead>
            <tr>
                <slot/>
            </tr>
        </thead>
    </DataTable>
</template>

<script>
    import DataTable from 'datatables.net-vue3';
    import DataTableLib from 'datatables.net-bs5';
    import Buttons from 'datatables.net-buttons-bs5';
    import ButtonsHtml5 from 'datatables.net-buttons/js/buttons.html5.mjs';
    import print from 'datatables.net-buttons/js/buttons.print.mjs';
    import 'datatables.net-responsive-bs5';
    import JsZip from 'jszip';
    window.JsZip = JsZip;
    DataTable.use(DataTableLib);
    DataTable.use(ButtonsHtml5);
export default {
    components:{
        DataTable
    },
    props: ['items','columns','option'],
}
</script>