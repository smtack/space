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
        ? 'flex items-center my-4 mx-2 p-4 rounded-lg text-lg leading-5 text-gray-900 dark:text-gray-300 bg-red-50 dark:bg-red-500 dark:text-white hover:bg-gray-100 hover:text-gray-700 focus:outline-hidden focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out dark:hover:bg-gray-700 dark:hover:text-white dark:focus:bg-gray-700 dark:focus:text-white'
        : 'flex items-center my-4 mx-2 p-4 rounded-lg text-lg leading-5 text-gray-900 dark:text-gray-300 hover:bg-gray-100 hover:text-gray-700 focus:outline-hidden focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out dark:hover:bg-gray-700 dark:hover:text-white dark:focus:bg-gray-700 dark:focus:text-white',
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
