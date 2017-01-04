

function testimonialRoutes($stateProvider, $urlRouterProvider, $httpProvider) {
    //$http.defaults.headers.get['X-CSRFToken'] = Laravel.csrfToken;

    $stateProvider
        .state('testimonials.base', {
            abstract: true,
            url: '/',
            templateUrl: "js/copya/tpl/app.html",
        })
        .state('testimonials', {
            url: "testimonials",
            templateUrl: "js/copya/tpl/testimonials.index.html",
            controller: 'TestimonialCtrl',
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load([
                        ], {
                            insertBefore: '#lazyload_placeholder'
                        })
                        .then(function() {
                            return $ocLazyLoad.load([
                                'js/copya/controllers/testimonials.js'
                            ]);
                        });
                }]
            }
        });
}

testimonialRoutes.$inject = ['$stateProvider', '$urlRouterProvider', '$httpProvider'];
//
angular.module('copya')
    .config(testimonialRoutes);