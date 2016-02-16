var webpack = require("webpack");
var path = require('path');
var autoprefixer = require('autoprefixer');

module.exports = {
    entry: [
        'webpack-dev-server/client?http://localhost:3000',
        'webpack/hot/only-dev-server',
        './src/index.js'
    ],
    output: {
        path: '/public/js',
        publicPath: 'http://localhost:3000/static/',
        filename: 'bundle.js'
    },
    module: {
        loaders: [
        {
            test: /\.js$/,
            loader: 'babel-loader',
            exclude: /node_modules/
        }, {
            test: /\.scss$/,
            loader: 'style!css!sass',
            include: /src/
        }, {
            test: /\.css$/,
            loader: 'style!css!postcss'
        }, {
            test: /\.(png|jpg)$/,
            loader: 'url?limit=8192',
            include: /src/
        }, {
            test: /\.woff(2)?(\?v=[0-9]\.[0-9]\.[0-9])?$/,
            loader: "url-loader?limit=10000&minetype=application/font-woff"
        }, {
            test: /\.(ttf|eot|svg)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
            loader: "file-loader"
        }],
    },
    resolve: {
        extensions: ['', '.js', '.json', '.jsx']
    },
    devServer: {
        colors: true,
        historyApiFallback: true,
        progress: true,
        hot: true,
        port: 3000,
        inline: false,
        contentBase: './dist'
    },
    plugins: [
        new webpack.HotModuleReplacementPlugin(),
        new webpack.NoErrorsPlugin(),
        new webpack.optimize.UglifyJsPlugin({
            compress: {
                warnings: false,
            },
            sourceMap: true
        })
    ],
    devtool: 'eval-source-map',
    postcss: [
        autoprefixer({
            browsers: ['last 3 versions']
        })
    ]
};
