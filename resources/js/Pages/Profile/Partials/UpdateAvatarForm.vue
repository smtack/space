<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    avatar: "",
});

const submit = () => {
    form.post(route('profile.avatar'), {
        forceFormData: true,
        preserveScroll: true,
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Avatar
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update your avatar...
            </p>
        </header>

        <form
            @submit.prevent="submit"
            class="mt-6 space-y-6"
        >
            <div>
                <InputLabel for="avatar" value="Avatar" />

                <input type="file" name="avatar" @input="form.avatar = $event.target.files[0]" />

                <InputError class="mt-2" :message="form.errors.avatar" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Upload</PrimaryButton>

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
