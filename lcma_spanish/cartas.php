<?php

    //cartas.php - Definiciones de las cartas existentes y las restantes en la baza (posibles).


    //Se define la matriz con las cartas posibles, dividida por palo (bastos, oros, espadas y copas) y numeros (del 1 al 12):
    $cartas = array(
                        "palos" => "bastos,oros,espadas,copas",
                        "numeros" => "1,2,3,4,5,6,7,8,9,10,11,12",
                   );

    //Obsoleto: Si no esta definida la variable de sesion donde se guardan las cartas sin usar, posibles para robar (aun en la baza). Se define y se pone sin usar ninguna:
    if (!isset($HTTP_SESSION_VARS["cartas_en_baza"]))
     {
        $HTTP_SESSION_VARS["cartas_en_baza"] = array();
     }

    //Si no esta seteada la variable donde se guardaran las cartas del usuario, se declara para que no de error:
    if (!isset($HTTP_SESSION_VARS["cartas_usuario"]))
     {
        $HTTP_SESSION_VARS["cartas_usuario"] = array();
     }

    //Si no esta seteada la variable donde se guardaran las cartas del ordenador, se declara para que no de error:
    if (!isset($HTTP_SESSION_VARS["cartas_ordenador"]))
     {
        $HTTP_SESSION_VARS["cartas_ordenador"] = array();
     }

?>
