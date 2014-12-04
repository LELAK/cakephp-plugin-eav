(function(define, angular) {
    'use strict';
    define(
            [],
            angular.module('categoryControllers', [])
            .controller('CategoryAttributesFormController', CategoryAttributesFormController)
            .controller('CategoryFormController', CategoryFormController)
            );
    /**
     * Category Tab Controller
     */
    CategoryFormController.$inject = ['$scope', '$rootScope', 'categoryService'];
    function CategoryFormController($scope, $rootScope, categoryService) {

        var vm = this;
        vm.categoryId = Croogo.pass[0];
        vm.possibleParentCategories = [];

        $scope.is_load = false;

        getCategoryById();

        vm.changeSelected = function() {
            $rootScope.$emit('parentCategorySelected', vm.current.parent_id !== null ? vm.current.parent_id : '');
        };

        function getPossibleParents() {
            if (Croogo.params.action === 'admin_add') {
                categoryService.List.query()
                        .$promise.then(function(response) {
                            for (var key in response.data) {
                                vm.possibleParentCategories.push({id: response.data[key].EavCategory.id, title: response.data[key].EavCategory.title});
                            }
                        });
            } else {
                categoryService.NonChildById.query({id: vm.categoryId})
                        .$promise.then(function(response) {
                            for (var key in response.data) {
                                vm.possibleParentCategories.push({id: response.data[key].EavCategory.id, title: response.data[key].EavCategory.title});
                            }
                        });
            }
        }

        function getCategoryById() {
            categoryService.ById.query({id: vm.categoryId})
                    .$promise.then(function(response) {
                        vm.current = response.data.EavCategory;
                        getPossibleParents();
                    });
        }

    }

    /**
     * CategoryAttributes Tab Controller
     */
    CategoryAttributesFormController.$inject = ['attributeService', '$scope', '$rootScope', 'categoryService'];
    function CategoryAttributesFormController(attributeService, $scope, $rootScope, categoryService) {

        var vm = this;
        $scope.is_load = false;
        vm.categoryId = Croogo.pass[0];

        vm.categoryAttributes = [];
        vm.categoryInheritedAttributes = [];
        vm.globalAttributes = [];

        resetAttributeSearch();
        sync();
        // RootScope functions
        $rootScope.$on('parentCategorySelected', function(event, selectedId) {
            syncFutureParentInheritance(selectedId);
        });
        // View Model functions
        vm.remove = function(attribute) {
            if (vm.categoryAttributes.indexOf(attribute) > -1) {
                vm.categoryAttributes.splice(vm.categoryAttributes.indexOf(attribute), 1);
                addToGlobal(attribute);
                resetAttributeSearch();
            }
        };
        vm.add = function(attribute) {
            if (attribute !== undefined && vm.categoryAttributes.indexOf(attribute) < 0) {
                vm.categoryAttributes.push(attribute);
                removeFromGlobal(attribute);
                resetAttributeSearch();
            }
        };
        // Controller functions
        function sync() {
            if (Croogo.params.action === 'admin_add') {
                getGlobalAttributes();
            } else {
                syncAttributes(vm.categoryId);
                getAvailableAttributes(vm.categoryId);
                syncInheritedAttributes(vm.categoryId);
            }
        }

        function syncFutureParentInheritance(id) {
            if (id.length) {
                getAvailableAttributes(id);
                categoryService.Attributes.query({id: id})
                        .$promise.then(function(response) {
                            vm.categoryInheritedAttributes = response.data;
                            for (var key in vm.categoryInheritedAttributes) {
                                vm.categoryAttributes.splice(vm.categoryAttributes.indexOf(vm.categoryInheritedAttributes[key]));
                            }
                        });
            } else {
                getGlobalAttributes();
                vm.categoryInheritedAttributes = [];
            }
        }

        function resetAttributeSearch() {
            $scope.attribute = {};
            $scope.attribute.selected = undefined;
            $scope.attributeSearch = undefined;
        }

        function syncInheritedAttributes(id) {
            categoryService.AttributesInherited.query({id: id})
                    .$promise.then(function(response) {
                        vm.categoryInheritedAttributes = response.data;
                    });
        }

        function syncAttributes(id) {
            categoryService.AttributesOwn.query({id: id})
                    .$promise.then(function(response) {
                        vm.categoryAttributes = response.data;
                    });
        }

        function removeFromGlobal(attribute) {
            vm.globalAttributes.splice(vm.globalAttributes.indexOf(attribute), 1);
        }

        function addToGlobal(attribute) {
            vm.globalAttributes.push(attribute);
        }

        function getGlobalAttributes() {
            attributeService.Get.query()
                    .$promise.then(function(response) {
                        vm.globalAttributes = response.data;
                    });
        }

        function getAvailableAttributes(id) {
            categoryService.AttributesAvailable.query({id: id})
                    .$promise.then(function(response) {
                        vm.globalAttributes = response.data;
                    });
        }

    }

})(define, angular);
