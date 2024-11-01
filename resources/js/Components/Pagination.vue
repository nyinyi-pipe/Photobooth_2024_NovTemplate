<template>
 <Bootstrap5Pagination align="center" :data="tickets" @pagination-change-page="list"></Bootstrap5Pagination>
</template>
<script>
    import { Bootstrap5Pagination } from 'laravel-vue-pagination';
    export default {
        props: ['items'],
        components:{
            Bootstrap5Pagination
        },
        data(){
            return {
                tickets:this.items
            }
        },
         mounted(){
            this.list()
        },
        methods:{
            async list(page=1){
                await axios.get(`/api/tickets?page=${page}`).then(({data})=>{
                    this.tickets = data
                }).catch(({ response })=>{
                    console.error(response)
                })
            }
        }
    }
</script>