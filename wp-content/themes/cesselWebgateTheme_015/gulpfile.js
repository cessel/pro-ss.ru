var gulp        = require("gulp"),
    sass        = require("gulp-sass"),
    compass     = require('gulp-compass'),
    concat      = require('gulp-concat'),
    uglify      = require('gulp-uglifyjs'),
    cssnano     = require('gulp-cssnano'),
    rename      = require('gulp-rename'),
    imgmin      = require('gulp-imagemin'),
    pngq        = require('imagemin-pngquant'),
    autopref    = require('gulp-autoprefixer'),
    plumber    = require('gulp-plumber'),
    cache        = require('gulp-cache');


gulp.task("sass",function(done)

    {
        return gulp.src('sass/**/*.+(sass|scss)')
            .pipe(compass({
                config_file: __dirname + '/config/compass.rb',
                sass: 'sass',
                css:'css'
            })).on('error', function(error) {
                // у нас ошибка
                done("ОШИБКА1" + error);
            })
            .pipe(autopref(['last 15 versions','> 1%', 'ie 8', 'ie 7'],{'cascade':true})).on('error', function(error) {
                // у нас ошибка
                done("ОШИБКА2" + error);
            })
            .pipe(gulp.dest('css'));
    });

gulp.task('css-libs',['sass'],function()
{
    return gulp.src(
        [
            'css/*.css',
            'lib/owl.carousel/dist/assets/owl.carousel.min.css',
            'lib/bootstrap/dist/css/bootstrap.min.css'
        ])
        .pipe(concat('libs.min.css'))
        .pipe(gulp.dest('css/lib/'));
});
gulp.task('scripts',function()
{
    return gulp.src(
        [
            'lib/jquery/dist/jquery.js',
            'lib/jquery-migrate/jquery-migrate.min.js',
            "lib/popper.js/dist/umd/popper.min.js",
            'lib/bootstrap/dist/js/bootstrap.min.js',
            'lib/owl.carousel/dist/owl.carousel.min.js'
        ])
        .pipe(concat('libs.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('js/lib/'));
});

gulp.task('css-libs:nano',['sass'],function()
{
    return gulp.src(
        [
        'css/*.css'
        ])
        .pipe(cssnano())
        .pipe(rename({suffix:'.min'}))
        .pipe(concat('styles.min.css'))
        .pipe(gulp.dest('css'));
});

gulp.task('img',function()
    {
       return gulp.src
        (
            'img/**/*.*'
        )
           .pipe(cache(imgmin(
               {
                   interlaces:true
                   ,progressive:true
                   ,svgoPlugins:[{removeViewBox:false}]
                   ,use:[pngq()]
               }
           )))
           .pipe(gulp.dest('img'));
    });

gulp.task('default',['sass'],function()
    {
        gulp.watch('sass/**/*.+(sass|scss)',['sass']);
    });
gulp.task('prepare-scripts',['scripts','css-libs:nano'],function()
    {

    });