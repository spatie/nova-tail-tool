export default {
    async fetchLogLines(afterLineNumber = null) {
        let response = await window.axios.post(`${Nova.config.base}/tail-tool`, {
            afterLineNumber
        });

        return response.data;
    }
}