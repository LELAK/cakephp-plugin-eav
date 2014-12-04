(function(define, angular) {
    'use strict';
    //define dependencies to requireJs
    define(
            [
                // Dependencies
                'attributeServices',
                // App 
                'categoryControllers',
                'categoryServices',
                // Vendors
                'ui.select'
            ],
            angular.module('categoryApp',
                    [
                        // Dependencies
                        'attributeServices',
                        // App
                        'categoryControllers',
                        'categoryServices',
                        // Vendors
                        'ui.select'
                    ]));
})(define, angular);
