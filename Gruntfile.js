module.exports = function (grunt) {
    "use strict";

    grunt.initConfig({
        pkg: grunt.file.readJSON("package.json"),
        copy: {
            main: {
                files: [
                    {
                        dest: 'public/img/avatars/',
                        expand: true,
                        filter: 'isFile',
                        flatten: true,
                        src: ['assets/images/avatars/*']
                    },
                ],
            },
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
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('default', ['sass', 'copy']);
};
