<template>
    <div>
        <heading class="mb-6">
            Application log
        </heading>

        <card class="relative" style="height: calc(100vh - 16rem)">
            <terminal
                ref="terminal"
                class="h-full"
                :text="lines || placeholder"
            ></terminal>
        </card>
    </div>
</template>

<script>
import Log from '../Log';
import Terminal from './Terminal';

export default {
    data: () => ({
        lines: '',
        placeholder: 'Listening'
    }),

    components: {
        Terminal
    },

    mounted() {
        this.log = new Log({ callback: this.addLines });
    },

    beforeDestroy() {
        this.log.destroy();
    },

    methods: {
        addLines(lines) {
            this.lines += lines;

            if (!this.lines) {
                this.updatePlaceholder();
            }
        },

        updatePlaceholder() {
            this.placeholder = this.placeholder.length > 11 ? 'Listening.' : this.placeholder + '.';
        }
    }
};
</script>
