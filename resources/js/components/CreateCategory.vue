<template>
    <div class="container">
        <div class="card col-md-10">
            <form class="card-body" @submit.prevent="addCategory()">
                <div class="form-group col-sm-12 col-lg-6">
                    <label for="categoryName">Category Name</label>
                    <input
                        type="text"
                        class="form-control"
                        id="categoryName"
                        v-model="category_name"
                        placeholder="Category Name"
                    />
                </div>
                <div class="form-group col-sm-12 col-lg-6">
                    <label for="categoryType">Category Type</label>
                        <select
                            class="form-control"

                            v-model="category_type"
                        >
                            <option class="text-center" value="" selected
                                >-----Select-----</option
                            >
                            <option value="electronics">Electronics</option>
                            <option value="realestate">Realestate</option>
                            <option value="cars">Cars</option>

                        </select>

                </div>
                <div class="form-group col-sm-12 col-lg-6">
                    <label for="categoryDescription">Category Description</label>
                    <textarea class="form-control"
                    id="categoryDescription"
                    v-model="category_description"
                    placeholder="Category Description"></textarea>
                </div>

                <button style="float: right; margin-right: 5vw;" type="submit" class="btn btn-primary">Create</button>
            </form>

        </div>
        <br>
            <div @click="createSubCategory()" style="float:right; margin-right:5vw;" class="btn btn-primary">Create Subcategory</div>
    </div>
</template>

<script>
export default {
    data: function(){
        return{
            category_name:"",
            category_description:"",
            category:null,
            category_type:""
        }
    },
    methods:{
        addCategory(){

            axios
            .post('/create-category',{
                "cat_name":this.category_name,
                "cat_description":this.category_description,
                "category_type":this.category_type,
            })
            .then(res=>{
                console.log(res);
                this.category = res.data.category;
                this.$alert(
                        res.data.message,
                        "",
                        ""
                        );
            })
            .catch(err =>{
                console.log(err);
            });
        },

        createSubCategory(){
            location.replace(`/categories/${this.category.id}/subcategory/create`)
        },
    }
}
</script>

<style>

</style>
