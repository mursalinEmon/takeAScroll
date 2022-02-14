<template>
    <div class="container">
        <!-- product add info start -->
        <form v-if="!product_id" @submit.prevent="addProduct()">
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
                    <label>Product Category</label>
                    <select
                        class="form-control"
                        ref="category"
                        v-model="p_category"
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

                <div
                    v-if="p_category"
                    class="form-group col-md-6 col-sm-12"
                >
                    <label>Product Sub-Category</label>
                    <select
                        class="form-control"
                        ref="sub_category"
                        v-model="p_sub_category"
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
                    v-if="p_category"
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
                        placeholder="put product brand"
                    />
                </div>
            </div>

            <div class="form-group">
                <label>Product Description</label>
                 <vue-editor   v-model="p_description" />
            </div>
            <button type="submit" class="btn btn-primary">Next</button>
        </form>
        <!-- product add info end -->
        <!-- image uploader started -->
        <div v-else class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Upload Product Images For Product : {{ p_name }}
                    </div>
                    <div class="card-body">
                        <vue-dropzone
                            ref="myVueDropzone"
                            id="dropzone"
                            :options="dropzoneOptions"
                        ></vue-dropzone>
                    </div>
                    <button class="btn btn-success" @click="upload_image()">
                        upload
                    </button>
                </div>
            </div>

        </div>
            <button class="btn btn-primary float-right moving-button" @click="go_Back()">Go Back ></button>

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
        store:{
            type:Object,
            default:null
        }
    },
    created() {
        this.fetch_categories();
        this.store_id=this.store.id;
    },
    data: function() {
        return {
            // we will pass the pruduct id  in the url collected from the server response after the product creation and the add image as update value
            store_id:'',
            discount:0,
            p_name: "",
            p_brand: "",
            p_price: 0.0,
            p_category: "",
            p_category_id: "",
            p_sub_category: "",
            p_description: "",
            featured:"",
            p_warrenty: "",
            p_stock: 0,
            p_tags: [],
            product_id: "",
            categories: [],
            sub_categories: [],
            p_status:"",

            dropzoneOptions: {
                url: "/product-image",
                autoProcessQueue: false,
                addRemoveLinks: true,
                ulpoadMultiple: true,
                parallelUploads: 5,
                params: {
                    product_id: "",
                    store_id:"",
                },
                headers: {
                    "X-CSRF-TOKEN": document.head.querySelector(
                        "[name=csrf-token]"
                    ).content
                }
            }
        };
    },
    watch: {
        // whenever question changes, this function will run
        p_category: function(newCategory, oldCategory) {
            this.fetch_sub_category(newCategory);
        }
    },
    methods: {
        upload_image() {
            this.$refs.myVueDropzone.processQueue();
            this.$refs.myVueDropzone.processingmultiple();

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
        fetch_sub_category(p_category) {
            axios
                .get(`/sub-category/${p_category}`)
                .then(res => {
                    console.log(res);
                    this.sub_categories = res.data.sub_categories;
                    this.p_category_id = res.data.category_id;
                })
                .catch(err => {
                    console.log(err);
                });
        },
        go_Back(){
        // console.log("im am hit");
         location.replace("/vendor-dashboard");

    },
        addProduct() {

            let formData = new FormData();
            formData.append("category_id", this.p_category_id);
            formData.append("sub_cat_name", this.p_sub_category);
            formData.append("name", this.p_name);
            formData.append("brand", this.p_brand);
            formData.append("price", this.p_price);
            formData.append("warrenty", this.p_warrenty);
            formData.append("stock", this.p_stock);
            formData.append("descrption", this.p_description);
            formData.append("status", this.p_status);
            formData.append("featured", this.featured);
            formData.append("discount", this.discount);






            if(this.p_category_id === "" || this.p_sub_category === "" || this.p_name==="" || this.p_brand ==="" ||  this.p_warrenty === "" || this.p_price === 0 || this.p_warrenty === "" ||  this.p_description === ""){

                        this.$alert(
                        res.data.message,
                        "",
                        "Fill all The Form Fields "
                        );
            }else{
                axios
                .post(`/stores/${this.store_id}/products`, formData)
                .then(res => {
                    console.log(res);
                    this.product_id = res.data.product.id;
                    this.dropzoneOptions.params.product_id = this.product_id;
                    this.dropzoneOptions.params.store_id=this.store_id;
                })
                .catch(err => {
                    console.log(err);
                });
            }

        }
    },


};
</script>

<style>
.moving-button{



    transform: translateY(20vh);
}

</style>
