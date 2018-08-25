Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'TailTool',
            path: '/application-log',
            component: require('./components/TailTool'),
        },
    ]);
});
