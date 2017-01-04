function testimonialService($resource) {
    return $resource('/api/posts/:id',{id: '@id'},
        { query: {method:'GET', isArray:false}, get: {method: "GET"}, destroy: { method: "DELETE" }, update: { method: "PUT" } }
    );

}

testimonialService.$inject = ['$resource'];

angular
    .module('copya')
    .factory('testimonialService', testimonialService);
