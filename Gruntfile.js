module.exports = function(grunt) {
    "use strict";

    grunt.initConfig({
        pkg: grunt.file.readJSON("package.json"),
        sass: {
            dist: {
                options: {
                    style: 'expanded',
                    loadPath: [
                        'public/vendor/zource-zui/scss'
                    ]
                },
                files: {
                    'public/css/zource.css': 'scss/zource.scss'
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

    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('default', ['sass']);
};
