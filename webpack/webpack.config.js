import webpack from 'webpack';
import path from 'path';
import constants from './constants';

var config =  {
    devtool: 'source-map',
    entry: [
        'babel-polyfill',
        path.join(constants.SRC_DIR, 'js/main.js')
    ],
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: ['babel-loader', 'webpack-module-hot-accept']
            }
        ]
    },
    output: {
        filename: 'main.js',
        path: path.join(constants.DIST_DIR, 'js')
    },
    plugins: [
        new webpack.DefinePlugin({
            PRODUCTION: false,
            'process.env.NODE_ENV': JSON.stringify('development')
        }),
        new webpack.ProvidePlugin({
            $: "jquery",
            jQuery: "jquery",
            "window.jQuery": "jquery"
        })
    ]
};


var webpackConfigDevMain = {...config};
var webpackConfigDevLogin = {
    ...config,
    entry: [
        'babel-polyfill',
        path.join(constants.SRC_DIR, 'js/login.js')
    ],
    output: {
        filename: 'login.js',
        path: path.join(constants.DIST_DIR, 'js')
    }
};

module.exports = [
    webpackConfigDevMain,
    webpackConfigDevLogin
];
