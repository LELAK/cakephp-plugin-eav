(function(define, angular) {
    'use strict';

    define(
            ['ngResource'],
            angular.module('categoryServices', ['ngResource'])
            .factory('categoryService', categoryService)
            );
    /**
     * Serch Service
     */
    categoryService.$inject = ['$resource'];
    function categoryService($resource) {
        return {
            AttributesInherited: $resource(Croogo.basePath + 'api/1.0/eav/categories/get_attributes_inherited/:id.json', {id: '@_id'}, {
                query: {method: 'GET'}
            }),
            Attributes: $resource(Croogo.basePath + 'api/1.0/eav/categories/get_attributes/:id.json', {id: '@_id'}, {
                query: {method: 'GET'}
            }),
            AttributesOwn: $resource(Croogo.basePath + 'api/1.0/eav/categories/get_attributes_own/:id.json', {id: '@_id'}, {
                query: {method: 'GET'}
            }),
            AttributesAvailable: $resource(Croogo.basePath + 'api/1.0/eav/categories/get_attributes_available/:id.json', {id: '@_id'}, {
                query: {method: 'GET'}
            }),
            NonChildById: $resource(Croogo.basePath + 'api/1.0/eav/categories/get_non_child/:id.json', {id: '@_id'}, {
                query: {method: 'GET'}
            }),
            ById: $resource(Croogo.basePath + 'api/1.0/eav/categories/get_by_id/:id.json', {id: '@_id'}, {
                query: {method: 'GET'}
            }),
            BySlug: $resource(Croogo.basePath + 'api/1.0/eav/categories/get_by_slug/:slug.json', {slug: '@_slug'}, {
                query: {method: 'GET'}
            }),
            List: $resource(Croogo.basePath + 'api/1.0/eav/categories/get.json', {}, {
                query: {method: 'GET'}
            })
        };
    }

})(define, angular);