const mix = require('laravel-mix');
const path = require('path');
mix
    .js('resources/js/app.js', 'public/js')
    .vue()
    .alias({ '@': 'resources/js' })
    .postCss('resources/css/app.css', 'public/css', [
        require("tailwindcss"),
    ]);
mix.version().sourceMaps()
if (!mix.inProduction()) {
    mix.browserSync('https://fattify-inertia.test');
}
mix.alias({
    ziggy: path.resolve('vendor/tightenco/ziggy/dist/vue'),
});
