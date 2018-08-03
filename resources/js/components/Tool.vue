<template>
    <div>
        <heading class="mb-6">Application log</heading>

        <card class="bg-90 flex flex-col p-8" style="min-height: 300px">
            <pre>
                <code
                  class="text-sm font-mono text-white"
                  v-html="logLines"
                ></code>
            </pre>
        </card>
    </div>
</template>

<script>
    import api from '../api';

    export default {
        data() {
            return {
                poller: null,
                'logLines': '',
                nextPartLineNumber: null,
            }
        },

        created() {
            this.poller = setInterval(this.fetchNewLines, 1000);
        },

        beforeDestroy() {
            clearInterval(this.poller);
        },

        methods: {
            async fetchNewLines() {
                let response = await api.fetchLogLines(this.nextPartLineNumber);
                this.logLines += response.text;
                this.nextPartLineNumber = response.nextPartLineNumber;
            },
        },
    }
</script>
