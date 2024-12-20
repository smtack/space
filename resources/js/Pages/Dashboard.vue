<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Post from '@/Components/Post.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Head } from '@inertiajs/vue3';

defineProps(['posts']);

const form = useForm({
    message: '',
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
                <form @submit.prevent="form.post(route('posts.store'), { onSuccess: () => form.reset() })">
                    <textarea
                        v-model="form.message"
                        placeholder="What's on your mind?"
                        class="block w-full border-gray-300 focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    ></textarea>
                    <InputError :message="form.errors.message" class="mt-2" />
                    <PrimaryButton class="mt-4">Post</PrimaryButton>
                </form>

                <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                    <Post
                        v-for="post in posts"
                        :key="post.id"
                        :post="post"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
