const path = require('path');
const {VueLoaderPlugin} = require('vue-loader');
const webpack = require("webpack");

module.exports = {
    mode: 'development',
    entry: './js/index.js',
    output: {
        path: path.resolve(__dirname, 'dist'),
        filename: 'index_bundle.js'
    },
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            },
            {
                test: /(\.css|\.less)$/,
                use: [
                    'vue-style-loader',
                    'css-loader',
                    'less-loader',
                ]
            },
            {
                test: /\.js$/,
                loader: "esbuild-loader",
                options: {
                    target: 'es2018',
                }
            },
        ]
    },

    plugins: [
        new VueLoaderPlugin(),

        new webpack.DefinePlugin({
            __VUE_OPTIONS_API__: true,
            __VUE_PROD_DEVTOOLS__: true
        }),
    ]
}
