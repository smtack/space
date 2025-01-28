<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import User from '@/Components/User.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);

const form = useForm({
    q: '',
});

const topUsers = usePage().props.topUsers;
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <nav
                class="border-b border-gray-100 bg-white dark:border-gray-700 dark:bg-gray-800"
            >
                <!-- Primary Navigation Menu -->
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex shrink-0 items-center">
                                <Link :href="route('home')">
                                    <ApplicationLogo
                                        class="block h-8 w-auto text-[#FF2D30] lg:h-10 fill-current dark:text-gray-200"
                                    />
                                </Link>
                            </div>
                        </div>

                        <div class="hidden sm:ms-6 sm:flex sm:items-center">
                            <!-- Settings Dropdown -->
                            <div class="relative ms-3">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center rounded-md border border-transparent bg-white py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none dark:bg-gray-800 dark:text-gray-400 dark:hover:text-gray-300"
                                            >
                                                <img class="h-9 w-9 rounded-full" :src="`/storage/avatars/${ $page.props.auth.user.avatar }`" alt="Avatar">
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink
                                            :href="route('profile.index', $page.props.auth.user.username)"
                                        >
                                            Your Profile
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('profile.edit')"
                                        >
                                            Edit Profile
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none dark:text-gray-500 dark:hover:bg-gray-900 dark:hover:text-gray-400 dark:focus:bg-gray-900 dark:focus:text-gray-400"
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="space-y-1 pb-3 pt-2">
                        <ResponsiveNavLink
                            :href="route('home')"
                            :active="route().current('home')"
                        >
                            Home
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('posts.index')"
                            :active="route().current('posts.index')"
                        >
                            Posts
                        </ResponsiveNavLink>
                    </div>

                    <div class="py-2">
                        <div class="bg-white mx-auto p-2 rounded-lg">
                            <form @submit.prevent="form.get(route('search'))">
                                <input
                                    type="text"
                                    v-model="form.q"
                                    placeholder="Search..."
                                    class="block w-full h-10 text-sm border-gray-300 focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-md">
                            </form>
                        </div>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div
                        class="border-t border-gray-200 pb-1 pt-4 dark:border-gray-600"
                    >
                        <div class="px-4">
                            <div
                                class="text-base font-medium text-gray-800 dark:text-gray-200"
                            >
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="text-sm font-medium text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.index', $page.props.auth.user.username)">
                                Your Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('profile.edit')">
                                Edit Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header
                class="bg-white shadow dark:bg-gray-800"
                v-if="$slots.header"
            >
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <div class="grid grid-cols-2 sm:grid-cols-12 gap-3 mx-auto max-w-7xl sm:px-6 lg:px-8 justify-items-stretch">
                    <!-- Flash message -->
                    <div
                        class="col-span-12 mt-6 bg-red-500 rounded-md relative p-6"
                        v-if="$page.props.flash.message">
                        <p class="text-white">{{  $page.props.flash.message }}</p>
                    </div>

                    <!-- Left menu -->
                    <div class="hidden sm:block col-span-3 my-3 xs:hidden">
                        <div class="bg-white mx-auto p-4 rounded-lg">
                            <div>
                                <NavLink
                                    :href="route('home')"
                                    :active="route().current('home')"
                                >
                                    Home
                                </NavLink>
                                <NavLink
                                    :href="route('posts.index')"
                                    :active="route().current('posts.index')"
                                >
                                    Posts
                                </NavLink>
                            </div>
                        </div>
                        <div class="bg-white mx-auto mt-3 p-4 rounded-lg">
                            <div>
                                <p class="text-gray-800 text-sm">&copy; {{ $page.props.appName + ' ' + new Date().getFullYear() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Center column -->
                    <div class="col-span-12 sm:col-span-6 my-3">
                        <div class="bg-white mx-auto rounded-lg">
                            <slot />
                        </div>
                    </div>

                    <!-- Right column -->
                    <div class="hidden sm:block col-span-3 my-3">
                        <div class="bg-white mx-auto p-4 rounded-lg">
                            <form @submit.prevent="form.get(route('search'))">
                                <input
                                    type="text"
                                    v-model="form.q"
                                    placeholder="Search..."
                                    class="block w-full h-10 text-sm border-gray-300 focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-md">
                            </form>
                        </div>
                        <div class="bg-white mx-auto mt-3 rounded-lg">
                            <h1 class="font-bold p-4">Top Users</h1>
                            <div>
                                <User
                                    v-for="user in topUsers"
                                    :key="user.id"
                                    :user="user"
                                    class="w-full py-4 px-4"
                                />

                                <Link
                                    :href="route('users')"
                                    as="button"
                                    class="w-full p-4 text-red-500 hover:bg-slate-100">
                                    Show More
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>
