<template>
    <div class="page">
        <app-frame 
            v-for="frame in page.frames" 
            :frame="frame" 
            :key="frame.position"/>
        <div>
            <select v-model="selected">
                <option disabled value="">Select Frame to ADD</option>
                <option 
                        v-for="choice in options" 
                        :value="choice.frame_id"
                        :key="choice.frame_id">
                    {{ choice.frame_name }}
                </option>
            </select>
            <button @click=addFrame()>Add Frame</button>
        </div>
    </div>
</template>

<script>
    import Frame from "./Frame.vue";
    import EventBus from '../includes/eventBus.js';

    export default{
        data: () => {
            return {
                selected: "",
                options: []
            }
        },
        props: ['page'],
        components: {
            appFrame: Frame
        },
        methods: {
            logPages(){
                console.log(this.page.frames);
            },
            removeFrame(i){
            this.page.frames.splice(i,1);
            for(var j=i; j < this.page.frames.length; j++){
                this.page.frames[j].position -= 1; 
            }
            },
            moveFrameUp(i){
                if(i - 1 >= 0)
                {
                    this.switchFrame(i, i-1);
                }
            },
            moveFrameDown(i){
                if(i + 1 < this.page.frames.length)
                {   
                    this.switchFrame(i, i+1); 
                }
            },
            switchFrame(from, to){

                this.page.frames[from].position = to;
                this.page.frames[to].position = from;

                var temp = this.page.frames.splice(from, 1);
                this.page.frames.splice(to, 0, temp[0]);



            },
            sortFrames(){
                var temp = [];
                for(var i=0; i < this.page.frames.length; i++){
                    
                    for(var j=0; j < this.page.frames.length; j++){
                        if(parseInt(this.page.frames[j].position, 10) == i){
                            temp.push(this.page.frames[j]);
                            break;        
                        }
                    }

                }

                this.page.frames = temp;
                this.force();
            },
            force(){
                this.$forceUpdate(); 
            },
            addFrame(){
                this.$http.get("http://192.168.22.123/CreationTestEnv/creation2/src/includes/get2.php?id=" + this.selected).then(({data}) =>{
                    this.page.frames.push(data);
                    this.page.frames[this.page.frames.length - 1].position = this.page.frames.length - 1;
                })
            }
        },
        created(){
            this.sortFrames();
        },
        mounted () {
            EventBus.$on('UPDATE_FRAMES', (payload) => {
            
                var i = payload.index;
                switch(payload.input){
                    case "del":
                        this.removeFrame(i);
                        break;
                    case "up":
                        this.moveFrameUp(i);
                        break;
                    case "down":
                        this.moveFrameDown(i);
                        break;
                }

                this.force();
            });

            this.$http.get(
                'http://192.168.22.123/CreationTestEnv/creation2/src/includes/get.php'
            ).then(({data}) => {
                this.options = data;

                console.log(this.options[0].frame_id);
            })
        }

    }

</script>