(function(define, angular) {
    'use strict';
    //define dependencies to requireJs
    define(
            [
                //App 
                'attributeControllers',
                'attributeServices',
                'coreServices'
            ],
            angular.module('attributeApp',
                    [
                        //App
                        'attributeControllers',
                        'attributeServices',
                        'coreServices'
                    ])
            );


})(define, angular);
