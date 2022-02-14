<template>
<div>
    <li class="nav-item dropdown no-arrow mx-1" >
<!--        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
        <button class="nav-link " style="background: none;
                                            border: none;
                                            font: inherit;
                                            cursor: pointer;"
                aria-expanded="false">

        <i class="fas fa-bell fa-fw" @click="()=>this.bell=!this.bell"></i>
            <!-- Counter - Alerts -->
            <span class="badge badge-danger badge-counter">{{count}}</span>
        </button>
        <div v-if="bell" class="shadow notibox animated--grow-in col-md-4">
            <div v-for="(noti,index) in notifications" class="row line" @click="gotopage(noti.order_id,noti.noti_id)">
                <div class="col-md-3">
                    <img style="height:4rem;" class="rounded-circle m-2" src="/images/avatar.png" alt="avatar">
                </div>
                <div class="col-md-5">
                    {{noti.cus.name}}
                    TID: {{noti.tid}}
                </div>
                <div class="col-md-4">
                    Amount: {{noti.amount}}
                    Status: {{noti.stat}}
                </div>
            </div>
            <a class="dropdown-item text-center small text-gray-700" href="#">Read More Messages</a>
        </div>
    </li>
</div>
</template>

<script>
    export default {
        name: "Notifications",
        props:{
            user:{
                type:Object,
                default: null,
            },
            noti_count:{
              type:Number,
                default:null,
            },
        },
        mounted(){

            this.count=this.noti_count;
             this.getNotifications();
           if(this.user.type=="admin"){
               Echo.private(`delivery`).listen('DeliveryEvent',(e)=>{
                   this.getNotifications();
               });
           }else if(this.user.type=="vendor"){
               Echo.private(`delivery.${this.user.id}`).listen('DeliveryEvent',(e)=>{
                   this.getNotifications();
               });
           }else{

           }

        },
        data:()=>({
           count:0,
            notifications:[],
            bell:false,
        }),
        methods:{
            getNotifications(){
                axios.get('/notifications').then(
                    (res)=>{
                        console.log(res.data.notifications);
                        this.count=res.data.notifications.length;
                        this.notifications=res.data.notifications;
                    }
                ).catch(err=>console.log(err));
            },
            gotopage(order_id,noti_id){
                if(this.user.type=='admin'){
                    location.replace(`/order-notification/${order_id}/${noti_id}`);
                }else if(this.user.type=='vendor') {
                    location.replace(`/vendor-order-notification/${order_id}/${noti_id}`);

                }


            }
        }

    }
</script>

<style lang="scss" scoped>
.notibox{
    position: fixed;
    top:5rem;
    margin-left: -13rem;
    border-radius: 10px;
    max-height: 70vh;
z-index: 2000;
    overflow-y: scroll;
}
    .line:hover{
        background-image: linear-gradient(rgb(0, 176, 155), rgb(150, 201, 61)) !important;
        color: white;
        border-radius: 10px;
    }
</style>
