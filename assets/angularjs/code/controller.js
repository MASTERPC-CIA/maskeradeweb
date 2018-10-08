app.controller('CtrlMain', function($scope, $filter, $location, $http) {
    
});

app.controller('CtrlProducts', function($scope, $filter, $location, $http, $routeParams) {
	$scope.productos = [];
    $scope.totalProductos = 0;
    $scope.productosPerPage = 12;
    get_data();
    getResultsPage(1);

    $scope.pagination = {
        current: 1
    };

    $scope.pageChanged = function(newPage) {
        getResultsPage(newPage);
    };

    function get_data() {
        $http.post('products_menu/get_all_productos', {'tipo':$routeParams.tipo}).then(function(result) {
            $scope.totalProductos = result.data.product_count;
            $scope.temas = result.data.temas;
            $scope.marcas = result.data.marcas;
            $scope.tallas = result.data.tallas;
        });
    }

    function getResultsPage(pageNumber) {
        let send = {
            'tipo':$routeParams.tipo,
            'pageNumber':pageNumber, 
            'productosPerPage':$scope.productosPerPage
        };
        $http.post('products_menu/get_productos_x_tipo', send).then(function(result) {
            $scope.totalProductos = result.data.product_count;
            $scope.productos = result.data.productos;
        });
    }

    $scope.buscar = function(cadena) {
        var send = {
            'tipo':$routeParams.tipo,
            'pageNumber':1, 
            'productosPerPage':$scope.productosPerPage,
            'cadena':cadena
        };
        $http.post('products_menu/get_productos_x_tipo', send).then(function(result) {
            $scope.totalProductos = result.data.product_count;
            $scope.productos = result.data.productos;
            $scope.cadena = '';
        });
    };
});