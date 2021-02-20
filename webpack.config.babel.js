
// I. Installation
// npm init
// npm install
// npm i --save-dev webpack webpack-cli @babel/core @babel/preset-env @babel/register

// II. Modules
// npm i --save-dev node-sass css-loader sass-loader babel-loader

//for svg to font
// npm i --save-dev postcss-loader iconfont-webpack-plugin


// III. Plugins
// npm i --save-dev browser-sync browser-sync-webpack-plugin mini-css-extract-plugin optimize-css-assets-webpack-plugin terser-webpack-plugin

// this are specifically for IE
// npm i --save-dev babel-polyfill isomorphic-fetch

import path                     from 'path'; //request to node core module (no install needed)
import BrowserSyncPlugin        from 'browser-sync-webpack-plugin';
import MiniCssExtractPlugin     from 'mini-css-extract-plugin';
// import OptimizeCSSAssetsPlugin  from 'optimize-css-assets-webpack-plugin';
import TerserPlugin             from 'terser-webpack-plugin';
import IconfontWebpackPlugin    from 'iconfont-webpack-plugin';

// FINAL
// webpack --watch

module.exports = {
    //Possible values for mode are: none, development or production(default).
    mode: 'production',
    entry: {
        'js/bundle.min.js':  ['babel-polyfill', 'isomorphic-fetch', './resources/js/index.js'],
        'css/bundle':                 './resources/sass/app.scss',
    },
    watch: true,
    output: {
        //set the path and name depending on the entry property name
        path: path.resolve(__dirname, './public/assets/'),
        filename: '[name]'
    },
    optimization: {
        minimizer: [new TerserPlugin({})],
    },
    module: {
        rules : [
            //To compile SASS files
            {
                test: /\.s?[ac]ss$/,
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader},
                    {
                        loader: 'css-loader',
                        options: {
                            url: false,
                            sourceMap: false
                        }
                    },

                    { loader: 'sass-loader', options: { sourceMap: false } }
                ],
            },
            //To compile JS ES6 files
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: 'babel-loader',
                // query: {
                //     presets: ['@babel/preset-env'],
                // }
            }
        ]
    },
    plugins: [
        //this will refresh the resources (js, css) will modifying them
        new BrowserSyncPlugin({
            host: 'localhost',
            proxy: 'https://dev.redtutorial.com',
            port: 3000,
        }),
        new MiniCssExtractPlugin({ // define where to save the file
            filename: '[name].min.css',
        })
    ]
};
