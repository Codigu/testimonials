'use strict';

function TestimonialCtrl($scope, $sce, $state, $stateParams, testimonialService) {
    $scope.testimonials = [];
    $scope.testimonial = {};

    $scope.toggleSlideUpSize = function() {
        var modalElem = $('#modalSlideUp');
        $('#modalSlideUp').modal('show');
        modalElem.children('.modal-dialog').removeClass('modal-lg');
    };

    $scope.deleteCategory = function(category){
        if(confirm("Are you sure you want to delete this Category?")){
            categoryService.delete({id: category.id}, function(result){
                alert('Category delete successfully!');
                var itemIndex = $scope.categories.indexOf(category);
                $scope.categories.splice(itemIndex, 1);

            }, function(err){

            });
        }
    };

    $scope.submitCategoryForm = function(isValid) {
        // check to make sure the form is completely valid
        if (isValid) {
            if($scope.category.id){
                categoryService.update({id: $scope.category.id}, $scope.category, function (result) {
                    $('#modalSlideUp').modal('hide');
                    /*var itemIndex = $scope.menus.indexOf($scope.selectedMenu[index]);
                     $scope.menus.splice(itemIndex, 1);*/
                    $scope.category = {};
                    $scope.category_.$setUntouched();
                    $scope.category_.$setPristine();
                }, function (err) {
                    console.log(err);
                });
            } else {
                categoryService.save({}, $scope.category, function (result) {
                    $('#modalSlideUp').modal('hide');
                    $scope.categories.push(result.data);
                    $scope.category = {};
                    $scope.category_.$setUntouched();
                    $scope.category_.$setPristine();
                }, function (err) {
                    console.log(err);
                });
            }
        }
    };

    $scope.editCategory = function(category){
        $scope.category = category;
        $scope.toggleSlideUpSize();
    };

    if($state.is('categories.index')){
        categoryService.query({}, function(result){
            $scope.categories = result.data;
            console.log(result.data);
        }, function(err){

        });
    }

}

TestimonialCtrl.$inject = ['$scope', '$sce', '$state', '$stateParams', 'testimonialService'];

angular.module('copya')
    // Chart controller
    .controller('TestimonialCtrl', TestimonialCtrl);


