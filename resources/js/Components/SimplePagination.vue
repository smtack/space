<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    pagination: Object,
});
</script>
<template>
    <nav class="relative flex items-center justify-between">
        <Link
            :href="pagination.prev_page_url ?? ''"
            class="flex items-center justify-center px-3 py-2 text-sm text-gray-600"
            :class="{ '!text-gray-300': !pagination.prev_page_url }"
        >
            Previous
        </Link>
        <Link
            :href="pagination.next_page_url ?? ''"
            class="flex items-center justify-center px-3 py-2 text-sm text-gray-600"
            :class="{ '!text-gray-300': !pagination.next_page_url }"
        >
            Next
        </Link>
    </nav>
</template>
