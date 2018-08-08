<template>
    <div>
        <heading class="mb-6">
            Application log
        </heading>

        <card ref="terminal" class="bg-90 text-white overflow-y-auto" style="height: calc(100vh - 16rem)">
            <!-- Keep these tags together to avoid whitespace issues -->
            <pre class="p-4"><code
                class="font-mono leading-normal"
                v-html="logLines || placeholder"
            ></code></pre>
        </card>
    </div>
</template>

<script>
export default {
    data: () => ({
        logLines: '',
        poller: null,
        lastRetrievedLineNumber: null,
        placeholder: 'Listening',
    }),

    mounted() {
        this.poller = window.setInterval(this.fetchNewLines, 1000);
    },

    beforeDestroy() {
        window.clearInterval(this.poller);
    },

    methods: {
        async fetchNewLines() {
            const response = await window.axios.post(`${Nova.config.base}/tail-tool`, {
                afterLineNumber: this.lastRetrievedLineNumber,
            });

            this.logLines += response.data.text;
            this.lastRetrievedLineNumber = response.data.lastRetrievedLineNumber;

            if (!this.logLines) {
                this.placeholder = this.placeholder.length > 11
                    ? 'Listening.'
                    : this.placeholder + '.';
            }

            if (this.scrolledToBottom()) {
                await this.$nextTick();

                this.scrollToBottom();
            }
        },

        scrolledToBottom() {
            const terminal = this.$refs.terminal.$el;

            return terminal.scrollTop >= (terminal.scrollHeight - terminal.offsetHeight);
        },

        scrollToBottom() {
            const terminal = this.$refs.terminal.$el;

            terminal.scrollTop = terminal.scrollHeight;
        },
    },
};
</script>
