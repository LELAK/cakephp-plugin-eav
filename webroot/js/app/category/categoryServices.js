(function(define, angular) {
    'use strict';

    define(
            [],
            angular.module('categoryServices', [])
            .factory('categoryService', categoryService)
            );
    /**
     * Serch Service
     */
    categoryService.$inject = ['$http'];
    function categoryService($http) {

        var vm = this;

        vm.paths = {
            categoryBySlug: Croogo.basePath + 'admin/eav/categories/get.json',
            categoryById: Croogo.basePath + 'admin/eav/categories/get.json',
            getCategoryAttributesByCategoryId: Croogo.basePath + 'admin/eav/categories/attributes.json'
        };

        return {
            getCategoryBySlug: getCategoryBySlug,
            getCategoryById: getCategoryById,
            getCategoryAttributesByCategoryId: getCategoryAttributesByCategoryId
        };

        /**
         * Get a category by slug
         * 
         * @param string Slug
         * @returns JSON The category
         */
        function getCategoryBySlug(slug) {
            return get(vm.paths.categoryBySlug, {slug: slug});
        }

        function getCategoryAttributesByCategoryId(id) {
            return get(vm.paths.getCategoryAttributesByCategoryId, {category_id: id});
        }

        /**
         * Get a category by id
         * 
         * @param string Slug
         * @returns JSON The category
         */
        function getCategoryById(id) {
            return get(vm.paths.categoryById, {id: id});
        }

        function get(path, params) {
//            $scope.is_load = true;
            return $http.get(path, {params: params})
                    .then(getCompleted)
                    .catch(getFailed);

            function getCompleted(response) {
//                $scope.is_load = false;
                return response.data;
            }
            function getFailed(error) {
//                $scope.is_load = false;
                console.log('XHR failed for products by global:' + error);
            }
        }
    }

})(define, angular);