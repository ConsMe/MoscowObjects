

module.exports = {
  outputDir: '../public',
  indexPath: '../resources/views/index.blade.php',
  productionSourceMap: false,
  chainWebpack: (config) => {
    config
      .plugin('provide')
      .use(require('webpack').ProvidePlugin, [{
        $: 'jquery',
        jquery: 'jquery',
        jQuery: 'jquery',
        'window.jQuery': 'jquery',
      }]);
  },
};
