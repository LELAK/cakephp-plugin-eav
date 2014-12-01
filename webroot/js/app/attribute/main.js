//Module bootstrap Config
require.config({
    baseUrl: Croogo.basePath + 'eav',
    paths: {
        //Angular SRC
        'angular': 'vendors/angularjs/angular.min',
        //Module App
        'attributeApp': 'js/app/attribute/attributeApp',
        'attributeControllers': 'js/app/attribute/attributeControllers',
        'attributeServices': 'js/app/attribute/attributeServices',
        'coreServices': 'js/app/core/coreServices'
    },
    shim: {
        'angular': {
            exports: 'angular'
        },
        'attributeApp': {
            deps: ['angular']
        }
    }
});

//Module Bootstrap
require(['attributeApp'], function() {
    angular.element(document).ready(function() {
        angular.bootstrap(angular.element('#attribute-form-app'), ['attributeApp', 'attributeControllers', 'attributeServices', 'coreServices']);
    });
});