<template>
  <div class="">
     <div class="d-flex">
        <div class="col-md-8">
            <h1>{{contact? contact.name:"Select A Contact"}} <small>{{status}}</small></h1>
            <message-feed :contact="contact" :messages="messages" ></message-feed>
             <message-composer @send="sendMessage"></message-composer>
        </div>
        <div class=" col-md-4">
<!--            <span class="badge badge-primary rounded-pill"></span>-->
            <div> <h2 class="text-center">Contacts</h2></div>
            <div class="contacts">
                <ul>
                    <li  v-for="(contact,index) in contacts" :key="index" @click="selectedContact(index,contact)" >
                            <div class="card" :class="{'selected': index==selected}" @click="markasread(contact)">
                                <h6>{{ contact.name }}</h6>
                                <p>{{contact.email}}</p>
                            </div>
                    </li>
                </ul>
            </div>
        </div>

     </div>
  </div>
</template>

<script>
import MessageComposer from './MessageComposer.vue'
import MessageFeed from './MessageFeed.vue'
export default {
  components: { MessageComposer, MessageFeed },
  props:{
       user:{
            type:Object,
            default:null
        },
  },
  data:()=>({
    selected:0,
    contacts:[],
    messages:[],
    contact:{},
    status:"",

  }),
  mounted(){
      this.fetchContacts();
      Echo.private(`messages.${this.user.id}`).listen('ChatEvent',(e)=>{
          this.handleNewMessage(e.message);
      })

  },
 methods:{
    fetchContacts(){
          axios.get(
              '/fetch-contacts'
          ).then((res)=>{

             this.contacts=res.data;
             this.selectedContact(0,this.contacts[0]);
          }).catch((err)=>{console.log(err)});
      },
    selectedContact(index,contact){
          this.selected=index;
          this.contact=contact;


          axios.get(`/messages/${contact.id}`).then((res)=>{

              this.messages=res.data;

          }).catch((err)=>{concole.log(err)})
      },
     markasread(contact){

        axios.post(`/unread-message/markasseen`,{
            contact:contact
        }).then((res)=>{

        }).catch((err)=>console.log(err));
     },
       sendMessage(e){
          this.messages.push({
              'body':e,
                'to':this.contact.id

          });
           this.status="sending............"
          axios.post('/message/send',{
              body:e,
              to:this.contact.id,
          }).then((res)=>{
              this.status="sent.......";
              setTimeout(()=>{this.status=""},200);
          }).catch((err)=>{
              console.log(err);
          })
      },
      handleNewMessage(message){
      if(this.contact && message.from ==  this.contact.id){
          this.messages.push(message);
      }
  },


 },


}
</script>

<style lang="scss" scoped>
li{
    list-style:none;


}
ul{
    list-style:none;
    margin:0px;
    padding-left:0px;
}
.contacts{
    margin:0px;
    padding:0px;
    height:80vh;
    overflow-y:scroll;
}
.card{
     box-shadow: 0 4px 8px 0 rgba(87, 86, 86, 0.288);
     padding:1rem;


}
.selected{
    background-color: rgb(177, 190, 186);

}
</style>
