const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir((mix) => {
    mix.sass('app.scss', 'resources/assets/css/app.css')
        .sass('style.scss', 'resources/assets/css/style.css')
        .sass('forum/index.scss', 'resources/assets/css/forum/index.css')
        .sass('forum/show.scss', 'resources/assets/css/forum/show.css');

    mix.styles(['app.css', 'style.css', 'forum/index.css', 'forum/show.css']);

    // mix.version('css/all.css');

    // mix.browserSync();

    // mix.webpack('app.js');
});
