app.controller('CtrlMain', function($scope, $filter, $location, $http, $routeParams) {
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
        $http.post('Menu/get_all_productos', {'tipo':$routeParams.tipo}).then(function(result) {
            $scope.totalProductos = result.data.product_count;
            $scope.festividades = result.data.festividades;
            $scope.marcas = result.data.marcas;
            $scope.tallas = result.data.tallas;
        });
    }

    function getResultsPage(pageNumber) {
        var send = {
            'tipo':$routeParams.tipo,
            'pageNumber':pageNumber, 
            'productosPerPage':$scope.productosPerPage
        };
        $http.post('Menu/get_productos_x_tipo', send).then(function(result) {
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
        $http.post('Menu/get_productos_x_tipo', send).then(function(result) {
            $scope.totalProductos = result.data.product_count;
            $scope.productos = result.data.productos;
            $scope.cadena = '';
        });
    };

    $scope.filtrar_festividades = function(cadena, value) {
        if(value){
            var send = {
                'tipo':$routeParams.tipo,
                'pageNumber':1, 
                'productosPerPage':$scope.productosPerPage,
                'festividad':cadena
            };
            $http.post('Menu/get_all_productos', send).then(function(result) {
                $scope.totalProductos = result.data.product_count;
            });
            $http.post('Menu/get_productos_x_tipo', send).then(function(result) {
                $scope.totalProductos = result.data.product_count;
                $scope.productos = result.data.productos;
                $scope.cadena = '';
            });
        }
    };

    $scope.filtrar_marca = function(cadena, value) {
        if(value){
            var send = {
                'tipo':$routeParams.tipo,
                'pageNumber':1, 
                'productosPerPage':$scope.productosPerPage,
                'marca':cadena
            };
            $http.post('Menu/get_all_productos', send).then(function(result) {
                $scope.totalProductos = result.data.product_count;
            });
            $http.post('Menu/get_productos_x_tipo', send).then(function(result) {
                $scope.totalProductos = result.data.product_count;
                $scope.productos = result.data.productos;
                $scope.cadena = '';
            });
        }
    };

    $scope.filtrar_talla = function(cadena, value) {
        if(value){
            var send = {
                'tipo':$routeParams.tipo,
                'pageNumber':1, 
                'productosPerPage':$scope.productosPerPage,
                'talla':cadena
            };
            $http.post('Menu/get_all_productos', send).then(function(result) {
                $scope.totalProductos = result.data.product_count;
            });
            $http.post('Menu/get_productos_x_tipo', send).then(function(result) {
                $scope.totalProductos = result.data.product_count;
                $scope.productos = result.data.productos;
                $scope.cadena = '';
            });
        }
    };
});