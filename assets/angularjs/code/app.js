var app = angular.module('appMaskerade', ['ngLoadingSpinner', 'angularUtils.directives.dirPagination', 'ngRoute', 'ui.bootstrap', 'toaster']);

app.config(function ($routeProvider) {
    $routeProvider
        .when('/', {
            templateUrl: 'Main/load_main',
            controller: 'CtrlMain'
        })
        .when('/hombres', {
            templateUrl: 'products_menu/load_productos_view',
            controller: 'CtrlHombres'
        })
        .when('/mujer', {
            templateUrl: 'products_menu/load_productos_view',
            controller: 'CtrlMujer'
        })
        .when('/ninio', {
            templateUrl: 'products_menu/load_productos_view',
            controller: 'CtrlNinio'
        })
        .when('/ninia', {
            templateUrl: 'products_menu/load_productos_view',
            controller: 'CtrlNinia'
        })
        .when('/bebe', {
            templateUrl: 'products_menu/load_productos_view',
            controller: 'CtrlBebe'
        })
        .otherwise({redirectTo: '/'});
});