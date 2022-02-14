<template>
    <div class="feed"  v-chat-scroll="{always: false, smooth: true, scrollonremoved:true}">
        <ul v-if="contact">
            <li v-for="(message,index) in messages" :key="index"><div :class="`message${message.to ==contact.id?' received':' sent'}`"><div class="text" >{{message.body}}</div></div></li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        messages:{
            type:Array,
            default:[],
        },
        contact:{
            type:Object,
            default:null
        },

    },
    data:()=>(
        {

        }
    ),
}
</script>

<style lang="scss" scoped>
.feed{
    height:70vh;
    background-color: rgb(255, 255, 255);
    overflow-y: scroll;
    ul{
        list-style-type:none;
        padding: 5px;
        li{
            margin: 10px;
            .message{
                margin:10px,0px;
                width:100%;
                .text{
                    max-width:400px;
                    border-radius: 10px;
                    padding:1rem;
                    display:inline-block;
                }
                    &.received {
                        text-align:right;
                        .text{
                            background:rgb(252, 252, 252) ;
                            box-shadow: 0 4px 8px 0 rgba(87, 86, 86, 0.288);
                        }
                    }
                     &.sent {
                        text-align:left;
                        .text{
                            color:white;
                            background: rgb(54, 136, 243);
                        }
                    }
                }
        }
    }

}
</style>
