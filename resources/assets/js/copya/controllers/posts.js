Dropzone.autoDiscover = false;

'use strict';

function PostCtrl($scope, $sce, $rootScope, $state, $stateParams, postService, $timeout) {
    $scope.posts = [];
    $scope.post = {};
    $scope.dzCallbacks = {};
    $scope.myDz = null;
    $scope.dzMethods = {};

    if($state.is('posts.index')){
        postService.query({}, function(result){
            $scope.posts = result.data;
            console.log(result.data);
        }, function(err){

        });
    } else if($state.is('posts.edit')){
        postService.query({id: $stateParams.id}, function(result){
            $scope.post = result.data;
            //var drop_zone = Dropzone.forElement('#featured_image');
            if(result.data.featured_image != '') {
                $scope.mockFiles = [
                    {
                        name: 'mock_file_1',
                        serverImgUrl: $scope.post.featured_image,
                        size: 12345,
                        accepted: true,
                        isMock: true,
                        path: result.data.image_path
                    }
                ];

                $timeout(function () {

                    // get dropzone instance to emit some events
                    $scope.myDz = $scope.dzMethods.getDropzone();
                    // emit `addedfile` event with mock files
                    // emit `complete` event for mockfile as they are already uploaded
                    // decrease `maxFiles` count by one as we keep adding mock file
                    // push mock file dropzone
                    $scope.mockFiles.forEach(function (mockFile) {
                        $scope.myDz.emit('addedfile', mockFile);
                        $scope.myDz.emit('complete', mockFile);
                        //$scope.myDz.options.maxFiles = $scope.myDz.options.maxFiles - 1;
                        $scope.myDz.files.push(mockFile);
                    });

                });
            }
        }, function(err){

        });

    } else if($state.is('posts.add')){

        $timeout(function () {
            console.log('post add 2');
            // get dropzone instance to emit some events
            //$scope.myDz = $scope.dzMethods.getDropzone();
        });
    }

    $scope.submitPostForm = function(isValid) {
        // check to make sure the form is completely valid
        console.log(isValid);
        if (isValid) {
            if($scope.post.id){
                postService.update({id: $scope.post.id}, $scope.post, function (result) {
                    $state.go('posts.index');
                }, function (err) {
                    console.log(err);
                });
            } else {
                postService.save({}, $scope.post, function (result) {
                    $scope.posts.push(result.data);
                    $scope.posts = {};
                    $scope.post_.$setUntouched();
                    $scope.post_.$setPristine();
                    $state.go('posts.index');
                }, function (err) {
                    console.log(err);
                });
            }
        }
    };

    $scope.dzOptions = {
        maxFileSize: 30,
        maxFiles: 1,
        url: '/api/files',
        maxfilesexceeded: function(file) {
            this.removeAllFiles();
            this.addFile(file);
        },
        headers: {
            'X-CSRF-TOKEN': Laravel.csrfToken
        },
    };

    $scope.dzCallbacks = {
        'success': function(file, response){
            $scope.post.featured_image = response.data.file;
        },
        'addedfile' : function(file){
            // If added file is a mock file
            // create thumbnail from url provided by server in mock file array
            console.log('added');
            if(file.isMock){
                $scope.myDz.createThumbnailFromUrl(file, file.serverImgUrl, null, true);
                $scope.post.featured_image = file.path;
            }
        },

    };

    $scope.addNewPost = function(){
        $state.go('posts.add');
    };

    $scope.editCategory = function(category){
        $scope.category = category;
        $scope.toggleSlideUpSize();
    };

    $scope.editPost = function(post){
        $state.go('posts.edit', {id: post.id});
    };

    $scope.trashPost = function(post){
        if(confirm('Are you sure you want to trash this Post?')){
            postService.delete({id: post.id}, function(result){
                $scope.post = result.data;
            }, function(err){

            });
        }
    };

    $scope.restorePost = function(post){
        if(confirm("Are you sure you want to restore this post?")){
            postService.update({id: post.id}, {action: 'restore'}, function(result){
                $scope.post = result.data;
            }, function(err){

            });
        }
    };

    $scope.deletePost = function(post){
        if(confirm('Are you sure you want to permanently delete this page?')){
            postService.delete({id: post.id}, function(result){
                $state.go('posts.index');
            }, function(err){

            });
        }
    };

}

PostCtrl.$inject = ['$scope', '$sce', '$rootScope', '$state', '$stateParams', 'postService', '$timeout'];

angular.module('copya', ['ui.tree', 'thatisuday.dropzone'])
    .controller('PostCtrl', PostCtrl);


