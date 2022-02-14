<template>
    <div class="container">
        <!-- product add info start -->
        <form v-if="!product_id" @submit.prevent="addProduct()">
             <div class="row">
                <div class="form-group col-md-4 col-sm-12 col-lg-4">
                    <label for="productName">Section/Sector/Block</label>
                    <input
                        type="text"
                        class="form-control"
                        id="productName"
                        v-model="p_section"
                        placeholder=""
                    />
                </div>
                <div class="form-group col-md-6 col-sm-12 col-lg-6">
                    <label>Area</label>
                    <select
                        class="form-control"
                        ref="sub_category"
                        v-model="p_area"
                    >
                        <option class="text-center" value="" selected
                            >-----Select-----</option
                        >
                        <option
                            v-for="(category, index) in areas"
                            :key="index"
                            >{{ category}}</option
                        >
                    </select>

                </div>
                <div class="form-group col-md-2 col-sm-12 col-lg-2">
                    <label for="brandname">District</label>
                    <input
                        readonly
                        type="text"
                        class="form-control"
                        id="brandname"
                        v-model="p_district"
                    />
                </div>
            </div>
            <div class="row">
                <!-- sub-categories -->
                <div

                    class="form-group col-md-6 col-sm-12 col-lg-6"
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
            <!-- Bed,Bath,Space -->
            <div v-if="(p_sub_category == 'Flat')" class="row">
                <div class="form-group col-md-4 col-sm-12 col-lg-4">
                    <label for="productName">Bed(Optional)</label>
                    <input
                        type="number"
                        class="form-control"
                        id="productName"
                        v-model="p_bed"
                        placeholder="put Number Of Bed-Rooms"
                    />
                </div>
                <div class="form-group col-md-4 col-sm-12 col-lg-4">
                    <label for="productName">Bath(Optional)</label>
                    <input
                        type="number"
                        class="form-control"
                        id="productPrice"
                        v-model="p_bath"
                        placeholder="Put Nunber Of Bath"
                    />
                </div>
                <div class="form-group col-md-4 col-sm-12 col-lg-4">
                    <label for="brandname">Total Space(Mandatory)</label>
                    <input
                        type="number"
                        class="form-control"
                        id="brandname"
                        v-model="p_space"
                        placeholder="Put Total Area in sqft"
                    />
                </div>
            </div>



            <div v-if="(p_sub_category != 'Flat' && p_sub_category!=='')" class="row">
                <div class="form-group col-md-4 col-sm-12 col-lg-4">
                    <label for="productName">Total Space</label>
                    <input
                        type="number"
                        class="form-control"
                        id="productName"
                        v-model="p_space"
                        placeholder="Put Total Area in sqft "
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
                        Upload Product Images For Product
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

        this.store_id=this.store.id;

         this.fetch_sub_category( "RealEstate");

    },
    data: function() {
        return {
            // we will pass the pruduct id  in the url collected from the server response after the product creation and the add image as update value
            store_id:'',
            p_district: "Dhaka",
            p_section: "",
            p_area: "",
            p_price: 0,

            p_category: "Realestate",

            p_category_id: "",
            p_sub_category: "",
            p_description: "",
            p_bed:0,
            p_bath:0,
            p_space:0,
            areas:["Bashundhara R-A",
                    "Uttara",
                    "Mirpur",
                    "Gulshan",
                    "Dhanmondi",
                    "Mirpur DOHS",
                    "Mohammadpur",
                    "Banasree",
                    "Banani",
                    "Aftab Nagar",
                    "Badda",
                    "Motijheel",
                    "Tejgaon",
                    "Kalabagan",
                    "Lalmatia",
                    "Kathalbagan",
                    "Shyamoli",
                    "Paribagh"],

            p_tags: [],
            product_id: "",
            categories: [],
            sub_categories: [],

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
            // this.price= this.price.toFixed(2);
            formData.append("category_id", this.p_category_id);
            formData.append("sub_cat_name", this.p_sub_category);
            formData.append("price", this.p_price);
            formData.append("p_description", this.p_description);
            formData.append("p_district", this.p_district);
            formData.append("p_section", this.p_section);
            // formData.append("p_section", this.p_section);
            formData.append("p_area", this.p_area);
            formData.append("p_bed", this.p_bed);
            formData.append("p_bath", this.p_bath);
            formData.append("p_space", this.p_space);


                axios
                .post(`/stores/${this.store_id}/realestate-product/store`, formData)
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
    },


};
</script>

<style>
.moving-button{
    transform: translateY(20vh);
}

</style>
