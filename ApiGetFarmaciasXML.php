<?php
header("Access-Control-Allow-Origin: *");
header("Content-type: text/xml");
 /*
  *
  * La APIrest de Minsal es un array que contiene un objeto, por tanto se deben usar los brakets [] para refernciar la primera posicion (index 0)
  * y luego acceder a un valor de un campo especifico del objeto definido entre los corchetes{}
 * [{
 * "fecha":"29-10-2019",
 * "local_id":"534",
 * "local_nombre":"TORRES MPD",
 * "comuna_nombre":"RECOLETA",
 * "localidad_nombre":"RECOLETA",
 * "local_direccion":"AVENIDA EL SALTO 2972",
 * "funcionamiento_hora_apertura":"10:30 hrs.",
 * "funcionamiento_hora_cierre":"19:30 hrs.",
 * "local_telefono":"+560225053570",
 * "local_lat":"-33.3996351",
 * "local_lng":"-70.62894990000001",
 * "funcionamiento_dia":"martes",
 * "fk_region":"7",
 * "fk_comuna":"122"
 * }
 *
 * url pruebas
 *
http://localhost/Farmacias/GetFarmaciasXML.php?Region=7&Comuna=BUIN
http://localhost/Farmacias/GetFarmaciasXML.php?Region=7&Local=AHUMADA
http://localhost/Farmacias/GetFarmaciasXML.php?Region=7&Comuna=BUIN&Local=CRUZ%20VERDE
   * */

$Region="";
$Comuna="";
$Local="";
 $XmlResponse="";


if(isset($_GET['Region']))
    $Region=$_GET['Region'];

if(isset($_GET['Comuna']))
    $Comuna=$_GET['Comuna'];

if(isset($_GET['Local']))
    $Local=$_GET['Local'];



if($Region!="")
{
    $user = json_decode( file_get_contents('https://farmanet.minsal.cl/maps/index.php/ws/getLocalesRegion?id_region='.$Region), true );

    foreach ($user as $key => $value) {

        if(($Comuna==$value["comuna_nombre"] && $Local==$value["local_nombre"])||($Comuna==$value["comuna_nombre"] && $Local=="")||($Comuna=="" && $Local==$value["local_nombre"]))
        {
            $XmlResponse=$XmlResponse.'<marker comuna_nombre="'.$value["comuna_nombre"].'" Farmacia="'.$value["local_nombre"].'"  funcionamiento_hora_apertura="'.$value["funcionamiento_hora_apertura"].'" funcionamiento_hora_cierre="'. $value["funcionamiento_hora_cierre"].'" local_telefono="'. $value["local_telefono"].'" funcionamiento_dia="'.$value["funcionamiento_dia"].'" local_lat="'.$value["local_lat"].'" local_lng="'.$value["local_lng"].'">'."</marker>";
        }


    }


    $XMLOut="<markers>".$XmlResponse."</markers>";


    echo $XMLOut;
}else{
    echo "Debe ingresar Region";
}

?>