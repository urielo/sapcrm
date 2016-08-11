module.exports = function(grunt) {
    grunt.initConfig({

        less: {
            development: {
                options: {
                    paths: ["public/themes/default/assets/css/"]
                },
                files: {"public/themes/default/assets/css/datepicker.css": "public/themes/default/assets/less/datepicker.less"}
            },
            production: {
                options: {
                    paths: ["public/themes/default/assets/css/"],
                    cleancss: true
                },
                files: {"public/themes/default/assets/css/datepicker.css": "public/themes/default/assets/less/datepicker.less"}
            }
        }
    });
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.registerTask('default', ['less']);
};