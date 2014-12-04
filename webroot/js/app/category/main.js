// Module bootstrap Config
require.config({
    baseUrl: Croogo.basePath + 'eav',
    waitSeconds: 0,
    paths: {
        // Angular
        'angular': 'vendors/angularjs/angular.min',
        'ngResource': 'vendors/angularjs/angular-resource.min',
        // Dependencies
        'attributeServices': 'js/app/attribute/attributeServices',
        // App
        'categoryApp': 'js/app/category/categoryApp',
        'categoryControllers': 'js/app/category/categoryControllers',
        'categoryServices': 'js/app/category/categoryServices',
        // Vendors
        'ui.select': 'vendors/angularui-select/select.min'
    },
    shim: {
        'angular': {
            exports: 'angular'
        },
        'ngResource': {
            deps: ['angular']
        },
        'ui.select': {
            deps: ['angular']
        },
        'categoryApp': {
            deps: ['angular', 'ui.select']
        }
    }
});

//Module Bootstrap
require(['categoryApp'], function() {
    angular.element(document).ready(function() {
        angular.bootstrap(angular.element('#category-form-app'), ['categoryApp']);
    });
});