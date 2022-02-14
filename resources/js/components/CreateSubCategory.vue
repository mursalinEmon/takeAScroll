<template>
    <div class="container">
         <div class="card col-md-10">
             <div class="card-header">{{ category.name }}</div>
            <form class="card-body" @submit.prevent="addSubCategory()">
                <div class="form-group col-sm-12 col-lg-6">
                    <label for="categoryName">SubCategory Name</label>
                    <input
                        type="text"
                        class="form-control"
                        id="categoryName"
                        v-model="sub_category_name"
                        placeholder="SubCategory Name"
                    />
                </div>
                <div class="form-group col-sm-12 col-lg-6">
                    <label for="categoryDescription">SubCategory Description</label>
                    <textarea class="form-control"
                    id="subCategoryDescription"
                    v-model="sub_category_description"
                    placeholder="SubCategory Description"></textarea>
                </div>

                <button style="float: right; margin-right: 5vw;" type="submit" class="btn btn-primary">Create</button>
            </form>

        </div>
        <br>
        <div style="float: right; margin-right: 5vw;" v-if="backButton" @click="goBack()" class="btn btn-primary">Go Back</div>
    </div>
</template>

<script>
export default {
    props:{
        category:{
            type:Object,
            default:null
        }
    },

    data:function(){
        return{
            sub_category_name:"",
            sub_category_description:"",
            backButton:false,
        }
    },

    methods:{
        addSubCategory(){
            let formData = new FormData();
            formData.append("sub_cat_name",this.sub_category_name);
            formData.append("sub_cat_description",this.sub_category_description);

            axios.post(`/categories/${this.category.id}/subcategory/create`,formData).then((res)=>{
                // console.log(res);
                this.$alert(
                        res.data.message,
                        "",
                        ""
                        );

                this.sub_category_name="";
                this.sub_category_description="";
                this.backButton=true;
            }).catch((err)=>{
                console.log(err);
            })
        },

        goBack(){
            location.replace('/create-category');
        }
    }
}
</script>

<style>

</style>
