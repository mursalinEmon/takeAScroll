<template>
  <div class="container">
        <!-- product add info start -->
        <form  @submit.prevent="updateProduct()">
            <div class="row">
                <div class="form-group col-md-6 col-sm-12 col-lg-6">
                    <label for="productName">Product Name</label>
                    <input
                        type="text"
                        class="form-control"
                        id="productName"
                        v-model="p_name"
                        placeholder="put product name"
                    />
                </div>
                <div class="form-group col-md-6 col-sm-12 col-lg-6">
                    <label for="productName">Product Price</label>
                    <input
                        type="number"
                        class="form-control"
                        id="productPrice"
                        v-model="p_price"
                        placeholder="put product Price"
                    />
                </div>
            </div>
            <div class="row">
                <!-- categories -->
                <div class="form-group col-md-6 col-sm-6 col-lg-6">
                    <label>Product Category( Current: {{ category_name }} )</label>
                    <select
                        class="form-control"
                        ref="category"
                        v-model="n_category"
                    >
                        <option class="text-center" value="" selected
                            >-----Select-----</option
                        >
                        <option
                            v-for="(category, index) in categories"
                            :key="index"
                            >{{ category.name }}</option
                        >
                    </select>
                </div>
                <div class="form-group col-md-3 col-sm-3 col-lg-3">
                    <label>Featured</label>
                    <select
                        class="form-control"
                        ref="category"
                        v-model="featured"
                    >
                        <option class="text-center" value="" selected
                            >-----Select-----</option
                        >
                       <option class="text-center" value="yes">Yes </option>
                           <option class="text-center" value="no">No </option>
                    </select>
                </div>
                 <div class="form-group col-md-3 col-lg-3 col-sm-3">
                     <!-- sub-categories -->
                    <label>Product discount</label>
                    <input class="form-control" type="number" name="discount" v-model="discount">
                </div>


            </div>
            <div class="row">
                <!-- categories -->

                <!-- sub-categories -->
                <div
                    v-if="n_category"
                    class="form-group col-md-6 col-sm-12 "
                >
                    <label>Product Sub-Category</label>
                    <select
                        class="form-control"
                        ref="sub_category"
                        v-model="n_sub_category"
                    >
                        <option class="text-center" value="" selected
                        >-----Select-----</option
                        >
                        <option
                            v-for="(category, index) in sub_categories"
                            :key="index"
                        >{{ category.name }}</option
                        >
                    </select>
                </div>
                <!--                status-->
                <div
                    v-if="n_category"
                    class="form-group col-md-6 col-sm-12"
                >
                    <label>Product Status</label>
                    <select
                        class="form-control"
                        ref="sub_category"
                        v-model="p_status"
                    >
                        <option class="text-center" value="" selected
                        >-----Select-----</option
                        >
                        <option value="used">Used</option>
                        <option value="new">New</option>

                    </select>
                </div>
            </div>
            <!-- warrenty , in stock amount -->
            <div class="row">
                <div class="form-group col-md-4 col-sm-12 col-lg-4">
                    <label for="productName">Product Warranty (Optional)</label>
                    <input
                        type="text"
                        class="form-control"
                        id="productName"
                        v-model="p_warrenty"
                        placeholder="put product warrenty"
                    />
                </div>
                <div class="form-group col-md-4 col-sm-12 col-lg-4">
                    <label for="productName">Product Stock Amount</label>
                    <input
                        type="number"
                        class="form-control"
                        id="productPrice"
                        v-model="p_stock"
                        placeholder="put product stock"
                    />
                </div>
                <div class="form-group col-md-4 col-sm-12 col-lg-4">
                    <label for="brandname">Product Brand</label>
                    <input
                        type="text"
                        class="form-control"
                        id="brandname"
                        v-model="p_brand"
                        placeholder="put product stock"
                    />
                </div>
            </div>

            <div class="form-group">
                <label>Product Description</label>
                  <vue-editor   v-model="p_description" />
            </div>
                    <!-- for image -->

            <div class="container">
                <div class="image-viewer">
                     <div v-for="(photo,index) in product_pictures" :key="index" >
                         <div class="image-box">
                            <div class="badge badge-primary cross" @click="crossImage(index)">X</div>
                            <img class="image" :src="path_image + photo" alt="product-photo">

                         </div>
                     <!-- <img src="../../../public/images/tahzdshuvo/products/65/1609477905.jpg" alt="static"> -->
                    </div>
                </div>
            </div>

            <button type="submt" class="btn btn-primary mt-4">Update Info</button>
        </form>
        <!-- product add info end -->
        <!-- image uploader started -->
        <h1 class="text text-center">Upload New Image For Product</h1>
        <div  class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="margin-bottom:20vh;">
                    <div class="card-header">
                        Upload Product Images For Product : {{ p_name }}
                    </div>
                    <div class="card-body" style="margin-top:20vh;">

                        <vue-dropzone
                            ref="myVueDropzone"
                            id="dropzone"
                            :options="dropzoneOptions"
                        ></vue-dropzone>
                    </div>
                    <button class="btn btn-success" @click="upload_image()">
                        upload
                    </button>
                     <button class="btn btn-secondary mt-3" @click="reload()">
                        Refresh
                    </button>
                </div>
            </div>
        </div>
        <!-- image uploader end    -->
    </div>
