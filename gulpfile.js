const elixir = require('laravel-elixir');
const webpack = require('webpack');

elixir((mix) => {
    mix.sass('app.scss')
        .webpack('app.js', null, null, {
            plugins: [
                new webpack.ProvidePlugin({
                    $: 'jquery',
                    jQuery: 'jquery',
                    'window.jQuery': 'jquery',
                    'window.$': 'jquery'
                })
            ]
        })
        .copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts'); // Копіюємо шрифти;
});