module.exports = function (grunt) {
    "use strict";

    grunt.initConfig({
        pkg: grunt.file.readJSON("package.json"),
        copy: {
            main: {
                files: [
                    {
                        dest: 'public/fonts/',
                        expand: true,
                        filter: 'isFile',
                        flatten: true,
                        src: ['public/vendor/zource-zui/dist/fonts/*']
                    },
                    {
                        dest: 'public/img/avatars/',
                        expand: true,
                        filter: 'isFile',
                        flatten: true,
                        src: ['assets/images/avatars/*']
                    }
                ]
            }
        },
        sass: {
            dist: {
                options: {
                    style: 'expanded',
                    loadPath: [
                        'public/vendor/zource-zui/scss'
                    ]
                },
                files: {
                    'public/css/zource.css': 'assets/scss/zource.scss'
                }
            }
        },
        uglify: {
            dist: {
                files: {
                    "public/js/zource.min.js": ["assets/js/zource.js"]
                },
                options: {
                    preserveComments: false,
                    sourceMap: false,
                    sourceMapName: "public/js/zource.min.js.map",
                    report: "min",
                    beautify: {
                        "ascii_only": true
                    },
                    banner: "/*! Zource v<%= pkg.version %> | " +
                    "(c) Zource | github.com/zource/zource */",
                    compress: {
                        "hoist_funs": false,
                        loops: false,
                        unused: false
                    }
                }
            }
        },
        watch: {
            sass: {
                files: ["scss/**/*.scss"],
                tasks: ['sass'],
                options: {
                    livereload: true
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('default', ['sass', 'copy', 'uglify']);
};
