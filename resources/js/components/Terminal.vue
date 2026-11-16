<template>
    <div class="tail-terminal relative overflow-hidden rounded-lg">
        <div
            ref="viewport"
            class="overflow-auto"
            style="height: max(18rem, calc(100dvh - 19rem))"
            tabindex="0"
            :aria-label="__('Application log entries')"
            @scroll="updateScrollPosition"
        >
            <pre
                class="p-4 text-sm leading-relaxed"
            ><code>{{ text || __('Waiting for new log entries. Existing entries are not shown.') }}</code></pre>
        </div>
        <div v-if="!atBottom" class="tail-scroll-actions">
            <button
                type="button"
                class="tail-scroll-button font-semibold px-4 py-3 rounded-lg"
                @click="scrollToBottom"
            >
                {{ __('Scroll to bottom') }}
            </button>
        </div>
    </div>
</template>

<script setup>
import { nextTick, ref, watch } from 'vue';

const props = defineProps({ text: { type: String, required: true } });
const viewport = ref(null);
const atBottom = ref(true);

function updateScrollPosition() {
    const element = viewport.value;
    atBottom.value = element.scrollHeight - element.scrollTop - element.clientHeight < 4;
}

function scrollToBottom() {
    viewport.value.scrollTop = viewport.value.scrollHeight;
    atBottom.value = true;
}

watch(
    () => props.text,
    async () => {
        const shouldScroll = atBottom.value;
        await nextTick();
        if (shouldScroll) scrollToBottom();
    }
);
</script>

<style scoped>
.tail-terminal {
    background: rgb(var(--colors-gray-900));
    color: rgb(var(--colors-gray-100));
}

.tail-terminal pre {
    white-space: pre-wrap;
    overflow-wrap: anywhere;
}

.tail-scroll-actions {
    display: flex;
    justify-content: flex-end;
    padding: 0.5rem;
}

.tail-scroll-button {
    min-height: 44px;
    background: rgb(var(--colors-primary-600));
    color: white;
}

.tail-scroll-button:hover {
    background: rgb(var(--colors-primary-700));
}

.tail-scroll-button:active {
    background: rgb(var(--colors-primary-800));
}

.tail-scroll-button:focus-visible {
    outline: 2px solid currentColor;
    outline-offset: -4px;
}
</style>
