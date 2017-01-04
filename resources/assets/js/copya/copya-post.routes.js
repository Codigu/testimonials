

function postRoutes($stateProvider, $urlRouterProvider, $httpProvider) {
    //$http.defaults.headers.get['X-CSRFToken'] = Laravel.csrfToken;

    $stateProvider
        .state('posts', {
            abstract: true,
            url: '/posts',
            templateUrl: "js/copya/tpl/app.html",
        })
        .state('posts.index', {
            url: "/index",
            templateUrl: "js/copya/tpl/posts.index.html",
            controller: 'PostCtrl',
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load([
                            'ngdropzone',
                        ], {
                            insertBefore: '#lazyload_placeholder'
                        })
                        .then(function() {
                            return $ocLazyLoad.load([
                                'js/copya/controllers/posts.js'
                            ]);
                        });
                }]
            }
        })
        .state('posts.add', {
            url: "/add",
            templateUrl: "js/copya/tpl/posts.form.html",
            controller: 'PostCtrl',
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load([
                            'ngdropzone',
                            'summernote',
                            'typehead'
                        ], {
                            insertBefore: '#lazyload_placeholder'
                        })
                        .then(function() {
                            return $ocLazyLoad.load([
                                'js/copya/controllers/posts.js'
                            ]);
                        });
                }]
            }
        })
        .state('posts.edit', {
            url: "/edit/:id",
            templateUrl: "js/copya/tpl/posts.form.html",
            controller: 'PostCtrl',
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load([
                            'ngdropzone',
                            'summernote',
                            'typehead'
                        ], {
                            insertBefore: '#lazyload_placeholder'
                        })
                        .then(function() {
                            return $ocLazyLoad.load([
                                'js/copya/controllers/posts.js'
                            ]);
                        });
                }]
            }
        });

}

postRoutes.$inject = ['$stateProvider', '$urlRouterProvider', '$httpProvider'];
//
angular.module('copya')
    .config(postRoutes);