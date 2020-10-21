<template>
    <div class="panel">
        <a href="#" 
            style=" float:right;
                    padding-right: 60px;
                    padding-top: 16px;
                    font-size: 24px;">
        &#9874;</a>
        <app-content 
            v-for="content in panel.contents" 
            :content="content"    
            :key="content.contentId"
        />
    </div>
</template>

<script>

    import Content from "./Content.vue";

    export default{
        props: ['panel'],
        components: {
            appContent: Content
        },
        methods: {
            
        }
    }

</script>