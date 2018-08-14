<template>
    <div>
        <heading class="mb-6">
            Application log
        </heading>

        <div class="relative" style="height: calc(100vh - 16rem)">
            <terminal
                ref="terminal"
                class="card h-full"
                :text="lines || placeholder"
            ></terminal>
        </div>
    </div>
</template>

<script>
import Terminal from './Terminal';
import LogReader from '../LogReader';

export default {
    data: () => ({
        lines: '',
        placeholder: 'Listening'
    }),

    components: {
        Terminal
    },

    mounted() {
        this.logReader = new LogReader({ callback: this.addLines });
    },

    beforeDestroy() {
        this.logReader.destroy();
    },

    methods: {
        addLines(lines) {
            console.log('add lines', lines);
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
