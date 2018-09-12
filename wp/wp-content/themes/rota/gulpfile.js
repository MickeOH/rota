// General
var gulp = require('gulp'),
    fs = require('fs'),
    del = require('del'),
    browserSync = require('browser-sync').create(),
    package = require('./package.json'),
    plumber = require('gulp-plumber'),
    sourcemaps = require('gulp-sourcemaps'),
    watch = require('gulp-watch'),
    loadPlugins = require('gulp-load-plugins'),
    rename = require('gulp-rename'),
    imagemin = require('gulp-imagemin'),
    runSequence = require('run-sequence');

// Scripts and test
var uglify = require('gulp-uglify'),
    concat = require('gulp-concat');

// Styles
var sass = require('gulp-sass'),
    cleanCSS = require('gulp-clean-css'),
    stripCssComments = require('gulp-strip-css-comments');

// Default config
var config = {
    url: 'http://rota.local.site',
    syncFiles : ['**/*.php', '**/**/*.php', '*.php', 'assets/img/**/*.{png,jpg,gif}'],
    styles : {
        input : './assets/sass/app.scss',
        filesToListen: ['./assets/sass/*.{scss,sass}', './assets/sass/**/*.{scss,sass}'],
        tempOutput : './assets/css/',
        output : './dist/css/',
        filesToClean: './dist/css/*.css',
    },
    js : {
        input : './assets/js/app.js',
        output : './dist/js/',
        filesToClean: './dist/js/*.js',
    },
    fonts : {
        filesToMove : './assets/webfonts/*',
        dist : './dist/webfonts'
    },
    img : {
        input : './assets/img/*',
        output : './assets/img'
    },
    filesToDelete : ['./assets/**/*.map', './dist/**/*.map']
};

// Bundling with wro.xml
var xmldoc = require('./node_modules/xmldoc');

var bundleFile = fs.readFileSync("./gulp.bundle.xml", "utf8"),
    bundleXML = new xmldoc.XmlDocument(bundleFile),
    bundleConfig = [];

// Loop through groups, push to JS & CSS arrays.
bundleXML.eachChild(function(group, index, array) {
    var groupName      = group.attr.name,
        jsDestination  = config.js.output,
        cssDestination = config.styles.output;

    bundleConfig[index] = {
        js: { 
            dest: jsDestination,
            src: [],
            groupName: groupName + '.js'
        },
        css: {
            dest: cssDestination,
            src: [],
            groupName: groupName + '.css'
        }
    };

    processGroup(groupName, group.children, jsDestination, cssDestination, index);
});

function processGroup(groupName, groupItems, jsDestination, cssDestination, index) {
    // Process group items
    for (var i = 0; i < groupItems.length; i++) {
        var item = groupItems[i],
            type = item.name,
            src  = item.val;

        switch(type) {
            // Sub group calls processGroup recursively, processing the sub files first,
            // then carrys on with other children
            case "group-ref":
                var subGroupName = item.val,
                    subGroup = bundleXML.childWithAttribute("name", subGroupName);

                if (subGroup.children)
                    processGroup(groupName, subGroup.children, jsDestination, cssDestination, index);
                break;

            case "js":
                bundleConfig[index].js.src.push(src);
                break;

            case "css":
                bundleConfig[index].css.src.push(src);
                break;
        }
    }
};

function bundleScript(cfg) {
    return gulp.src(cfg.src)
        .pipe(plumber())
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(concat(cfg.groupName))
        .pipe(rename({ suffix: '.min' }))
        .pipe(uglify())
        .pipe(sourcemaps.write("/"))
        .pipe(gulp.dest(cfg.dest));
};

function bundleStyles(cfg) {
    return gulp.src(cfg.src)
        .pipe(plumber())
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(concat(cfg.groupName))
        .pipe(rename({ suffix: '.min' }))
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(sourcemaps.write("/"))
        .pipe(gulp.dest(cfg.dest))
        .pipe(browserSync.stream())
};


// Gulp tasks
gulp.task('browser-sync', function() {
    browserSync.init(config.syncFiles, { proxy: config.url, });
});

// Bundle css and js according to wro.xml
gulp.task('bundle:all', ['bundle:js','bundle:css']);

gulp.task('bundle:js', function() {
    for (i = 0; i < bundleConfig.length; i++) { 
        bundleScript(bundleConfig[i].js);
    }
});

gulp.task('bundle:css', ['build:sass'], function() {
    for (i = 0; i < bundleConfig.length; i++) { 
        bundleStyles(bundleConfig[i].css);
    }
});

// Acctual building tasks
gulp.task('build:sass', function() {
    return gulp.src(config.styles.input)
     .pipe(plumber())
     .pipe(sourcemaps.init())
     .pipe(sass({
         sourceComments: false
     }).on('error', sass.logError))
     .pipe(sourcemaps.write("/"))
     .pipe(gulp.dest(config.styles.tempOutput))
});

gulp.task('build:css', ['build:sass', 'bundle:css']);

gulp.task('build:img', function() {
    return gulp.src( config.img.input )
        .pipe(imagemin({ progressive: true, svgoPlugins: [{removeViewBox: false}]}))
        .pipe(gulp.dest( config.img.output ))
});

// Fire up the the reloadTask
gulp.task('listen', function() {
    
    browserSync.init(config.syncFiles, { proxy: config.url, });

    gulp.watch(config.js.input).on('change', function() {
        runSequence('bundle:js', function() {
            browserSync.reload();
        });
    });

    gulp.watch(config.styles.filesToListen).on('change', function() {
        runSequence('bundle:css', function() {});
    });
});

gulp.task('move-folders', function() {
    return gulp.src( config.fonts.filesToMove )
        .pipe(gulp.dest( config.fonts.dist ))
});

// Cleaning tasks
gulp.task('clean:css', function() {
    return gulp.src( config.styles.filesToClean )
        .pipe(stripCssComments({ preserve: false }))
        .pipe(cleanCSS({debug: true}, function(details) {
          console.log(details.name + ': ' + details.stats.originalSize);
          console.log(details.name + ': ' + details.stats.minifiedSize);
        }))
        .pipe(gulp.dest( config.styles.output ));
});

gulp.task('clean:js', function() {
    return gulp.src( config.js.filesToClean )
    .pipe(plumber())
    .pipe(uglify())
    .pipe(gulp.dest( config.js.output ));
});

gulp.task('default', [
    'build:sass',
    'bundle:all'
]);

gulp.task('build', [
    'build:sass',
    'bundle:all',
    'build:img',
    'move-folders'
]);

// Tasks to acctually use
gulp.task('watch', [
    'listen',
    'default'
]);

gulp.task('clean', ['clean:css', 'clean:js', 'build:img'], function() {
    del( config.filesToDelete ).then(paths => {
        console.log('Deleted files and folders:\n', paths.join('\n'));
    });
});