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
        
        <link href="<?php echo base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/page/stylemain.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/page/carousel.css')?>" rel="stylesheet">
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="<?= base_url()?>assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <script src="<?php echo base_url()?>assets/js/ie-emulation-modes-warning.js"></script>
    </head>
    <body class="skin-blue">
        <div class="wrapper">
            <?php
            $open_content_div = '';
            $close_content_div = '';

            echo $this->load->view('templates/header','',TRUE);

//            if(!empty($slidebar)){                
//                echo $slidebar;   
//                $open_content_div = Open('div', array('class'=>'content-wrapper'));
//                $close_content_div = Close('div');                
//            }

          /* Content Wrapper. Contains page content */      
            echo $open_content_div;?>

            <!-- Main content -->
            <section class="content" id="content" >
              <!-- Main row -->
              <div class="row" >
                  <?php
                    echo $view;
                  ?>
              </div> <!--/.row (main row) -->

            </section> <!--/.content -->
            <?php
                echo $close_content_div;
                echo $this->load->view('templates/footer', '', TRUE);
            ?>

        </div><!-- ./wrapper -->

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>-->
      
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo base_url()?>assets/jscarousel/vendor/jquery.min.js"><\/script>')</script>
   
        <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
        <script src="<?php echo base_url()?>assets/jscarousel/vendor/holder.min.js"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="<?php echo base_url()?>assets/jscarousel/ie10-viewport-bug-workaround.js"></script>
        <script src="<?php echo base_url()?>assets/js/comunes.js"></script>
    </body>
</html>
