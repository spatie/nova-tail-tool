export default class LogReader {
    constructor({ callback }) {
        this.callback = callback;

        this.lastRetrievedLineNumber = null;

        this.poller = window.setInterval(() => this.fetchNewLines(), 1000);
    }

    async fetchNewLines() {
        const response = await window.axios.post(`/nova-vendor/spatie/tail-tool`, {
            afterLineNumber: this.lastRetrievedLineNumber
        });

        this.lastRetrievedLineNumber = response.data.lastRetrievedLineNumber;

        this.callback(response.data.text);
    }

    destroy() {
        window.clearInterval(this.poller);
    }
}
