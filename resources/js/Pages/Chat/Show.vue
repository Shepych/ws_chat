<template>
    <div class="flex">
        <div class="w-1/2 p-4 bg-white border border-gray-300 flex flex-col">
            {{ chat.id }}
            {{ chat.title }}
            {{ chat.users }}
        </div>

        <div class="w-1/2 bg-white border border-gray-300 ml-4 p-4">

        </div>
    </div>
</template>

<script>
import Main from "@/Layouts/Main.vue";

export default {
    name: "Index",

    props: [
        'chat'
    ],

    layout: Main,
}
</script>

<style scoped>

</style>
