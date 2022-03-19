const mix = require('laravel-mix');


 mix.js('resources/js/main_script.js', 'public/js');
 
 
 mix.sass('resources/sass/app.scss', 'public/css');
 mix.copy('resources/images', 'public/images');
//  mix.copy('resources/video', 'public/video');
 mix.copy('resources/fonts', 'public/fonts');
 

 // mix.copy('node_modules/slick-carousel/slick/slick.js', 'public/js/plugins/slick');
 // mix.copy('node_modules/@fancyapps/fancybox/dist/jquery.fancybox.min.js', 'public/js/plugins/fancybox');
//  mix.copy('manifest.json', 'public/manifest.json');
 mix.copy('sw.js', 'public/sw.js');
//  mix.browserSync({
//      proxy: 'http://localhost',
//      notify: false
//  });
 mix.sourceMaps();
 
 
 if (mix.inProduction()) {
     mix.version();
 } else {
     // Uses inline source-maps on development
     mix.webpackConfig({
         devtool: 'inline-source-map'
     });
 }
