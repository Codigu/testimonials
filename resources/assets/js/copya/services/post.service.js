function postService($resource) {
    return $resource('/api/posts/:id',{id: '@id'},
        { query: {method:'GET', isArray:false}, get: {method: "GET"}, destroy: { method: "DELETE" }, update: { method: "PUT" } }
    );

}

postService.$inject = ['$resource'];

angular
    .module('copya')
    .factory('postService', postService);
