<template>
    <div class="web_page">
        <app-page 
            v-for="page in pages" 
            :page="page" 
            :key="page.pageId"/>
        <app-css-edit></app-css-edit>
    </div>
</template>

<script>
    import Page from "./Page.vue";
    import CSSEdit from "./CSSEdit.vue";

    export default {
        data: function() {
            return {
                webPageId: "",
                webPageName: "",
                pages: []
            };
        },
        components: {
            appPage: Page,
            appCssEdit: CSSEdit
        },
        methods: {
            initStyle(){
                console.log(this.styles);
            },
            logPages(){
                console.log(this.currentClass);
            }
        },mounted(){
            this.$http.get(
                'http://192.168.22.123/CreationTestEnv/creation2/src/includes/handler.php?page=1'
            ).then(({data})=>{
                console.log(data.pages[0].frames);
                this.webPageId = data.webPageId;
                this.webPageName = data.webPageName;
                this.pages = data.pages;
            }).catch((error) => {
                console.log(error);
            });
        }
    }

</script>