Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'NovaTailTool',
            path: '/NovaTailTool',
            component: require('./components/NovaTailTool')
        }
    ]);
});
