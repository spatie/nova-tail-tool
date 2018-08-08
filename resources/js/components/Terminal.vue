<template>
    <div class="relative overflow-hidden">
        <div ref="window" class="bg-90 text-white overflow-y-auto h-full">
            <!-- Keep `pre` and `code` tags together to avoid whitespace issues -->
            <pre class="p-4"><code class="font-mono leading-normal" v-html="text"></code></pre>
        </div>
        <transition name="toast">
            <div v-if="!isScrolledToBottom" class="absolute pin-b pin-r pin-l flex justify-center">
                <button
                    class="bg-primary font-semibold p-2 rounded-t text-white flex items-end"
                    @click="scrollToBottom"
                >
                    Scroll to bottom
                    <unseen-icon v-if="hasUnseenContent" class="ml-1 w-4"></unseen-icon>
                </button>
            </div>
        </transition>
    </div>
</template>

<script>
import UnseenIcon from './UnseenIcon';
import animateScrollTo from 'animated-scroll-to';

export default {
    props: ['text'],

    data: () => ({
        isScrolledToBottom: true,
        hasUnseenContent: false
    }),

    components: {
        UnseenIcon
    },

    mounted() {
        this.updateIsScrolledToBottom();

        this.$watch('text', () => {
            if (this.isScrolledToBottom) {
                this.$nextTick(this.scrollToBottom);
            } else {
                this.hasUnseenContent = true;
            }
        });

        this.$refs.window.addEventListener('scroll', this.updateIsScrolledToBottom);
    },

    beforeDestroy() {
        this.$refs.window.removeEventListener('scroll', this.updateIsScrolledToBottom);
    },

    methods: {
        updateIsScrolledToBottom() {
            this.isScrolledToBottom =
                this.$refs.window.scrollTop >= this.$refs.window.scrollHeight - this.$refs.window.offsetHeight;

            if (this.isScrolledToBottom) {
                this.hasUnseenContent = false;
            }
        },

        scrollToBottom() {
            animateScrollTo(this.$refs.window.scrollHeight, {
                speed: 250,
                element: this.$refs.window
            });
        }
    }
};
</script>

<style scoped>
.toast-enter-active,
.toast-leave-active {
    transition: all 0.3s;
}

.toast-enter,
.toast-leave-to {
    opacity: 0.5;
    transform: translateY(100%);
}
</style>
