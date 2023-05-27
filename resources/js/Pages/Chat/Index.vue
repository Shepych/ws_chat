<template>
    <div class="flex">
        <div class="w-1/2 p-4 bg-white border border-gray-300 flex flex-col">
            <Link :href="route('chats.show', chat.id)" v-for="chat in chats">
                {{ chat.id }}
                {{ chat.title }}
                {{ chat.users }}
            </Link>
        </div>

        <div class="w-1/2 bg-white border border-gray-300 ml-4 p-4">
            <h3 class="text-gray-700 mb-4">Users</h3>
            <div v-if="users">
                <div v-for="user in users" class="flex pb-4 mb-4 border-b border-green-800">
                    <p class="mr-2">{{ user.id }}</p>
                    <p class="mr-4">{{ user.name }}</p>
                    <a @click.prevent="store(user.id)" href="#" class="inline-block text-white text-xs bg-sky-400 py-2 px-3 rounded-lg">Message</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {Link} from "@inertiajs/vue3";
import Main from "@/Layouts/Main.vue";

export default {
    name: "Index",

    props: [
        'users',
        'chats'
    ],

    layout: Main,

    methods: {
        store(id) {
            this.$inertia.post('/chats', {title: null, users: [id]});
        }
    },

    components: {
        Link
    }
}
</script>

<style scoped>

</style>
