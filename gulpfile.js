var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */
elixir.config.assetsPath = 'public/themes/default/assets';
elixir.config.publicPath = elixir.config.assetsPath;

elixir.config.css.sass.pluginOptions.includePaths = [
    'node_modules/bootstrap-sass/assets/stylesheets',
]


elixir(function(mix) {
    mix.sass('backend.scss');
    mix.copy('node_modules/bootstrap-sass/assets/fonts',elixir.config.publicPath+'/fonts');
    mix.copy('node_modules/bootstrap-sass/assets/javascripts',elixir.config.publicPath+'/js');
});
