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
            Get: $resource(Croogo.basePath + 'admin/eav/attributes/get.json', {}, {
                query: {method: 'GET'}
            }),
            ById: $resource(Croogo.basePath + 'admin/eav/attributes/get/id/:id.json', {id: '@_id'}, {
                query: {method: 'GET'}
            }),
            BySlug: $resource(Croogo.basePath + 'admin/eav/attributes/get/slug/:slug.json', {slug: '@_slug'}, {
                query: {method: 'GET'}
            })
        };
    }

})(define, angular);