</template>

<script>
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";
import { VueEditor } from "vue2-editor";
export default {
 components: {
        vueDropzone: vue2Dropzone,
        components: { VueEditor },
    },
props:{
 product:{
     type:Object,
     default:null,
 },
category_name:"",
},
 watch: {
        // whenever question changes, this function will run
        n_category: function(newCategory, oldCategory) {
            this.fetch_sub_category(newCategory);
        }
    },
created(){
        this.p_name= this.product.name;
        this.discount=this.product.discount;
        this.p_price=this.product.price;
        this.p_description=this.product.product_decription;
        this.product_pictures=this.product.product_pictures;
        this.p_stock=this.product.product_stock,
        this.p_brand=this.product.brand_name;
        this.p_warrenty=this.product.product_warranty;
        this.p_tags=this.product.product_tags;
        this.p_category_id=this.product.category_id;
        this.p_status=this.product.p_status?this.product.p_status:"used";
        this.p_sub_category_id=this.product.sub_category_id;
        this.fetch_categories();
        this.dropzoneOptions.params.product_id=this.product.id;
        this.dropzoneOptions.params.store_id=this.product.store_id;


},
data:()=>{
    return{
        p_status:"",
        path_image:"/",
        discount:0,
        n_category:"",
        n_sub_category:"",
        p_name:"",
        featured:"",
        p_price:0,
        p_brand:"",
        p_description:"",
        product_pictures:[],
        p_stock:0,
        p_warrenty:0,
        // p_tags:[],
        p_category_id:null,
        p_sub_category_id:null,
        categories:[],
        sub_categories:[],
        dropzoneOptions: {
                url: "/product-image",
                autoProcessQueue: false,
                addRemoveLinks: true,
                ulpoadMultiple: true,
                parallelUploads: 5,
                params: {
                    product_id: "",
                    store_id:""

                },
                headers: {
                    "X-CSRF-TOKEN": document.head.querySelector(
                        "[name=csrf-token]"
                    ).content
                }
            }

    }
},
methods:{
     upload_image() {
            this.$refs.myVueDropzone.processQueue();
            this.$refs.myVueDropzone.processingmultiple();
            this.reload();
        },
        reload(){
               location.reload();
        },
    fetch_categories() {
            axios
                .get("/categories")
                .then(res => {
                    this.categories = res.data.categories;
                })
                .catch(err => {
                    console.log(err);
                });
        },
     fetch_sub_category(n_category) {
            axios
                .get(`/sub-category/${n_category}`)
                .then(res => {
                    console.log(res);
                    this.sub_categories = res.data.sub_categories;
                    this.p_category_id = res.data.category_id;
                })
                .catch(err => {
                    console.log(err);
                });
        },

    updateProduct(){
            let formData = new FormData();
            formData.append("category_id", (this.n_category?this.p_category_id:this.p_category_id));
            formData.append("sub_cat", this.n_sub_category);
            formData.append("name",this.p_name);
            formData.append("price",this.p_price);
            formData.append("product_pictures",this.product_pictures);
            formData.append("product_barnd",this.p_brand);
            formData.append("product_description",this.p_description);
            formData.append("status", this.p_status);
            formData.append("featured", this.featured);
            formData.append("discount", this.discount);



            // formData.append("tags",this.tags);
            axios.post(`/products/${this.product.id}/update`,formData).then((res)=>{
                this.$alert(
                    res.data.message,
                    "",
                    "success"
                );
            }).catch((err)=>{console.log(err);});
    },
    crossImage(index){
        this.product_pictures.splice(index,1);
    },
},

}
</script>

<style lang="scss">
    .image-viewer{
        display:flex;
        height: 25vh;
        width: 80vw;
        overflow-x: scroll;
        display: flex;
        justify-content:space-evenly;

    }
    .image{
        height: 19vh;
    }
    .image-box{
        margin: 1rem;

    }
    .cross{
        // position: absolute;
        margin-right: 3rem;
        cursor: pointer;
        // margin-top: -5rem;

    }
</style>
