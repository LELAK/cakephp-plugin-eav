(function(define, angular) {
    'use strict';

    define(
            [],
            angular.module('attributeServices', [])
            .factory('attributeService', attributeService)
            );
    /**
     * Serch Service
     */
    attributeService.$inject = ['$http'];
    function attributeService($http) {

        var vm = this;

        vm.paths = {
            attributeBySlug: Croogo.basePath + 'admin/eav/attributes/get.json',
            attributeById: Croogo.basePath + 'admin/eav/attributes/get.json',
            attributes: Croogo.basePath + 'admin/eav/attributes/get.json'
        };

        return {
            getAttributeBySlug: getAttributeBySlug,
            getAttributeById: getAttributeBySlug,
            getAttributeList: getAttributeList
        };

        /**
         * Get a attribute by slug
         * 
         * @param string Slug
         * @returns JSON The attribute
         */
        function getAttributeBySlug(slug) {
            return get(vm.paths.attributeBySlug, {slug: slug});
        }

        /**
         * Get a attribute by id
         * 
         * @param string Slug
         * @returns JSON The attribute
         */
        function getAttributeById(id) {
            return get(vm.paths.attributeById, {id: id});
        }

        function getAttributeList() {
            return get(vm.paths.attributes, {});
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