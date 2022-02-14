<template>
    <div class="">
        <textarea @keypress.enter="sendMessage" id="messagecomposer" class="form-control" placeholder="Type Message here....." v-model="message" rows="2"></textarea>
    </div>
</template>

<script>
export default {
    data:()=>({
        message:""
    }),
    methods:{
        sendMessage(e){
            e.preventDefault();
            if (this.message == "")
            {
                return;
            }
            this.$emit('send',this.message);
            this.message="";
        }
    },
}
</script>

<style lang="scss" scoped>
.messagecomposer{
    margin-top:1rem!important;
}

</style>
