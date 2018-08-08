export default class LogReader {
    constructor({ callback }) {
        this.callback = callback;

        this.lastRetrievedLineNumber = null;

        this.poller = window.setInterval(this.fetchNewLines.bind(this), 1000);
    }

    async fetchNewLines() {
        const response = await window.axios.post(`${Nova.config.base}/tail-tool`, {
            afterLineNumber: this.lastRetrievedLineNumber
        });

        this.lastRetrievedLineNumber = response.data.lastRetrievedLineNumber;

        this.callback(response.data.text);
    }

    destroy() {
        window.clearInterval(this.poller);
    }
}
