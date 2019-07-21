const gulp = require('gulp');
const browserSync = require('browser-sync').create();
const sass = require('gulp-sass');
const concat = require('gulp-concat');
const sourcemaps = require('gulp-sourcemaps');
const path = require("path");
const del = require('del');
const useref = require('gulp-useref');
const header = require('gulp-header');
const cleanCSS = require('gulp-clean-css');
const htmlmin = require('gulp-htmlmin');
const templateCache = require('gulp-angular-templatecache');
const package = require('./package.json');
const iife = require("gulp-iife");
const uglify = require('gulp-uglify');
const pipeline = require('readable-stream').pipeline;
const fs = require('fs');
const replace = require('gulp-replace');
const gutil = require('gulp-util');
const bulkSass = require('gulp-sass-bulk-import');
const opn = require('opn');
const babel = require('gulp-babel');

const destination = 'dist/';

gulp.task('clean', function () {
    return del('./' + destination + '**');
});

gulp.task('copy-files', function () {
    return gulp.src([
        'index.php', 'robots.txt', '.htaccess', 'assets/font/**', 'assets/img/**', 'assets/images/**', 'assets/admin/img/**', 'app/**', 'app/.htaccess',
        'assets/admin/css/img/**',
        '!app/config.ini',
        '!app/composer.json',
        '!app/composer.lock'

    ], {base: ".", nodir: true})
        .pipe(gulp.dest(destination));
});


// Static server
gulp.task('browser-sync', function (done) {

    historyApiFallback = require('connect-history-api-fallback');
    browserSync.init({
        ui: false,
        middleware: [historyApiFallback()],
        //browser: "google chrome"
    });
    opn('http://angularjsboil.az/');

    done();
});

gulp.task('angular', function (done) {
    var sources = ['assets/app/app.js', 'assets/app/**/*.js'];

    return gulp.src(sources, {base: '.'})
        .pipe(sourcemaps.init())
        .pipe(concat('assets/js/app.js'))
        .on('error', logError)
        .pipe(babel({
            presets: ['@babel/env']
        }))
        .pipe(sourcemaps.write({includeContent: false, sourceRoot: '/'}))
        .pipe(gulp.dest(destination));
});

gulp.task('dependencies', function (done) {
    gulp.src(['app/view/fragments/base.php'], {base: '.'})
        .pipe(useref({searchPath: '.'}))
        .pipe(gulp.dest(destination));
    setTimeout(function () {
        done();
    }, 1000)
});

gulp.task('angular-admin', function (done) {
    var sources = ['assets/admin/app/app.js', 'assets/admin/app/**/*.js'];

    return gulp.src(sources, {base: '.'})
        .pipe(sourcemaps.init())
        .pipe(concat('assets/admin/js/app.js'))
        .on('error', logError)
        .pipe(babel({
            presets: ['@babel/env']
        }))
        .pipe(sourcemaps.write({includeContent: false, sourceRoot: '/'}))
        .pipe(gulp.dest(destination));

});

gulp.task('dependencies-admin', function (done) {

    gulp.src(['app/view/admin/admin-index.php'], {base: '.'})
        .pipe(useref({searchPath: '.'}))
        .pipe(gulp.dest(destination));

    setTimeout(function () {
        done();
    }, 1000)

});


gulp.task('scss', function () {
    return gulp.src('assets/css/style.scss')
        .pipe(bulkSass())
        .pipe(sourcemaps.init())
        .pipe(sass({importer: importer}))
        .on('error', logError)
        .pipe(sourcemaps.write({includeContent: false, sourceRoot: '/assets/css'}))
        .pipe(gulp.dest(destination + 'assets/css/'))
        .pipe(browserSync.stream());
});


gulp.task('scss-admin', function () {
    return gulp.src('assets/admin/css/style.scss')
        .pipe(bulkSass())
        .pipe(sourcemaps.init())
        .pipe(sass({importer: importer}))
        .on('error', logError)
        .pipe(sourcemaps.write({includeContent: false, sourceRoot: '/assets/admin/css'}))
        .pipe(gulp.dest(destination + 'assets/admin/css/'))
        .pipe(browserSync.stream());
});


