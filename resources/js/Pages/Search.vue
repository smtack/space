<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Post from '@/Components/Post.vue';
import User from '@/Components/User.vue';
import SimplePagination from '@/Components/SimplePagination.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    users: Object,
    posts: Object,
});

const toggleUsers = ref(false);
</script>

<template>
    <Head title="Search" />

    <AuthenticatedLayout>
        <nav>
            <button
                @click="toggleUsers = false"
                class="py-4 w-[50%] border-b-4 hover:bg-slate-50 hover:border-b-red-500"
                :class="{
                    'border-b-red-500': !toggleUsers
                }">
                Posts
            </button>
            <button
                @click="toggleUsers = true"
                class="py-4 w-[50%] border-b-4 hover:bg-slate-50 hover:border-b-red-500"
                :class="{
                    'border-b-red-500': toggleUsers
                }">
                Users
            </button>
        </nav>
        <div
            class="divide-y"
            :class="{
                block: !toggleUsers,
                hidden: toggleUsers
            }">
            <Post
                v-for="post in posts.data"
                :key="post.id"
                :post="post"
            />

            <SimplePagination :pagination="posts" />
        </div>
        <div
            class="divide-y"
            :class="{
                block: toggleUsers,
                hidden: !toggleUsers
            }">
            <User
                v-for="user in users.data"
                :key="user.id"
                :user="user"
            />

            <SimplePagination :pagination="users" />
        </div>
    </AuthenticatedLayout>
</template>
