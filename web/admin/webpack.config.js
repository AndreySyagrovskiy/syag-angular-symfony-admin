var ExtractTextPlugin = require('extract-text-webpack-plugin');

function getEntrySources(sources) {
    if (process.env.NODE_ENV !== 'production') { // for live reload
        sources.push('webpack-dev-server/client?http://0.0.0.0:8000');
    }

    return sources;
}


var ngAdminAndVendorSources = [
    //'./bower_components/ng-admin/build/ng-admin.min.js',
    './js/source/app.module.js',
    './scss/style.scss',
];

module.exports = {
    entry: {
        'main': getEntrySources(ngAdminAndVendorSources)
    },
    output: {
        publicPath: "http://localhost:8000/",
        filename: "build/[name].min.js"
    },
    module: {
        loaders: [
            { test: /\.js/, loaders: ['babel'], exclude: /node_modules|bower_components/ },
            { test: /node_modules\/admin-config.*\.js/, loaders: ['babel']},
            { test: /\.js/, loaders: ['ng-annotate'] },
            { test: /\.html$/, loader: 'html' },
            { test: /\.(woff2?|svg|ttf|eot)(\?.*)?$/, loader: 'url' },
            { test: /\.css$/, loader: ExtractTextPlugin.extract('css') },
            { test: /\.scss$/, loader: ExtractTextPlugin.extract('css!sass') }
        ]
    },
    plugins: [
        new ExtractTextPlugin('build/[name].min.css', {
            allChunks: true
        })
    ]
};