let svgSprite = require("gulp-svg-sprite");
let svgIconConfig = {
    shape: {
        id: { // SVG shape ID related options
            generator: "svg-", // SVG shape ID generator callback
        },
        dimension: {			// Set maximum dimensions
            maxWidth: 24,
            maxHeight: 24
        },
        spacing: {			// Add padding
            padding: 0,
            box: 'icon'
        },
        transform: ['svgo'],
        meta: null,

    },
    mode: {
        symbol: {			// Activate the «view» mode
            common: 'svg',
            bust: false,
            dimensions: false,
            sprite: 'sprite_icon.svg',
            //example: true,
            render: {
                css: false
            },
            inline: true
        }
    },
    svg: {							// General options for created SVG files
        xmlDeclaration: false,						// Add XML declaration to SVG sprite
        doctypeDeclaration: true,						// Add DOCTYPE declaration to SVG sprite
        namespaceIDs: true,						// Add namespace token to all IDs in SVG shapes
        namespaceClassnames: true,						// Add namespace token to all CSS class names in SVG shapes
        dimensionAttributes: false						// Width and height attributes on the sprite
    }

};
let svgPicConfig = {
    shape: {
        id: { // SVG shape ID related options
            generator: "svg-", // SVG shape ID generator callback
        },
        dimension: {// Dimension related options
            maxWidth: 2000, // Max. shape width
            maxHeight: 2000, // Max. shape height
            precision: 2, // Floating point precision
            attributes: false, // Width and height attributes on embedded shapes
        },
        spacing: { // Spacing related options
            padding: 0, // Padding around all shapes
            box: 'content' // Padding strategy (similar to CSS `box-sizing`)
        },
        transform: ['svgo'],
        meta: null, // Path to YAML file with meta / accessibility data
        align: null, // Path to YAML file with extended alignment data
    },
    mode: {
        symbol: {			// Activate the «view» mode
            common: 'svg',
            bust: false,
            dimensions: false,
            sprite: 'sprite_pic.svg',
            //example: true,
            render: {
                css: false
            },
            inline: true
        }
    },
    svg: {						// General options for created SVG files
        xmlDeclaration: false,						// Add XML declaration to SVG sprite
        doctypeDeclaration: true,						// Add DOCTYPE declaration to SVG sprite
        namespaceIDs: true,						// Add namespace token to all IDs in SVG shapes
        namespaceClassnames: true,						// Add namespace token to all CSS class names in SVG shapes
        dimensionAttributes: false						// Width and height attributes on the sprite
    }

};

gulp.task('sprites_icon', function () {
    svgIconConfig.mode.symbol.dest = "assets/css";
    return gulp.src("assets/svg-icons/**/*.svg").pipe(svgSprite(svgIconConfig)).pipe(gulp.dest(destination));
});
gulp.task('sprites_pic', function () {
    svgPicConfig.mode.symbol.dest = "assets/css";
    return gulp.src("assets/svg/**/*.svg").pipe(svgSprite(svgPicConfig)).pipe(gulp.dest(destination));
});
gulp.task('sprites', gulp.parallel('sprites_icon', 'sprites_pic', function (done) {
    done();
}));
gulp.task('sprites_icon-admin', function () {
    let svgIconConfigAdmin = JSON.parse(JSON.stringify(svgIconConfig));
    svgIconConfigAdmin.mode.symbol.dest = "assets/admin/css";
    return gulp.src("assets/admin/svg-icons/**/*.svg").pipe(svgSprite(svgIconConfigAdmin)).pipe(gulp.dest(destination));
});
gulp.task('sprites_pic-admin', function () {
    let svgPicConfigAdmin = JSON.parse(JSON.stringify(svgPicConfig));
    svgPicConfigAdmin.mode.symbol.dest = "assets/admin/css";
    return gulp.src("assets/admin/svg/**/*.svg").pipe(svgSprite(svgPicConfigAdmin)).pipe(gulp.dest(destination));
});
gulp.task('sprites-admin', gulp.parallel('sprites_icon-admin', 'sprites_pic-admin', function (done) {
    done();
}));

function browserSyncReload(done) {
    browserSync.reload();
    done();
}


gulp.task('watch', gulp.series(gulp.parallel('scss', 'angular', 'scss-admin', 'angular-admin', 'sprites', 'sprites-admin'), function watch(done) {
    gulp.watch(['assets/**/*css'], gulp.parallel('scss'));
    gulp.watch(['assets/**/*.svg'], gulp.series('sprites', browserSyncReload));
    gulp.watch(['assets/app/**/*.js'], gulp.series('angular', browserSyncReload));
    gulp.watch(["assets/app/**/*.html", "app/**/*.php", "assets/admin/app/**/*.html"], gulp.parallel(browserSyncReload));

    gulp.watch(['assets/admin/**/*css'], gulp.parallel('scss-admin'));
    gulp.watch(['assets/admin/app/**/*.js'], gulp.series('angular-admin', browserSyncReload));
    gulp.watch(['assets/admin/**/*.svg'], gulp.series('sprites-admin', browserSyncReload));
    done();
}));


