export default class LogReader {
    constructor({ callback }) {
        this.callback = callback;

        this.lastRetrievedLineNumber = null;

        this.nextTimeout = null;

        this.fetchNewLines()
    }

    async fetchNewLines() {
        const response = await window.axios.post(`/nova-vendor/spatie/tail-tool`, {
            afterLineNumber: this.lastRetrievedLineNumber,
        });

        this.lastRetrievedLineNumber = response.data.lastRetrievedLineNumber;

        this.callback(response.data.text);

        this.nextTimeout = window.setTimeout(this.fetchNewLines, 1000);
    }

    destroy() {
        if ( this.nextTimeout )
        {
            window.clearTimeout(this.nextTimeout);
        }
    }
}
