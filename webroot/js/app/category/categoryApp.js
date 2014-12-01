(function(define, angular) {
    'use strict';
    //define dependencies to requireJs
    define(
            [
                //App 
                'coreServices',
                'categoryControllers',
                'categoryServices',
                'attributeServices'
            ],
            angular.module('categoryApp',
                    [
                        //App
                        'coreServices',
                        'categoryControllers',
                        'categoryServices',
                        'attributeServices'
                    ])
            );


})(define, angular);
