<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Welcome" />

    <div class="bg-gray-50">
        <div class="relative flex min-h-screen flex-col items-center justify-center selection:bg-[#FF2D30] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <main class="mt-6 px-4 sm:px-6 lg:px-8">
                    <div class="grid gap-8 lg:grid-cols-2 lg:gap-12 max-w-7xl mx-auto">
                        <div class="flex justify-center items-center">
                            <ApplicationLogo class="h-48 w-auto sm:h-64 lg:h-80 xl:h-96 transition-all duration-300" />
                        </div>
                        <div class="flex flex-col justify-center gap-6 sm:gap-8">
                            <Link
                                :href="route('register')"
                                class="block rounded-lg bg-[#FF2D30] p-4 ring-2 ring-[#FF2D30] hover:opacity-75 transition duration-300"
                            >
                                <div class="p-2">
                                    <h2
                                        class="text-xl text-center font-semibold text-white"
                                    >
                                        Sign Up
                                    </h2>
                                </div>
                            </Link>
                            <Link
                                :href="route('login')"
                                class="block rounded-lg bg-white p-4 ring-2 ring-black/80 transition duration-300"
                            >
                                <div class="pt-2">
                                    <h2 class="text-xl text-center font-semibold text-black">
                                        Log In
                                    </h2>
                                </div>
                            </Link>
                        </div>
                    </div>
                </main>

                <footer class="py-16 text-center text-sm text-black">
                    &copy; {{ $page.props.appName }} {{ new Date().getFullYear() }}
                </footer>
            </div>
        </div>
    </div>
</template>
