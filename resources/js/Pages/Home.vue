<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Post from '@/Components/Post.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SimplePagination from '@/Components/SimplePagination.vue';
import { useForm, Head } from '@inertiajs/vue3';

const props = defineProps({
    posts: Object,
});

const form = useForm({
    message: '',
    image: null,
});
</script>

<template>
    <Head title="Home" />

    <AuthenticatedLayout>
        <div class="p-6">
            <form
                @submit.prevent="form.post(route('posts.store'), { onSuccess: () => form.reset() })"
                class="w-full"
            >
                <div>
                    <textarea
                        v-model="form.message"
                        placeholder="What's on your mind?"
                        class="w-full h-32 p-2 resize-none border-1 border-gray-300 focus:border-red-300 focus:outline-none focus:ring-3 focus:ring-red-200/50 rounded-md shadow-xs"
                    ></textarea>

                    <InputError :message="form.errors.message" class="mt-2" />
                </div>

                <div class="flex justify-between items-center mt-4">
                    <label for="image" class="cursor-pointer">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>

                        <input name="image" id="image" type="file" class="hidden" @input="form.image = $event.target.files[0]" />

                        <InputError :message="form.errors.image" class="mt-2" />
                    </label>

                    <PrimaryButton class="px-4 py-2">Post</PrimaryButton>
                </div>
            </form>
        </div>

        <div class="mt-6 divide-y">
            <Post
                v-for="post in posts.data"
                :key="post.id"
                :post="post"
            />

            <SimplePagination :pagination="posts" />
        </div>
    </AuthenticatedLayout>
</template>
