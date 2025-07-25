<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, usePage } from '@inertiajs/vue3';

const user = usePage().props.auth.user;

const form = useForm({
    bio: user.bio,
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Bio
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Tell people about yourself...
            </p>
        </header>

        <form
            @submit.prevent="form.patch(route('profile.bio'))"
            class="mt-6 space-y-6"
        >
            <div>
                <InputLabel for="bio" value="Bio" />

                <textarea
                    id="bio"
                    class="w-full h-36 p-2 resize-none rounded-md border-1 border-gray-300 shadow-xs focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-red-600 dark:focus:ring-red-600"
                    v-model="form.bio"
                    required
                    autofocus
                    autocomplete="bio"
                ></textarea>

                <InputError class="mt-2" :message="form.errors.bio" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600 dark:text-gray-400"
                    >
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
