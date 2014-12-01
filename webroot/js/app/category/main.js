//Module bootstrap Config
require.config({
    baseUrl: Croogo.basePath + 'eav',
    paths: {
        //Angular SRC
        'angular': 'vendors/angularjs/angular.min',
        //Module App
        'categoryApp': 'js/app/category/categoryApp',
        'categoryControllers': 'js/app/category/categoryControllers',
        'categoryServices': 'js/app/category/categoryServices',
        'attributeServices': 'js/app/attribute/attributeServices',
        'coreServices': 'js/app/core/coreServices',
        'angularUiSelect': 'vendors/angularui-select/select.min'
    },
    shim: {
        'angular': {
            exports: 'angular'
        },
        'angularUiSelect': {
            deps: ['angular']
        },
        'categoryApp': {
            deps: ['angular', 'angularUiSelect']
        }
    }
});

//Module Bootstrap
require(['categoryApp'], function() {
    angular.element(document).ready(function() {
        angular.bootstrap(angular.element('#category-form-app'), ['categoryApp', 'ui.select', 'categoryControllers', 'categoryServices', 'attributeServices', 'coreServices']);
    });
});