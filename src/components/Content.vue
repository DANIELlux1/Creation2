<template>
    <div class="content">
        <span   @dblclick="content.contentSelected = true;"
                v-html="generateContent" 
                v-if="!content.contentSelected"></span>
        <div v-if="content.contentSelected">
            <input 
                    v-if="content.contentType != 'text'" 
                    type="text" 
                    v-model="content.contentValue">
            <textarea
                    cols="59"
                    rows="12"
                    v-if="content.contentType == 'text'" 
                    v-model="content.contentValue"></textarea>
            <button @click="content.contentSelected = false;">Update</button>
        </div>
    </div>
</template>

<script>


    export default{
        props: ['content'],
        computed: {
            generateContent(){
                switch(this.content.contentType)
                {
                    case "text":
                        return this.generateText();
                    case "title":
                        return this.generateTitle();
                    case "image":
                        return this.generateImage();
                }

                return null;
            }
        },
        methods: {
            generateText(){
                return "<p>" + this.content.contentValue + "</p>";
            },
            generateTitle(){
                return "<h1>" + this.content.contentValue + "</h1>";
            },
            generateImage(){
                return "<img src='" + this.content.contentValue + "'>";
            },
            force(){
                this.$forceUpdate(); 
            }
        }

    }

</script>