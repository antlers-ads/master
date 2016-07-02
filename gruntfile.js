module.exports = function (grunt) {
    //noinspection JSUnresolvedFunction
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        concat: {
            options: {
                stripBanners: true
            },
            css: {
                src: [
                    'node_modules/bootstrap/dist/css/bootstrap.min.css',
                    'node_modules/bootstrap/dist/css/bootstrap-theme.min.css',
                    'web/assets/css/app.css'
                ],
                dest: 'web/assets/app.all.css'
            },
            js: {
                src: [
                    'node_modules/jquery/dist/jquery.min.js',
                    'node_modules/bootstrap/dist/js/bootstrap.min.js',
                    'web/assets/js/app.js'
                ],
                dest: 'web/assets/app.all.js'
            }
        },
        cssmin: {
            target: {
                files: {
                    'web/assets/app.min.css': ['web/assets/app.all.css']
                }
            }
        },
        uglify: {
            build: {
                src: 'web/assets/app.all.js',
                dest: 'web/assets/app.min.js'
            }
        },
        "regex-replace": {
            glyphicons: {
                src: ['web/assets/app.all.css', 'web/assets/app.min.css'],
                actions: [
                    {
                        name: 'glyphicons',
                        search: '\.\.\/fonts\/',
                        replace: 'fonts/',
                        flags: 'gm'
                    }
                ]
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-regex-replace');

    grunt.registerTask('default', ['concat', 'cssmin', 'uglify', 'regex-replace']);
};
