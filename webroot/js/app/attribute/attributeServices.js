(function(define, angular) {
    'use strict';

    define(
            ['ngResource'],
            angular.module('attributeServices', ['ngResource'])
            .factory('attributeService', attributeService)
            );
    /**
     * Serch Service
     */
    attributeService.$inject = ['$resource'];
    function attributeService($resource) {
        return {
            Get: $resource(Milkart.basePath + 'api/1.0/eav/attributes/get.json', {}, {
                query: {method: 'GET'}
            }),
            ById: $resource(Milkart.basePath + 'api/1.0/eav/attributes/get_by_id/:id.json', {id: '@_id'}, {
                query: {method: 'GET'}
            }),
            BySlug: $resource(Milkart.basePath + 'api/1.0/eav/attributes/get_by_slug/:slug.json', {slug: '@_slug'}, {
                query: {method: 'GET'}
            })
        };
    }

})(define, angular);