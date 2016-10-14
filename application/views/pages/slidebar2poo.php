<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            
        </div>
        
        <ul class="sidebar-menu">
            <li class="header">QUIROFANO</li>
            <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dashboard "></i> <span>Parte Operatorio</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="<?= base_url('quirofano/index') ?>"><i class="glyphicon glyphicon-pencil"></i> Generar</a>
                        </li>
                       <li>
                            <a href="<?= base_url('quirofano/index/load_view_reportes_ptope') ?>"><i class="glyphicon glyphicon-list"></i> Reporte</a>
                        </li>
                    </ul>
            </li>
           
             <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dashboard "></i> <span>Protocolo de Operación</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="<?= base_url('quirofano/protocolo_operacion/index') ?>"><i class="glyphicon glyphicon-pencil"></i> Generar</a>
                        </li>
                       <li>
                            <a href="<?= base_url('quirofano/protocolo_operacion/reportes') ?>"><i class="glyphicon glyphicon-list"></i> Reporte</a>
                        </li>
                    </ul>
                </li>
                 <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dashboard "></i> <span>Registro de Anestesia</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="<?= base_url('quirofano/registro_anestesia/index') ?>"><i class="glyphicon glyphicon-pencil"></i> Generar</a>
                        </li>
                       <li>
                            <a href="<?= base_url('quirofano/registro_anestesia/reportes') ?>"><i class="glyphicon glyphicon-list"></i> Reporte</a>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dashboard "></i> <span>Registro de Sala de Recuperación</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="<?= base_url('quirofano/registro_sala_recuperacion/index') ?>"><i class="glyphicon glyphicon-pencil"></i> Generar</a>
                        </li>
                       <li>
                            <a href="<?= base_url('quirofano/registro_sala_recuperacion/reportes') ?>"><i class="glyphicon glyphicon-list"></i> Reporte</a>
                        </li>
                    </ul>
                </li>
            <!--<li> <a class="active" href="<?= base_url('quirofano/index/load_view_cistoscopia') ?>"><i class="fa fa-dashboard fa-fw"></i> Cistoscopia</a> </li>-->
            <li> <a class="active" href="<?= base_url('quirofano/index/load_view_reportes_endos_cistos') ?>"><i class="fa fa-dashboard fa-fw"></i> Parte Diario Endoscopia-Cistoscopia</a> </li>
            <li> <a href="<?= base_url('quirofano/index/load_view_censo_diario') ?>"><i class="fa fa-dashboard fa-fw"></i> Censo Diario (125-B)</a> </li>
            <li> <a class="active" href="<?= base_url('quirofano/index/load_view_ventas/55') ?>"><i class="fa fa-dashboard fa-fw"></i>Recetario Integrado</a> </li>
            <li> <a href="<?= base_url('quirofano/index/load_view_ventas/56') ?>"><i class="fa fa-dashboard fa-fw"></i>  Descargo de Material</a> </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard "></i> <span>Encuesta de satisfaccion</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?= base_url('quirofano/index/satisfaccion') ?>"><i class="glyphicon glyphicon-pencil"></i> Generar</a>
                    </li>
                    <li>
                        <a href="<?= base_url('quirofano/index/satisfaccion_vacio') ?>"><i class="glyphicon glyphicon-list"></i> Generar vacia</a>
                    </li>
                    <li>
                        <a href="<?= base_url('quirofano/index/gratuidad_satisfaccion') ?>"><i class="glyphicon glyphicon-list"></i> Reporte</a>
                    </li>
                </ul>
            </li>
            <li class="header">OTROS</li>
            <li> <a href="<?= base_url('facturacionhospital/ventasjs/') ?>" target="_blank"><i class="glyphicon glyphicon-plus"></i> Reporte de Ventas</a> </li>
        </ul>
    </section>
</aside>