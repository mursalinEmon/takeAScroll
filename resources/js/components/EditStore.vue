<template>
<div>
        <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div >
                        <form class="card-body" @submit.prevent="submitFile()">
                            <div class="form-group">
                                <label for="store_name">Store Name</label>
                                <input v-model="store_name" type="text" class="form-control" id="store_name" aria-describedby="emailHelp" placeholder="Put Store Name" required>

                            </div>
                            <div class="form-group">
                                <label for="vendor_NID">Naional ID Card Number</label>
                                <input v-model="vendor_NID" type="text" class="form-control" id="vendor_NID" aria-describedby="emailHelp" placeholder="Put National ID Number" required>

                            </div>
                            <div class="form-group">
                                  <label  >Upload Store Banner <small>(Recomended: 13:6 ratio)</small></label><br>

                                    <div class="d-dlex justify-content-center align-item-center">
                                        <p>Existing Banner Imaged</p>
                                        <img  class="banner" :src="'/'+store.banner" alt="banner">
                                    </div>
                                    <div class="d-flex justify-content-center">
                                         <label for="image" class="btn btn-primary form-group mt-4" id="selector" style="cursor: pointer;height:40px!important;">Select Image <i class="fas fa-image"></i></label>
                                         <input class="form-group form-control"  ref="file" type="file" @change="processFile()" style="opacty:1;position: absolute;z-index:-1;" id="image" name="file">
                                            <div :style="{ 'background-image': `url(${previewImage})` }" v-if="previewImage" class="imagePreviewWrapper">
                                                <span @click="removeImage" class="badge badge-secondary rounded float-right m-2">x</span>
                                            </div>
                                    </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Store Description</label>
                                <textarea v-model="description" type="text" class="form-control" id="description"  placeholder="Put Your Store Description" required rows="3"></textarea>

                            </div>

                            <div class="form-group">
                                <label>Store Type</label>
                                <select class="form-group form-control" v-model="type" id="type" name="type">
                                    <option class="text-center" value="">---Select---</option>
                                    <option value="electronics">Electronics</option>
                                    <option value="realestate">Real Estate</option>
                                    <option value="cars">Cars</option>
                                </select>
                            </div>
                           <div class="form-group">
                               <div>
                                   <button type="submit" value="submit" class="btn btn-primary">Submit</button>
                               </div>

                            </div>

                        </form>

                    </div>

                </div>
                 <button  class="btn btn-success float-right mr-4 mt-4" @click="goBack()"> Go Back -></button>
            </div>

        </div>
    </div>
    </div>
</template>


<script>


export default {
    props:{
        store:{
            type:Object,
            default:null,
        }
    },
    data:()=>({
        file:"",
        store_name:"",
        next:false,
        type:"",
        physical_Address:"",
        vendor_NID:"",
        description:"",
        toggleButton: false,
        previewImage: null,
        store:null,
    }),

    created(){

        this.store_name=this.store.name;
        this.type=this.store.type;
        this.physical_Address=this.store.physical_Address;
        this.vendor_NID=this.store.vendor_NID;
        this.description=this.store.description;

    },
    methods:{
        processFile(){
           this.file = this.$refs.file.files[0];
            let reader = new FileReader
          reader.onload = e => {

            this.previewImage = e.target.result;

          }
          reader.readAsDataURL(this.file);
            this.$alert(
              "Image Uploaded",
              "",
              "success"
            )
        },
        submitFile(){
            let formData = new FormData();

            formData.append('file', this.file);
            formData.append('store_name', this.store_name);
            formData.append('type', this.type);
            formData.append('physical_Address',this.physical_Address);
            formData.append('vendor_NID',this.vendor_NID);
            formData.append('description',this.description);
            axios.post( `/stores/${this.store.id}`,
                formData,
                {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              }
            ).then((res)=>{

            //   this.store=res.data.store;
              this.file="";
              this.store_name="";
              this.type="";
              this.physical_Address="";
              this.vendor_NID="";
              this.description="";
              this.previewImage = null;
              this.$alert(
              res.data.message,
              "",
              "success"
            );
            this.next=true;
            location.reload();
            }).catch();


        },
      removeImage(){
        this.previewImage = null;
        this.file=null;
        this.$refs.file.value="";


      },
      goBack(){
          location.replace('/vendor-dashboard');
      }
    },
}
</script>

<style scoped lang="scss">
.imagePreviewWrapper {
    width: 150px;
    height: 150px;
    display: block;
    cursor: pointer;
    margin: 0 auto 30px;
    background-size: cover;
    background-position: center center;
}
.banner{
    height:20vh;
    width:20vw;
}
</style>
