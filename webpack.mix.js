const mix = require("laravel-mix");
const tailwindcss = require("tailwindcss"); /* Add this line at the top */

mix.js("resources/js/app.js", "public/js")
    .sass("resources/sass/app.scss", "public/css")
    // .sass("resources/sass/bootstrap.scss", "public/css")
    .options({
        processCssUrls: true,
        postCss: [tailwindcss("./tailwind.config.js")],
    })
    .version();
