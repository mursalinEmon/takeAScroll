<template>
  <div class="container">
      <h1 class="align-item-center">Contact Us</h1>
        <div class="form4 top">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10 ">
                            <div class="form-bg">
                                <form class="form" @submit.prevent="submitFile()">
                                    <div class="form-group"> <label class="sr-only">Name</label> <input v-model="name" type="text" class="form-control" required="" id="nameNine" placeholder="Your Name"> </div>

                                    <div class="form-group"> <label class="sr-only">Email</label> <input v-model="email" type="email" class="form-control" required="" id="emailNine" placeholder="Email Address"> </div>

                                    <div class="form-group"> <label class="sr-only">Your Message</label> <textarea v-model="message" class="form-control" required="" rows="7" id="messageNine" placeholder="Write message"></textarea> </div> 
                                    
                                    <button type="submit" class="btn text-center btn-blue">Send Message</button>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
  </div>
</template>

<script>

export default {
    data:()=>({
        name:"",
        email:"",
        message:""
    }),

    methods: {

        submitFile(){
            let formData = new FormData();
            formData.append("email", this.email);
            formData.append("message", this.message);
            formData.append("name", this.name);

            axios
                .post(`/contact/message`, formData)
                .then(res => {
                    console.log(res);
                    this.$alert(
                    res.data.message,
                    "",
                    "success"
                    );
                })
                .catch(err => {
                    console.log(err);
                });
        }
    },
}
</script>

<style>
.form4 {
    background-color: #4DB7FE;
    background-size: cover
}

.bg-primary{
    background-color: #51afee;
    background-size: cover;
}

.align-item-center{
    align-items: center;
    align-self: center;
    align-content: center;
}

.top {
    padding-top: 100px;
    padding-bottom: 100px
}

.form-bg {
    background: rgba(68, 68, 65, 0.77);
    padding: 20px
}

.form {
    background-color: white !important;
    padding: 20px
}

.form-group {
    margin-bottom: 20px
}

.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    border: 0
}

.form-control {
    border-top: 0px;
    border-left: 0px;
    border-right: 0px;
    border-bottom: 1px solid #61615e;
    background: transparent;
    -webkit-transition: all 0.3s ease 0s;
    -moz-transition: all 0.3s ease 0s;
    -o-transition: all 0.3s ease 0s;
    transition: all 0.3s ease 0s
}

button.btn {
    display: block;
    padding: 11px 32px;
    -webkit-transition: all 0.3s ease 0s;
    -moz-transition: all 0.3s ease 0s;
    -o-transition: all 0.3s ease 0s;
    transition: all 0.3s ease 0s;
    margin: 30px 0px
}

.btn-blue {
    background-color: #4285f4;
    color: #fff;
    border: 1px solid #4285f4
}
</style>