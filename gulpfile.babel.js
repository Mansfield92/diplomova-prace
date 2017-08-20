import gulp              from 'gulp';
import config            from './config';
import sourcemaps        from 'gulp-sourcemaps';
import webpackConfigDev from './webpack/webpack.config';
import webpackConfigProd from './webpack/webpack.config.prod';
import webpack           from 'webpack';
import plumber           from 'gulp-plumber';
import pug               from 'gulp-pug';
import svgSymbols        from 'gulp-svg-symbols';
import rename            from 'gulp-rename';
import image             from 'gulp-imagemin';
import del               from 'del';
import runSequence       from 'run-sequence';
import gutil             from 'gulp-util';
import prettify          from 'gulp-html-prettify';
import webp              from 'gulp-webp';
import notify            from 'gulp-notify';
import eslint            from 'gulp-eslint';
import sass              from 'gulp-ruby-sass';
import cssnano           from 'gulp-cssnano';

const webpackDevMiddleware = require('webpack-dev-middleware');
const webpackHotMiddleware = require('webpack-hot-middleware');
const browserSync = require('browser-sync').create();
const reload = browserSync.reload;
const bundler = webpack(webpackConfigDev);

gulp.task('browser-sync', () => {
    browserSync.init({
        port: config.localPort,
        server: {
            baseDir: `./${config.outputPath}`,
            index: `${config.staticTemplatesFolder}/index.html`,

            middleware: [
                webpackDevMiddleware(bundler, {
                    publicPath: webpackConfigDev[0].output.publicPath,
                    noInfo: true,
                    inline: true,
                    stats: {
                        assets: false,
                        colors: true,
                        warnings: false
                    }
                }),
                webpackHotMiddleware(bundler)
            ]
        }
    });
});

/* postcss plugins */
const supportedBrowsers = ['last 2 versions', 'ie 10', 'Safari 8'];

/**
* CSS-dev
*/
gulp.task('css-dev', () => {
    return sass(`${config.assetsPath}css/style.sass`, {sourcemap: true})
        .on('error', function(err) {
            notify({
                title: 'css',
                message: err,
                sound: 'Beep'
            }).write(err);
            this.emit('end');
        })
        .pipe(cssnano({ autoprefixer: { browsers: supportedBrowsers, add: true, colormin: false}}))
        .pipe(sourcemaps.write())
        .pipe(rename({ extname: '.css' }))
        .pipe(gulp.dest(`${config.outputPath}css/`))
        .pipe(browserSync.stream());
});

/**
* CSS-prod
*/
gulp.task('css-prod', () => {
    return sass(`${config.assetsPath}css/style.sass`, {sourcemap: false})
        .pipe(cssnano({ autoprefixer: { browsers: supportedBrowsers, add: true, colormin: false}}))
        .pipe(rename({ extname: '.css' }))
        .pipe(gulp.dest(`${config.outputPath}css/`));
});

/**
* Pug
*/
gulp.task('pug', () => {
    let YOUR_LOCALS = {};
    gulp.src([`${config.assetsPath}pug/*.pug`, '!' + `${config.assetsPath}pug/layout.pug`])
        .pipe(plumber())
        .pipe(pug({
            locals: YOUR_LOCALS,
            pretty: true
        }))
        .on('error', function(err) {
            notify({
                title: 'Pug',
                message: err,
                sound: 'Beep'
            }).write(err);
            this.emit('end');
        })
        .pipe(gulp.dest(`${config.assetsPath}${config.staticTemplatesFolder}`))
        .pipe(gulp.dest(`${config.outputPath}${config.staticTemplatesFolder}`));
});

/**
* Adjust indentation
*/
gulp.task('prettify', function() {
    gulp.src(`${config.assetsPath}${config.staticTemplatesFolder}/*.html`)
        .pipe(prettify({ indent_char: ' ', indent_size: 4 }))
        .pipe(gulp.dest(`${config.outputPath}${config.staticTemplatesFolder}`));
});

/**
*  Images
*/
gulp.task('images', ['cleanup'], () => {
    return gulp.src([`${config.assetsPath}${config.imageFolder}/**/*`,
                    `!${config.assetsPath}${config.imageFolder}/${config.svgFolder}/`,
                    `!${config.assetsPath}${config.imageFolder}/${config.svgFolder}/*`])
        .pipe(gulp.dest(`${config.outputPath}${config.imageFolder}`));
});

/**
* Webpack - production
*/
gulp.task('webpack-prod', function() {
    webpack(webpackConfigProd, function(err, stats) {
        if (err) {
            throw new gutil.PluginError('webpack:build', err);
        }
        gutil.log('[webpack:build]', stats.toString({
            colors: true,
            noInfo: true
        }));
    });
});

/**
* Cleanup images
*/
gulp.task('cleanup', () => {
    return del([`${config.outputPath}${config.imageFolder}`]);
});

/**
* DEVELOPMENT
*/
gulp.task('default', ['pug', 'css-dev', 'images', 'browser-sync'], () => {

    // watch js
    gulp.watch(`${config.assetsPath}js/**/*.js`);

    // watch pug
    gulp.watch(`${config.assetsPath}pug/**/*.pug`, ['pug']);

    // watch html
    gulp.watch(`${config.outputPath}${config.staticTemplatesFolder}/*.html`).on('change', reload);

    // watch css
    gulp.watch(`${config.assetsPath}${config.cssFolder}/**/*.sass`, ['css-dev']);
    gulp.watch(`${config.assetsPath}${config.cssFolder}/**/*.scss`, ['css-dev']);

    // watch images except
    gulp.watch([`${config.assetsPath}${config.imageFolder}/**/*.{jpg,jpeg,png,gif,svg}`])
        .on('change', (file) => {
            if (file.type !== 'deleted') {
                let sourceFolder = config.assetsPath + config.imageFolder,
                    folderIndex = file.path.indexOf(sourceFolder) + sourceFolder.length + 1,
                    subFolders = file.path.substr(folderIndex).split('/'),
                    outputFolder = config.outputPath + config.imageFolder;

                if (subFolders.length > 1) {
                    let fileOffsetLen = subFolders.length - 1;
                    if (subFolders[fileOffsetLen] === '') {
                        fileOffsetLen = subFolders.length - 2;
                    }
                    for (let s = 0; s < fileOffsetLen; s++) {
                        outputFolder += '/' + subFolders[s];
                    }
                }
                gulp.src(file.path)
                    .pipe(image())
                    .pipe(gulp.dest(outputFolder));
            }
        });
});

/**
* PRODUCTION
*/
gulp.task('build', ['pug', 'webpack-prod', 'css-prod', 'images'], () => {
    runSequence(['prettify']);
});
