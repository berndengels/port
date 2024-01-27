const path = require('path');

module.exports = {
    stats: {
        children: true,
        warnings: false,
    },
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
            'v@': path.resolve('resources/js/vue'),
            'L@': path.resolve('resources/js/Libs'),
            '@sass': path.resolve('resources/sass'),
        },
    },
};
