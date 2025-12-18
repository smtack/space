<script setup>
import { Link, router } from '@inertiajs/vue3';

const props = defineProps(['user']);

const redirect = () => {
    router.get(route('profile.index', props.user.username));
}
</script>

<template>
    <div @click="redirect" class="p-6 flex space-x-2 border-t border-gray-200 hover:bg-gray-100 hover:cursor-pointer">
        <Link v-on:click.stop :href="route('profile.index', user.username)">
            <img
                class="h-12 w-12 rounded-full"
                :src="`/storage/avatars/${user.avatar}`"
                alt="Avatar">
        </Link>
        <div class="flex-1">
            <div class="flex justify-between items-center">
                <div>
                    <Link v-on:click.stop :href="route('profile.index', user.username)">
                        <span class="text-gray-800 hover:underline">{{ user.name }}</span>
                        <span class="text-sm ml-2 text-gray-600 hover:underline">@{{ user.username }}</span>
                    </Link>
                </div>
            </div>
            <p class="mt-4 text-md text-gray-900">{{ user.bio }}</p>
        </div>
    </div>
</template>
