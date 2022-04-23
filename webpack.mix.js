const mix = require('laravel-mix');


mix.copy('resources/js/plugins', 'public/js/plugins');
mix.js('resources/js/main_script.js', 'public/js');
mix.js('resources/js/main_page_script.js', 'public/js');
mix.js('resources/js/course_page_script.js', 'public/js');
mix.js('resources/js/blog_page_script.js', 'public/js');
mix.js('resources/js/podcast_page_script.js', 'public/js');
mix.js('resources/js/online_page_script.js', 'public/js');
mix.js('resources/js/quiz_page_script.js', 'public/js');
mix.js('resources/js/register_page_script.js', 'public/js');
mix.js('resources/js/profile_page_script.js', 'public/js');
mix.js('resources/js/dashboard.js', 'public/js');

mix.sass('resources/sass/slick.scss', 'public/css');
mix.sass('resources/sass/selects.scss', 'public/css');
mix.sass('resources/sass/audio.scss', 'public/css');
mix.sass('resources/sass/fancybox.scss', 'public/css');
mix.sass('resources/sass/app.scss', 'public/css');
mix.sass('resources/sass/dashboard.scss', 'public/css');

mix.copy('resources/images', 'public/images');
mix.copy('resources/fonts', 'public/fonts');


mix.copy('node_modules/jquery/dist/jquery.min.js', 'public/js/plugins');
mix.copy('node_modules/jquery-validation/dist/jquery.validate.min.js', 'public/js/plugins');
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
