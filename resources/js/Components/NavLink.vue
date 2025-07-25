<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'flex items-center mb-4 p-4 rounded-lg text-lg leading-5 text-gray-900 bg-red-50 hover:bg-gray-100 hover:text-gray-700 focus:outline-hidden focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out'
        : 'flex items-center mb-4 p-4 rounded-lg text-lg leading-5 text-gray-900 hover:bg-gray-100 hover:text-gray-700 focus:outline-hidden focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out',
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
