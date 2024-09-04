// vue.config.js
module.exports = {
    // 自定义打包的输出目录
    outputDir: 'dist',

    // 配置静态资源的目录（相对于 outputDir）
    assetsDir: 'static',

    // 关闭生产环境的 source map
    productionSourceMap: false,

    // 自定义开发服务器配置
    devServer: {
        port: 8080, // 修改开发服务器的端口
        open: true, // 自动打开浏览器
    },

    // 自定义 Webpack 配置
    configureWebpack: {
        // 在打包时的额外配置项
        plugins: [
            // 添加你需要的插件
        ],
        // 配置别名
        resolve: {
            alias: {
                '@components': '@/components',
            },
        },
    },

    // CSS 相关配置
    css: {
        // 启用 CSS source map
        sourceMap: true,

        // CSS 预处理器的配置
        loaderOptions: {
            scss: {}
        }
    },

    // 多页面模式配置
    pages: {
        index: {
            entry: 'src/main.js',
            template: 'public/index.html',
            filename: 'index.html',
            title: 'Home Page',
            chunks: ['chunk-vendors', 'chunk-common', 'index']
        },
        // 可以添加更多页面
    },

    // 配置第三方插件
    pluginOptions: {
        // 例：配置 Vuetify 插件
        vuetify: {
            // 选项
        }
    }
};
