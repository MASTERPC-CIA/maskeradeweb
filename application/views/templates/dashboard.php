<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <?php
           if(!empty($title)){
               $titulo = $title;
           }else{
               $titulo = get_settings('RAZON_SOCIAL');
           }
        ?>
        <title><?= $titulo?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php

        $css = array(
            base_url('assets/css/bootstrap.min.css'),
            base_url('assets/page/stylemain.css'),
            base_url('assets/page/carousel.css'),
            base_url('assets/css/ie10-viewport-bug-workaround.css'),
        );
        echo csslink($css);

        $js = array(
            'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js',
            base_url('assets/js/bootstrap.min.js'),
            base_url('assets/jscarousel/vendor/jquery.min.js'),
            base_url('assets/jscarousel/vendor/holder.min.js'),
            base_url('assets/jscarousel/ie10-viewport-bug-workaround.js'),
            base_url('assets/js/ie-emulation-modes-warning.js'),
            base_url('assets/angularjs/js/angular.js'),
            base_url('assets/angularjs/js/pagination.js'),
            base_url('assets/angularjs/js/ui-bootstrap-tpls-0.14.3.min.js'),
            base_url('assets/angularjs/js/underscore.min.js'),
            base_url('assets/angularjs/js/angular-route.min.js'),
            base_url('assets/angularjs/js/angular-animate.min.js'),
            base_url('assets/angularjs/js/toaster.js'),
            /****LOADING****/
            base_url('assets/angularjs/js/spin.min.js'),
            base_url('assets/angularjs/js/angular-spinner.min.js'),
            base_url('assets/angularjs/js/angular-loading-spinner.js'),
            /**********************************************************/
            base_url('assets/angularjs/js/angular-touch.min.js'),
        );
        echo jsload($js);
        echo jsload($angularjs);
        ?>
    </head>
    <body class="skin-blue">
        <div class="wrapper">
            <?php
            $open_content_div = '';
            $close_content_div = '';

            echo $this->load->view('templates/header','',TRUE);
            echo $open_content_div;?>
            <section class="content" id="content" >
                <div class="row" ng-app=<?php echo $app; ?>>
                    <div ng-view="" id="ng-view"></div>
                </div>
            </section>
            <?php
                echo $close_content_div;
                echo $this->load->view('templates/footer', '', TRUE);
            ?>
        </div>
    </body>
</html>
