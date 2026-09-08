<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Reply from '@/Components/Reply.vue';
import { Head, InfiniteScroll, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import SinglePost from '@/Components/SinglePost.vue';

const props = defineProps({
    post: Object,
    replies: Object,
});

const maxLength = 250;

const replyform = useForm({
    message: '',
    post_id: props.post.id
});

const reply = () => {
    replyform.post(route('replies.store'), {
        preserveScroll: true,
        reset: ['replies'],
        onSuccess: () => {
            replyform.reset();
        },
    });
}
</script>

<template>
    <Head title="Post" />

    <AuthenticatedLayout>
        <SinglePost :post="post" />

        <div class="p-6">
            <form @submit.prevent="reply">
                <textarea
                    v-model="replyform.message"
                    :maxlength="maxLength"
                    placeholder="Post a reply..."
                    class="block w-full h-32  p-2 resize-none border border-gray-300 focus:border-red-300 focus:outline-none focus:ring focus:ring-red-200/50 rounded-md shadow-xs"
                ></textarea>

                <div class="flex justify-end text-sm text-gray-400">
                    <span :class="{ 'text-red-600' : replyform.message.length >= maxLength }">{{ replyform.message.length }} / {{ maxLength }}</span>
                </div>
                
                <InputError :message="replyform.errors.message" class="mt-2" />
                <PrimaryButton class="mt-4">Reply</PrimaryButton>
            </form>
        </div>

        <div class="mt-6 divide-y">
            <InfiniteScroll data="replies">
                <Reply
                    v-for="reply in replies.data"
                    :key="reply.id"
                    :post="reply"
                />
            </InfiniteScroll>
        </div>
    </AuthenticatedLayout>
</template>