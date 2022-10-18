<template>
    <div class="content">
       <PlaceHolder :placeholder="placeholder"/>
    </div>
</template>

<script>
    import PlaceHolder from './PlaceHolder';
    export default {
        name: "App",
    data() {
        return {
            placeholder: "Work in progress",
        };
    },
        components: {
            PlaceHolder,
        },
    };
</script>