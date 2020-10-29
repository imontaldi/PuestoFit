<?php
    
    include_once '../conexion.class.php';
    include_once '../clases/ventas.class.php';
    include_once 'facturas_compra.class.php';
    include_once 'repositorio_ventas.class.php';
    include_once 'repositorio_factura.class.php';
    require_once("../phpChart_Lite/phpChart_Lite/conf.php");


    class repositorio_saldos{

        /* OBTIENE CANTIDAD DE SALDO EN UN MES */
    public static function obtener_saldo($conexion,$mes){
        if (isset($conexion)){ 
        $saldo = "";
    
        try{
            $saldo = intval(repositorio_ventas::obtener_ingresos($conexion,$mes)) - intval(repositorio_factura::obtener_egresos($conexion,$mes));
            echo $saldo;

            } catch(PDOException $ex){
                print 'ERROR INSCo' . $ex -> getMessage();
            }
        }
        else{
            echo 'No hubo conexion!!';
        }
        return $saldo;
    }
/* OBTIENE EL GRAFICO HAY QUE HACER QUE ESTO SEA GENERICO (QUE SE INGRESE EL MES ACTUAL Y SE CALCULEN 5 PARA ATRAS) */
    public static function obtener_grafica_saldos($conexion/* ,$mes_inicio */){
        if (isset($conexion)){ 
        $saldo = "";
        
        try{

/*             $saldos = array(
                array(6,repositorio_saldos::obtener_saldo(Conexion::obtenerConexion(),"-06-"),'Junio'),
                array(7,repositorio_saldos::obtener_saldo(Conexion::obtenerConexion(),"-07-"),'Julio'),
                array(8,repositorio_saldos::obtener_saldo(Conexion::obtenerConexion(),"-08-"),'Agosto'),
                array(9,repositorio_saldos::obtener_saldo(Conexion::obtenerConexion(),"-09-"),'Septiembre'),
                array(10,repositorio_saldos::obtener_saldo(Conexion::obtenerConexion(),"-10-"),'Octubre'),
                array(11,repositorio_saldos::obtener_saldo(Conexion::obtenerConexion(),"-11-"),'Noviembre')); */
            $egresos = array(
                array(6,repositorio_factura::obtener_egresos(Conexion::obtenerConexion(),"-06-"),'Junio'),
                array(7,repositorio_factura::obtener_egresos(Conexion::obtenerConexion(),"-07-"),'Julio'),
                array(8,repositorio_factura::obtener_egresos(Conexion::obtenerConexion(),"-08-"),'Agosto'),
                array(9,repositorio_factura::obtener_egresos(Conexion::obtenerConexion(),"-09-"),'Septiembre'),
                array(10,repositorio_factura::obtener_egresos(Conexion::obtenerConexion(),"-10-"),'Octubre'),
                array(11,repositorio_factura::obtener_egresos(Conexion::obtenerConexion(),"-11-"),'Noviembre'));
            $ingresos = array(
                array(6,repositorio_ventas::obtener_ingresos(Conexion::obtenerConexion(),"-06-"),'Junio'),
                array(7,repositorio_ventas::obtener_ingresos(Conexion::obtenerConexion(),"-07-"),'Julio'),
                array(8,repositorio_ventas::obtener_ingresos(Conexion::obtenerConexion(),"-08-"),'Agosto'),
                array(9,repositorio_ventas::obtener_ingresos(Conexion::obtenerConexion(),"-09-"),'Septiembre'),
                array(10,repositorio_ventas::obtener_ingresos(Conexion::obtenerConexion(),"-10-"),'Octubre'),
                array(11,repositorio_ventas::obtener_ingresos(Conexion::obtenerConexion(),"-11-"),'Noviembre'));

            $saldo = new C_PhpChartX(array(/* $saldos,  */$egresos, $ingresos),'chart1');
            $saldo->add_plugins(array('highlighter'));
            $saldo->set_title(array('text'=>'Ultimos cinco meses'));
            
            $saldo->set_animate(true);
        
            $saldo->add_series(array('yaxis'=>'y2axis'));
            $saldo->add_series(array('yaxis'=>'y3axis'));
            $saldo->add_series(array('yaxis'=>'y4axis'));
            

            $saldo->set_axes(array(
                'yaxis'=>array('autoscale'=>true),
                'y2axis'=>array('autoscale'=>true),
                'y3axis'=>array('autoscale'=>true),
                'y4axis'=>array('autoscale'=>true),
                'y5axis'=>array('autoscale'=>true),
                'y6axis'=>array('autoscale'=>true), ));
            $saldo->add_series(array('showLabel'=>true));
            $saldo->add_series(array('showLabel'=>true));
            $saldo->add_series(array('showLabel'=>false));

            } catch(PDOException $ex){
                print 'ERROR INSCo' . $ex -> getMessage();
            }
        }
        else{
            echo 'No hubo conexion!!';
        }
        return $saldo->draw(900, 500);
    }



    }