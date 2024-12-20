<script setup>
defineProps(['user']);
</script>

<template>
    <div class="p-6 flex space-x-2">
        <img
            class="h-12 w-12 text-gray-600 rounded-full"
            :src="`/storage/avatars/${user.avatar}`"
            alt="Avatar">
        <div class="flex-1">
            <div class="flex justify-between items-center">
                <div>
                    <span class="block text-gray-800">{{ user.name }}</span>
                    <span class="block text-sm text-gray-400">@{{ user.username }}</span>
                    <small class="block mt-4 text-sm text-gray-600">Joined on {{ new Date(user.created_at).toDateString() }}</small>
                </div>
            </div>
            <p class="mt-4 text-md text-gray-800">{{ user.bio }}</p>
        </div>
    </div>
</template>
