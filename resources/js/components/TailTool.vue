<template>
    <div>
        <Head :title="__('Application log')" />
        <Heading class="mb-6">{{ __('Application log') }}</Heading>

        <p class="mb-4 text-sm text-gray-500 dark:text-gray-400" role="status">
            {{ error ? __('Connection lost. Retrying…') : __('Listening for new log entries…') }}
        </p>

        <Terminal :text="lines" />
    </div>
</template>

<script setup>
import { onMounted, onBeforeUnmount, ref } from 'vue';
import Terminal from './Terminal.vue';
import LogReader from '../LogReader';

const lines = ref('');
const error = ref(false);
let logReader;

onMounted(() => {
    logReader = new LogReader({
        callback: (text) => {
            error.value = false;
            lines.value = (lines.value + text).slice(-500000);
        },
        onError: () => {
            error.value = true;
        },
    });
});

onBeforeUnmount(() => logReader?.destroy());
</script>
