
export const cssMixin = {
    data() {
        return {
            styles: []
        }
    },
    methods: {
        fetchClasses(){
            var temp = []
            for(var i = 0; i < this.styles.length; i++)
            {
                temp.push(this.styles[i].class);
            }
            return temp;
        },
        fetchStyle(target) {
            var i = 0;
            console.log("Target I'm looking for:" + target);
            console.log("Style length is about:" + this.styles.length);
            console.log("Content: " + this.styles)
            while(i < this.styles.length){
                var looking = this.styles[i].class;
                console.log("Comparing " + looking + " to " + target);
                if(looking == target){
                    return this.styles[i].style;
                }
                i++;
            }

            return false;
        },
        changeStyle(target, newStyle) {
            
            var style = this.fetchStyle(target);

            if(style !== false){
                style.style = newStyle;
            }else{
                this.newStyle(target, newStyle);
            }
        },
        newStyle(target, newStyle) {
            styles.push({class: target, style: newStyle});
        },
        fetchCSS(){
            this.$http.get(
                'src/includes/jsonFetcher.php'
            ).then(({data})=>{
                console.log("CSS has been loaded into the Mixin");
                this.styles = data.styles;
            }).catch((error) => {
                console.log(error);
            });
        }
    },
    mounted(){
        console.log("Mixin has been created!")
    }
}