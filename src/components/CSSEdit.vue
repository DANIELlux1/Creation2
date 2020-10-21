<template>
    <div class="css-edit">
        <select v-model="currentClass">
            <option v-for="style in styles" :value="style.class" :key="style.class">{{ style.class }}</option>
        </select>
        <div v-if="currentClass != ''" >
            <ul>
                <li 
                    v-for="(rule, i) in getStyles" 
                    :key="i">
                    <input 
                        type="text" 
                        v-model="getStyles[i]">
                </li>
            </ul>
            
            <button @click="addRule">Add Rule</button>
            <button @click="updateRule">Update Rules</button>

        </div>
    </div>
</template>

<script>

    export default{
        data: () => {
            return {
                styles: [],

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
                            if(sheet.rules[j].selectorText === this.currentClass){
                                console.log("Style has been updated.");
                                sheet.rules[j].style = this.printStyle(style);
                                break;
                            }
                        }
                    }
                    break;
                }
            },
            printStyle(style){

                var cssStyle = "";
                for(var j = 0;j < style.length; j++)
                {
                    cssStyle += style[j];
                }

                return cssStyle;
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
                'http://192.168.22.123/CreationTestEnv/creation2/src/includes/jsonFetcher.php'
            ).then(({data})=>{
                this.styles = data.styles;
                var cssClass="";
                var cssStyle = "{";
                this.styleSheet = document.createElement('style');
                document.head.appendChild(this.styleSheet);

                var sheet = this.styleSheet.sheet;

                for(var i = 0; i < this.styles.length; i++){
                    cssStyle = "{"
                    /*for(var j = 0;j < this.styles[i].style.length; j++)
                    {

                        cssStyle += this.styles[i].style[j];
                    }*/
                    cssStyle += this.printStyle(this.styles[i].style);
                    cssStyle += "}";
                    cssClass = this.styles[i].class;
                    sheet.insertRule(cssClass + cssStyle, sheet.cssRules.length);
                }
                
            }).catch((error) => {
                console.log(error);
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

    .css-edit input {
        margin: 16px 0;
    }

    .css-edit ul{
        padding-left: 20%;
        list-style: none;
    }

    .css-edit button{
        margin-left: 35%;
    }

</style>