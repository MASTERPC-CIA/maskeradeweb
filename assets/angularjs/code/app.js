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
        .when('/hombres', {
            templateUrl: function(params) {
                var url_complete = 'products_menu/load_productos_view/1';
                return url_complete;
            },
            controller: 'CtrlProducts'
        })
        .when('/mujer', {
            templateUrl: function(params) {
                var url_complete = 'products_menu/load_productos_view/2';
                return url_complete;
            },
            controller: 'CtrlProducts'
        })
        .when('/ninio', {
            templateUrl: function(params) {
                var url_complete = 'products_menu/load_productos_view/3';
                return url_complete;
            },
            controller: 'CtrlProducts'
        })
        .when('/ninia', {
            templateUrl: function(params) {
                var url_complete = 'products_menu/load_productos_view/4';
                return url_complete;
            },
            controller: 'CtrlProducts'
        })
        .when('/bebe', {
            templateUrl: function(params) {
                var url_complete = 'products_menu/load_productos_view/5';
                return url_complete;
            },
            controller: 'CtrlProducts'
        })
        .otherwise({redirectTo: '/'});
});