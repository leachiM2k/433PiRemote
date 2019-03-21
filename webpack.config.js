const webpack = require('webpack');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const CompressionPlugin = require('compression-webpack-plugin');
const HtmlWebpackInlineSourcePlugin = require('html-webpack-inline-source-plugin');

module.exports = (env, argv) => {
    let config = {
        entry: './src/index.js',
        module: {
            rules: [
                {
                    test: /\.css$/,
                    use: ['style-loader', 'css-loader']
                },
                {
                    test: /\.(js|jsx)$/,
                    exclude: /node_modules/,
                    use: ['babel-loader']
                }
            ]
        },
        resolve: {
            extensions: ['*', '.js', '.jsx']
        },
        plugins: [
            //new CleanWebpackPlugin(['public/dist/js']),
	    new HtmlWebpackPlugin({inlineSource: '.(js|css)$', template: __dirname + '/public/dist/index.html', minify: true, filename: 'index.html'}),
		new HtmlWebpackInlineSourcePlugin(),
		new CompressionPlugin({}),
        ],
	output: {
            path: __dirname + '/public/dist/js',
            publicPath: '/dist/js',
            filename: 'bundle.js',
            chunkFilename: '[name].[contenthash].bundle.js',
        }
    };

    if (argv.mode !== 'production') {
        config = {
            ...config,
            plugins: [
                new webpack.HotModuleReplacementPlugin()
            ],
            devServer: {
                contentBase: './dist',
                hot: true,
                proxy: {
                    '/api': {
                        target: 'http://localhost:9080'
                    }
                }
            }
        };
    }

    return config;
};
