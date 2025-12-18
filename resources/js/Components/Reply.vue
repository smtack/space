<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Link, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import updateLocale from 'dayjs/plugin/updateLocale';

dayjs.extend(relativeTime);
dayjs.extend(updateLocale);

dayjs.updateLocale('en', {
  relativeTime: {
    future: "in %s",
    past: "%s ago",
    s: 'a few seconds',
    m: "1 minute",
    mm: "%d minutes",
    h: "1 hour",
    hh: "%d hours",
    d: "1 day",
    dd: "%d days",
    M: "1 month",
    MM: "%d months",
    y: "1 year",
    yy: "%d years"
  }
})

const props = defineProps(['post']);

const form = useForm({
    message: props.post.message,
});

const editing = ref(false);

const cancel = () => {
    editing.value = false;
    form.reset();
    form.clearErrors()
}

const save = () => {
    form.put(route('replies.update', props.post.id), {
        preserveState: false,
        reset: ['replies'],
        onSuccess: () => {
            editing.value = false;
            form.reset();
        }
    });
}

const destroy = (id) => {
    router.delete(route('replies.destroy', id), {
        preserveScroll: true,
        reset: ['replies'],
    });
};
</script>

<template>
    <div class="p-6 flex space-x-2">
        <Link :href="route('profile.index', post.user.username)">
            <img
                class="h-12 w-12 rounded-full"
                :src="`/storage/avatars/${post.user.avatar}`"
                alt="Avatar">
        </Link>
        <div class="flex-1">
            <div class="flex justify-between items-center">
                <div>
                    <Link :href="route('profile.index', post.user.username)">
                        <span class="text-gray-800">{{ post.user.name }}</span>
                        <span class="text-sm ml-2 text-gray-600">@{{ post.user.username }}</span>
                    </Link>
                    <small class="ml-2 text-sm text-gray-400">&middot; {{ dayjs(post.created_at).fromNow(true) }}</small>
                    <small v-if="post.created_at !== post.updated_at" class="text-sm text-gray-600"> &middot; edited</small>
                </div>
                <Dropdown v-if="post.user_id === $page.props.auth.user.id">
                    <template #trigger>
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </button>
                    </template>
                    <template #content>
                        <button class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out" @click="editing = true">
                            Edit
                        </button>
                        <DropdownLink as="button" @click="destroy(post.id)">
                            Delete
                        </DropdownLink>
                    </template>
                </Dropdown>
            </div>
            <form v-if="editing" @submit.prevent="save">
                <textarea
                    v-model="form.message"
                    class="mt-4 w-full p-2 text-gray-900 border border-gray-300 focus:border-red-300 focus:outline-none focus:ring focus:ring-red-200/50 rounded-md shadow-xs"
                ></textarea>
                <InputError :message="form.errors.message" class="mt-2" />
                <div class="space-x-2">
                    <PrimaryButton class="mt-4">Save</PrimaryButton>
                    <button class="mt-4" @click="cancel">Cancel</button>
                </div>
            </form>
            <p v-else class="mt-4 text-md text-gray-900">{{ post.message }}</p>
        </div>
    </div>
</template>
