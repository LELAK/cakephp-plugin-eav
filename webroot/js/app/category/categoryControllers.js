(function(define, angular) {
    'use strict';

    define(
            [],
            angular.module('categoryControllers', [])
            .controller('CategoryFormController', CategoryFormController)
            );

    /**
     * Search Main Controlller
     */
    CategoryFormController.$inject = ['categoryService', 'attributeService', '$scope'];
    function CategoryFormController(categoryService, attributeService, $scope) {

        var vm = this;

        $scope.is_load = true;

        $scope.attribute = {};
        $scope.attribute.selected = undefined;
        $scope.attributeSearch = undefined;

        vm.remove = function(index) {
            vm.categoryAttributes.splice(index, 1);
        };

        vm.add = function(attribute) {
            vm.categoryAttributes.push(attribute.EavAttribute);
        };

        vm.categoryAttributes = [];
        vm.globalAttributes = [];

        vm.syncAttributes = function(id) {
            $scope.is_load = true;
            categoryService.getCategoryAttributesByCategoryId(id).then(function(response) {
                vm.categoryAttributes = response.data;
                $scope.is_load = false;
            });
        };

        vm.getGlobalAttributes = function() {
            $scope.is_load = true;
            attributeService.getAttributeList().then(function(response) {
                vm.globalAttributes = response.data;
                $scope.is_load = false;
            });
        };

        vm.getGlobalAttributes();

    }

})(define, angular);
