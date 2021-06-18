const mix = require('laravel-mix');
mix.js('resources/js/app.js', 'public/js')
    .vue()
    .postCss('resources/css/app.css', 'public/css', [
        require("tailwindcss"),
    ]);
mix.version().sourceMaps()
if (!mix.inProduction()) {
    // mix.browserSync('https://fattify-inertia.test');
}
