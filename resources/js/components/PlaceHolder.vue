<template>
    <div class="title m-b-md">
        {{ placeholder }}
    </div>
</template>

<script>
import { Placeholder } from '@babel/generator/lib/generators/base';

export default {
    name: "PlaceHolder",
    props: {
        placeholder: String,
    }
}
</script>

<style>

</style>