gulp.task('default', gulp.series(gulp.parallel('clean'), 'watch', 'browser-sync'));

function importer(url, prev, done) {
    if (url[0] === '~') {
        url = path.resolve('./node_modules/' + url.substr(1));
    } else if (url[0] === '/') {
        //url = path.resolve( url.substr(1));
    }
    return {file: url};
}

function logError(error) {

    // If you want details of the error in the console
    console.log(error.toString());
    this.emit('end')
}

gulp.task('ng-templates', function () {
    return gulp.src(['assets/app/**/*.html'])
        .pipe(htmlmin({
            collapseWhitespace: true,
            removeComments: true,
            sortAttributes: true,
            sortClassName: true,
            ignoreCustomFragments: [/<%[\s\S]*?%>/, /<\?[\s\S]*?(\?>|$)/],
            trimCustomFragments: true
        }))
        .pipe(templateCache({root: '/'}))
        .pipe(replace("angular.module('templates')", 'app'))
        .pipe(gulp.dest(destination + 'assets/js'));
});

gulp.task('ng-templates-admin', function () {
    return gulp.src(['assets/admin/app/**/*.html'])
        .pipe(htmlmin({
            collapseWhitespace: true,
            removeComments: true,
            sortAttributes: true,
            sortClassName: true,
            ignoreCustomFragments: [/<%[\s\S]*?%>/, /<\?[\s\S]*?(\?>|$)/],
            trimCustomFragments: true
        }))
        .pipe(templateCache({root: '/'}))
        .pipe(replace("angular.module('templates')", 'app'))
        .pipe(gulp.dest(destination + '/assets/admin/js'));
});


gulp.task('concat-ng-templates', function () {
    return gulp.src(['assets/js/app.js', 'assets/js/templates.js'], {base: destination, cwd: destination})
        .pipe(concat('assets/js/app.js'))
        .pipe(gulp.dest(destination));
});


gulp.task('concat-ng-templates-admin', function () {
    return gulp.src(['assets/admin/js/app.js', 'assets/admin/js/templates.js'], {base: destination, cwd: destination})
        .pipe(concat('assets/admin/js/app.js'))
        .pipe(gulp.dest(destination));
});

gulp.task('scripts-minify', gulp.series('angular', 'ng-templates', 'dependencies', 'concat-ng-templates', function minify(done) {
    // Minify and copy all JavaScript (except vendor scripts)
    // with sourcemaps all the way down
    del('./' + destination + 'assets/js/templates.js');
    return pipeline(
        gulp.src(['assets/js/app.js'], {base: destination, cwd: destination}),
        iife({
            useStrict: false
        }),
        uglify({toplevel: true}),
        header(fs.readFileSync('header.txt', 'utf8'), {pkg: package}),
        gulp.dest(destination)
    );

    /* return gulp.src(['assets/js/app.js'], {base: destination, cwd: destination})
         .pipe(iife({
             useStrict: false
         }))
         .pipe(
             babel({
                 presets: ['@babel/env']
             })
         )
         .pipe(uglify().on('error', function (e) {
             console.log(e);
             //callback(e);
         }))
         .pipe(header(fs.readFileSync('header.txt', 'utf8'), {pkg: package}))
         .pipe(gulp.dest(destination));*/
}));

gulp.task('scripts-minify-admin', gulp.series('angular-admin', 'ng-templates-admin', 'dependencies-admin', 'concat-ng-templates-admin', function scriptsMinifyAdmin(done) {
    // Minify and copy all JavaScript (except vendor scripts)
    // with sourcemaps all the way down
    del('./' + destination + 'assets/admin/js/templates.js');
    return pipeline(
        gulp.src(['assets/admin/js/app.js'], {base: destination, cwd: destination}),
        iife({
            useStrict: false
        }),
        uglify(),
        header(fs.readFileSync('header.txt', 'utf8'), {pkg: package}),
        gulp.dest(destination)
    )
        ;
    /*return gulp.src(['assets/admin/js/app.js'], {base: destination, cwd: destination})
        .pipe(iife({
            useStrict: false
        }))
        .pipe(minifyes())/!*.on('error', function (e) {
            console.log(e);
            //callback(e);
        }))*!/
        .pipe(header(fs.readFileSync('header.txt', 'utf8'), {pkg: package}))
        .pipe(gulp.dest(destination));*/
}));


