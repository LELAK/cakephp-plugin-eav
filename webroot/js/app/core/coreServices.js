(function(define, angular) {
    'use strict';

    define([],
            angular.module('coreServices', [])
            .factory('HttpService', HttpService)
            );

    /**
     * Flash Service for request flags
     */
    HttpService.$inject = ['$rootScope'];
    function HttpService($rootScope) {

        return{
            get: get
        };

        function get(path, params) {
            return $http.get(path, {params: params})
                    .then(getCompleted)
                    .catch(getFailed);

            function getCompleted(response) {
                return response.data;
            }
            function getFailed(error) {
                console.log('XHR failed for products by global:' + error);
            }
        }

    }
})(define, angular);