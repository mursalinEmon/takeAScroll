<template>
    <div>
        <div v-if="stat" class="btn btn-success mt-4 d-flex justify-content-center" @click="()=>this.modal=true">Rate This</div>
        <div v-else class=" mt-4 d-flex justify-content-center">You Rated This</div>

        <div v-if="modal" class="modal">
            <div class="rating">
                <h2>Do You Want To Rate This Course ?</h2>
                <div class="stars">
                    <star-rating v-model="rating"></star-rating>
                </div>

                <button @click="manage_Rating()" class="btn btn-success float-right mt-5"> Done </button>
            </div>
        </div>
    </div>
</template>


<script>
    export default {

        props:{
            product_id:{
                default:null
            }
        },
        mounted(){
            this.check_Rating();
        },
        data:()=>({
            modal:false,
            rating:0,
            stat:true,

        }),
        methods:{
            manage_Rating(){
                this.modal=false;
                //then make a axios call based on the rating
                let formData = new FormData();
                formData.append('rating',this.rating);
                formData.append('product_id',this.product_id);
                axios.post(`/product-rating`,formData).then((res)=>{
                    this.$alert(
                        res.data.message,
                        "",
                        "success"
                    );
                }).catch((err)=>{console.log(err);})
            },
            check_Rating(){
                axios.get(`/product-rating/${this.product_id}`).then((res)=>{
                        this.stat=res.data.stat;
                }).catch((err)=>{console.log(err);})
            }
        }

    }
</script>

<style lang="scss" scoped>
    .modal{
        display: block;
        height: 100vh;
        width:100vw;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: rgba(0, 0, 0, 0.404);
        // transform: translate(50%,50%);
    }
    .rating{
        display: block;
        background-color: white;
        padding: 5rem;
        padding-top: 4rem;
        padding-bottom: 2rem;
    }
    .stars{
        margin-left: 25%;

    }
</style>
