const webpack = require('webpack');
const CleanWebpackPlugin = require('clean-webpack-plugin');

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
            new CleanWebpackPlugin(['public/dist/js']),
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