gulp.task('styles-minify', gulp.series(gulp.parallel('scss', 'sprites'), function () {
    del('./' + destination + 'assets/css/style.scss');
    return gulp.src(['assets/css/style.css'], {base: destination, cwd: destination})
    //.pipe(sourcemaps.init())
        .pipe(cleanCSS({
            level: {
                1: {
                    specialComments: 'none'
                },
                2: {
                    //normalizeUrls: false
                }
            },
            //inline: ['local'],
            rebase: false
        }))
        //.pipe(sourcemaps.write())
        .pipe(header(fs.readFileSync('header.txt', 'utf8'), {pkg: package}))
        .pipe(gulp.dest(destination));
}));

gulp.task('styles-minify-admin', gulp.series(gulp.parallel('scss-admin', 'sprites-admin'), function () {
    del('./' + destination + 'assets/admin/css/style.scss');
    return gulp.src(['assets/admin/css/style.css'], {base: destination, cwd: destination})
    //.pipe(sourcemaps.init())
        .pipe(cleanCSS({
            level: {
                1: {
                    specialComments: 'none',
                    normalizeUrls: false
                }
            },
            rebase: false
        }))
        //.pipe(sourcemaps.write())
        .pipe(header(fs.readFileSync('header.txt', 'utf8'), {pkg: package}))
        .pipe(gulp.dest(destination));
}));

gulp.task('php-minify', function () {
    return gulp.src(['app/view/fragments/base.php'], {base: destination, cwd: destination})
        .pipe(htmlmin({
            collapseWhitespace: true,
            removeComments: true,
            sortAttributes: true,
            sortClassName: true,
            ignoreCustomFragments: [/<%[\s\S]*?%>/, /<\?[\s\S]*?(\?>|$)/],
            trimCustomFragments: true
        }))
        .pipe(gulp.dest(destination));
});

gulp.task('php-minify-admin', function () {
    return gulp.src(['app/view/admin/admin-index.php'], {base: destination, cwd: destination})
        .pipe(htmlmin({
            collapseWhitespace: true,
            removeComments: true,
            sortAttributes: true,
            sortClassName: true,
            ignoreCustomFragments: [/<%[\s\S]*?%>/, /<\?[\s\S]*?(\?>|$)/],
            trimCustomFragments: true
        }))
        .pipe(gulp.dest(destination));
});


gulp.task('production-replace', function () {
    function rndStr() {
        var x = '';
        while (x.length != 5) {
            x = Math.random().toString(36).substring(7).substr(0, 5);
        }
        return x;
    }

    var cacheBuster = rndStr();

    return gulp.src(['app/view/fragments/base.php', 'app/view/mainPage.php', 'app/view/admin/admin-index.php', 'assets/js/app.js', 'assets/admin/js/app.js'], {
        base: destination,
        cwd: destination
    })
    //adding version to stop caching
        .pipe(replace('js/app.js', 'js/app.js?cs=' + cacheBuster))
        .pipe(replace('css/style.css', 'css/style.css?cs=' + cacheBuster))

        .pipe(replace('debugInfoEnabled(!0)', 'debugInfoEnabled(false)'))
        .pipe(replace('[[version]]', package.version))
        .pipe(replace(/<ng-include src="'(.*?\.svg)'"><\/ng-include>/g, function (match, p1) {
            const svg = fs.readFileSync(path.resolve('.' + p1));
            del('.' + p1);
            return svg;
        }))
        .pipe(replace('/dist/', '/'))
        .pipe(replace('/assets/app/', '/'))
        .pipe(replace('/assets/admin/app/', '/'))

        .pipe(gulp.dest(destination));

});

gulp.task('distribute', gulp.series('clean', 'copy-files',
    gulp.series('styles-minify', 'styles-minify-admin', 'scripts-minify', 'scripts-minify-admin'),
    gulp.parallel('php-minify', 'php-minify-admin'),
    'production-replace'
    )
);


gulp.task('deploy', function () {

    var ftp = require('vinyl-ftp');
    var conn = ftp.create({
        host: 'ftp.example.com',
        user: 'ftp@example.ir',
        password: 'password',
        parallel: 7,
        log: gutil.log
    });

    // using base = '.' will transfer everything to /public_html correctly
    // turn off buffering in gulp.src for best performance

    return gulp.src(['./dist/**', 'dist/**/.htaccess'], {base: './dist', buffer: false}).pipe(conn.newer('/')) // only upload newer files
        .pipe(conn.dest('/'));

});