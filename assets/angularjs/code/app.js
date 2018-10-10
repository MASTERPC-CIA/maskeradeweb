var app = angular.module('appMaskerade', ['ngLoadingSpinner', 'angularUtils.directives.dirPagination', 'ngRoute', 'ui.bootstrap', 'toaster']);

app.config(function ($routeProvider) {
    $routeProvider
        .when('/', {
            templateUrl: 'Main/load_main',
            controller: 'CtrlMain'
        })
        .when('/servicios', {
            templateUrl: 'Main/load_view_servicios',
        })
        .when('/contactos', {
            templateUrl: 'Main/load_view_contactos',
        })
        .when('/hombres/', {
            templateUrl: function(params) {
                params.tipo = 1;
                var url_complete = 'Menu/load_productos_view/'+params.tipo;
                return url_complete;
            },
            controller: 'CtrlProducts'
        })
        .when('/mujer', {
            templateUrl: function(params) {
                params.tipo = 2;
                var url_complete = 'Menu/load_productos_view/'+params.tipo;
                return url_complete;
            },
            controller: 'CtrlProducts'
        })
        .when('/ninio', {
            templateUrl: function(params) {
                params.tipo = 3;
                var url_complete = 'Menu/load_productos_view/'+params.tipo;
                return url_complete;
            },
            controller: 'CtrlProducts'
        })
        .when('/ninia', {
            templateUrl: function(params) {
                params.tipo = 4;
                var url_complete = 'Menu/load_productos_view/'+params.tipo;
                return url_complete;
            },
            controller: 'CtrlProducts'
        })
        .when('/bebe', {
            templateUrl: function(params) {
                params.tipo = 5;
                var url_complete = 'Menu/load_productos_view/'+params.tipo;
                return url_complete;
            },
            controller: 'CtrlProducts'
        })
        .otherwise({redirectTo: '/'});
});