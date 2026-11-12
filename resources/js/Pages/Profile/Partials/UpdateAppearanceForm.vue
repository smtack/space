<script setup>
import { watch } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const page = usePage();

const form = useForm({
    appearance: page.props.auth.user.appearance ?? 'system',
});

const apply = () => {
    const prefersDark = window.matchMedia(
        '(prefers-color-scheme: dark)'
    ).matches;

    const dark = form.appearance === 'dark' || (form.appearance === 'system' && prefersDark);

    document.documentElement.classList.toggle('dark', dark);
};

watch(() => form.appearance, apply, {
    immediate: true,
});

const submit = () => {
    form.patch(route('profile.appearance'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Appearance
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Change the colour scheme to your preference.
            </p>
        </header>

        <form
            @submit.prevent="submit"
            class="mt-6 space-y-6"
        >
            <div>
                <InputLabel for="appearance" value="Appearance" />

                <select
                    name="appearance"
                    id="appearance"
                    v-model="form.appearance"
                    class="rounded-md p-2 w-full border border-gray-300 shadow-xs focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-red-600 dark:focus:ring-red-600"
                >
                    <option value="system">System Default</option>
                    <option value="light">Light</option>
                    <option value="dark">Dark</option>
                </select>

                <InputError
                    class="mt-2"
                    :message="form.errors.appearance"
                />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton
                    class="bg-red-500 hover:bg-red-600"
                    :disabled="form.processing"
                >
                    Save
                </PrimaryButton>

                <span
                    v-if="form.recentlySuccessful"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >
                    Saved.
                </span>
            </div>
        </form>
    </section>
</template>
