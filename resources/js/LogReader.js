export default class LogReader {
    constructor({ callback, onError }) {
        this.callback = callback;
        this.onError = onError;
        this.lastRetrievedLineNumber = null;
        this.file = null;
        this.controller = new AbortController();
        this.fetchNewLines();
    }

    async fetchNewLines() {
        try {
            const { data } = await Nova.request().post(
                '/nova-vendor/spatie/tail-tool',
                { afterLineNumber: this.lastRetrievedLineNumber, file: this.file },
                { signal: this.controller.signal }
            );

            if (this.controller.signal.aborted) return;

            this.lastRetrievedLineNumber = data.lastRetrievedLineNumber;
            this.file = data.file;
            this.callback(data.text);
        } catch (error) {
            if (!this.controller.signal.aborted) this.onError(error);
        } finally {
            if (!this.controller.signal.aborted) {
                this.poller = window.setTimeout(() => this.fetchNewLines(), 1000);
            }
        }
    }

    destroy() {
        this.controller.abort();
        window.clearTimeout(this.poller);
    }
}
