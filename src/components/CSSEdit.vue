<template>
    <div class="css-edit">
        <select v-model="currentClass">
            <option disabled value="">Select a Class to edit</option>
            <option 
                    v-for="style in styles" 
                    :value="style.class" 
                    :key="style.class">
            {{ style.class }}</option>
        </select>
        <button @click="addClassRequest = true">Add Class</button>
        <button @click="removeClass()">Remove selected Class</button>
        <div v-if="currentClass != '' && !addClassRequest" >
            <ul>
                <li 
                        v-for="(rule, i) in getStyles" 
                        :key="i">
                    <div>
                        <input 
                                type="text" 
                                v-model.lazy="getStyles[i]">
                        <button @click.prevent="deleteRule(i)">X</button>
                    </div>
                </li>
            </ul>
            <button @click="addRule">Add Rule</button>
            <button @click="updateRule">Update Rules</button>
        </div>
        <div v-if="addClassRequest">
            <input  
                    v-model.lazy="toAdd" 
                    type="text" >
            <button @click="addClass()">Add</button>
        </div>
    </div>
</template>

<script>

    import EventBus from '../includes/eventBus.js';

    export default{
        data: () => {
            return {
                styles: [],

                addClassRequest: false,
                toAdd: "",
                currentClass: "",
                styleSheet: ""
            }
        },
        methods: {
            addRule(){
                for(var i = 0; i < this.styles.length; i++){
                    if(this.styles[i].class == this.currentClass)
                    {
                        this.styles[i].style.push("");
                        break;
                    }
                }
            },
            updateRule(){
                var sheet = this.styleSheet.sheet;
                for(var i = 0; i < this.styles.length; i++){
                    if(this.styles[i].class == this.currentClass){
                        var style = this.styles[i].style;
                        for(var j = 0; j < sheet.cssRules.length; j++){
                            if(sheet.cssRules[j].selectorText == this.currentClass){
                                sheet.cssRules[j].style = this.printStyle(style);
                                break;
                            }
                        }
                        break;
                    }
                }
            },
            printStyle(style){

                var cssStyle = "";
                for(var j = 0;j < style.length; j++)
                {
                    cssStyle += style[j];
                }

                return cssStyle;
            },
            deleteRule(index){
                for(var i = 0; i < this.styles.length; i++){
                    if(this.styles[i].class == this.currentClass){
                        this.styles[i].style.splice(index,1);
                    }
                }
            },
            addClass(){
                this.styles.push({ class: this.toAdd, style: [""]});
                this.addClassRequest = false;
                this.currentClass = this.toAdd;
            },
            removeClass(){
                for(var i = 0; i < this.styles.length; i++){
                    if(this.styles[i].class == this.currentClass){
                        this.styles.splice(i,1);
                        break;
                    }
                }
                this.currentClass = "";
            }
        },
        computed: {
            getStyles(){
                
                for(var i = 0; i < this.styles.length; i++){
                    if(this.styles[i].class == this.currentClass)
                    {
                        return this.styles[i].style;
                    }
                }

                return "";
            }
        },
        mounted(){
            this.$http.get(
                'http://192.168.22.123/CreationTestEnv/creation2/src/includes/handler.php?style=1'
            ).then(({data})=>{
                this.styles = data.styles;
                var cssClass="";
                var cssStyle = "{";
                this.styleSheet = document.createElement('style');
                document.head.appendChild(this.styleSheet);

                var sheet = this.styleSheet.sheet;

                for(var i = 0; i < this.styles.length; i++){
                    cssStyle = "{"
                    cssStyle += this.printStyle(this.styles[i].style);
                    cssStyle += "}";
                    cssClass = this.styles[i].class;
                    sheet.insertRule(cssClass + cssStyle, sheet.cssRules.length);
                }
                
            }).catch((error) => {
                console.log(error);
            });

            EventBus.$on('GET_CLASS', (payload) => {
                
                var found = false;

                for(var i = 0; i < this.styles.length; i++){

                    if(this.styles[i].class == payload){
                        found = true;
                        break;
                    }
                    
                }

                if(!found){
                    this.toAdd = payload;
                    this.addClass();
                }

                this.currentClass = payload;

            });
        }
    }

</script>

<style>

    .css-edit{
        width: 20%;
        margin:  20px auto;
        padding: 20px 0;
        border: black 1px solid;
    }

    .css-edit ul{
        padding-left: 20%;
        list-style: none;
    }

    .css-edit li{
        margin: 16px 0;
    }


</style>