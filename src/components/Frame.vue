<template>
    <div :class="'frame'">
        <div class="icon-bar">
            <a href="#" @click.prevent="sendData('del')"  >&#128465; <i class="nav"></i></a>
            <a href="#" @click.prevent="sendData('down')" >&#9759;<i class="nav"></i></a>
            <a href="#" @click.prevent="sendData('up')"   >&#9757;<i class="nav"></i></a>
            <div style="float: left; padding-top: 16px;">
                <input 
                        type="checkbox" 
                        v-model="frame.frameShow">
                <label>Show Panel</label>
            </div>
            <div style="float: right; padding-top: 16px;">
                <a href="#" @click.prevent="sendData('del')"
                        style="
                                padding: 0;
                                margin: 0;
                                float: right;
                                text-align: center;
                                width: 36px;
                                transition: all 0.3s ease; " 
                    >&#9776; <i class="nav"></i></a>
                <input 
                    style="margin-right: 16px;" 
                    type="text"
                    v-model.lazy="frame.frameClass">
            </div>
          </div>
          <div v-if="frame.frameShow">
            <app-panel 
                v-for="(panel,i) in frame.panels"
                :key="i"
                :panel="panel"/>
          </div>
    </div>
</template>

<script>
    import Panel from "./Panel.vue";
    import EventBus from '../includes/eventBus.js';

    export default{
        props: ['frame',"index"],
        components: {
            appPanel: Panel
        },
        computed: {
            
        },
        methods: {
            sendData(input){
                const payload = {input, index: this.index};
                
                switch(input){
                    case "up":
                        EventBus.$emit('UPDATE_FRAMES', payload);
                        break;
                    case "down":
                        EventBus.$emit('UPDATE_FRAMES', payload);
                        break;
                    case "del":
                        EventBus.$emit('UPDATE_FRAMES', payload);
                        break;   
                }
            },
            seePosition(){
                console.log(this.frame.position);
            },
            force(){
                this.$forceUpdate(); 
            }
        },
        updated(){
            this.frame.position = this.index;
        }
    }
</script>

<style>
    .icon-bar{
        width: 100%;
        background-color: #fafafa;
        overflow: auto;
    }
    
    .icon-bar a{
        float: left;
        text-align: center;
        width: 36px;
        padding: 12px 0;
        transition: all 0.3s ease;
        color: #aaaaaa;
        font-size: 24px; 
    }

    .frame-class-edit{
        height: 100%;
        float: right;
        
    }

</style>