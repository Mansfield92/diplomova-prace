import webpack from 'webpack';
import path from 'path';
import constants from './constants';

var config = {
    entry: [
        'babel-polyfill',
        path.join(constants.SRC_DIR, 'js/main.js')
    ],
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: ['babel-loader']
            }
        ]
    },
    output: {
        filename: 'js/main.js',
        path: path.join(constants.DIST_DIR)
    },
    plugins: [
        new webpack.DefinePlugin({
            PRODUCTION: true,
            'process.env.NODE_ENV': JSON.stringify('production')
        }),
        new webpack.ProvidePlugin({
            $: "jquery",
            jQuery: "jquery",
            "window.jQuery": "jquery"
        }),
        new webpack.optimize.UglifyJsPlugin({
            compress: {
                warnings: false
            }
        })
    ]
};

var webpackConfigProdMain = {...config};
var webpackConfigProdLogin = {
    ...config,
    entry: [
        'babel-polyfill',
        path.join(constants.SRC_DIR, 'js/login.js')
    ],
    output: {
        filename: 'login.js',
        path: path.join(constants.DIST_DIR, 'js')
    },
};

module.exports = [
    webpackConfigProdMain,
    webpackConfigProdLogin
];
