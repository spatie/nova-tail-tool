Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'TailTool',
            path: '/TailTool',
            component: require('./components/TailTool'),
        },
    ]);
});
