<?php

    //juego.php - Motor del juego en si.    

    //Se incluyen las funciones con las cartas:
    include "funciones.php";
    
    //Se incluyen las matrices con las cartas:   
    include "cartas.php";

    //Si no estan definidas las puntuaciones, se setean a cero:
    if (!isset($HTTP_SESSION_VARS["puntuacion_ordenador"])) { $HTTP_SESSION_VARS["puntuacion_ordenador"] = 0; }
    if (!isset($HTTP_SESSION_VARS["puntuacion_usuario"])) { $HTTP_SESSION_VARS["puntuacion_usuario"] = 0; }

    //Se vacian las variables de representacion:
    $errores = "";
    $mensajes = "";
    $cartas_ordenador = "";
    $cartas_jugada = "";
    $cartas_usuario = "";
    $botones = "";

    //Si no esta seteada, se setea la variable que dice si hay o no cartas en la baza, y se pone que si que hay:
    if (!isset($HTTP_SESSION_VARS["hay_cartas_en_la_baza"])) { $HTTP_SESSION_VARS["hay_cartas_en_la_baza"] = TRUE; }

    //Si no esta seteada la variable de sesion que determina el fin del juego, se setea y se pone que no es el fin:
    if (!isset($HTTP_SESSION_VARS["fin_del_juego"])) { $HTTP_SESSION_VARS["fin_del_juego"] = FALSE; }

    //Se setea la variable, si no existe, que dice si hay que robar o no, y se pone que no (al comenzar no se roba):
    if (!isset($HTTP_SESSION_VARS["hay_que_robar"])) { $HTTP_SESSION_VARS["hay_que_robar"] = FALSE; }

    //Si no esta seteada la variable de ultimo ganador, se escoge al "usuario" para que comience la partida tirando el primero:
    if (!isset($HTTP_SESSION_VARS["ultimo_ganador"])) { $HTTP_SESSION_VARS["ultimo_ganador"] = "usuario"; }

    if (!isset($HTTP_SESSION_VARS["continuar"])) { $HTTP_SESSION_VARS["continuar"] = FALSE; }
//    if ($HTTP_SESSION_VARS["continuar"]) { echo "<br>continuar es TRUE<br>"; }
//    else { echo "<br>continuar es FALSE<br>"; }

//     {
//        unset($HTTP_SESSION_VARS["numero_ordenador"]);
//        unset($HTTP_SESSION_VARS["palo_ordenador"]);
//     }
    

//    if (!$HTTP_SESSION_VARS["continuar"]) { $HTTP_SESSION_VARS["continuar"] = FALSE; }

    //0)
    // Si se ha comenzado el juego por primera vez, darle 5 cartas a cada usuario y quitarlas de las posibles:
    if (isset($HTTP_GET_VARS["comenzar"]) && $HTTP_GET_VARS["comenzar"] == "ok")
     {
        
        //Se les quitan las cartas al usuario y al ordenador:
        $HTTP_SESSION_VARS["cartas_usuario"] = array();
        $HTTP_SESSION_VARS["cartas_ordenador"] = array();
        
        //Se quitan las cartas a la baza, para posibles errores:
        $HTTP_SESSION_VARS["cartas_en_baza"] = array();

        //Se comienza el juego:
        $HTTP_SESSION_VARS["fin_del_juego"] = FALSE;

        //Se setean otras variables:        
        $HTTP_SESSION_VARS["hay_que_robar"] = FALSE;
        $HTTP_SESSION_VARS["fin_del_juego"] = FALSE;
        $HTTP_SESSION_VARS["hay_cartas_en_la_baza"] = TRUE;
        
        //Se borran las cartas de la jugada por si ha habido alguna anterior de otra partida:
        $HTTP_SESSION_VARS["cartas_jugada"] = "";
        

        //Se setean en FALSE la variable de pause/paso para cuando no quedan cartas en la baza y el ganador es el ordenador:
        $HTTP_SESSION_VARS["continuar"] = FALSE;
        
        //Se ponen todas las cartas en la baza:
        recoger_cartas();
        
        //Se dan 5 cartas a cada jugador (usuario y ordenador):
        repartir_cartas();

     }

    //Se llama al a funcion que finaliza el juego si ya no hay cartas en las manos de ninguno de los jugadores:
    contar_cartas_en_mano();

    //Si esta seteada la variable de continuar y no quedan cartas en la baza, se setea la de sesion:
//    if (isset($HTTP_GET_VARS["continuar"]) && $HTTP_GET_VARS["continuar"] == "ok" && !$HTTP_SESSION_VARS["hay_cartas_en_la_baza"] && $HTTP_SESSION_VARS["ultimo_ganador"] == "ordenador") { $HTTP_SESSION_VARS["continuar"] == TRUE; }
    
    //1)
    // Calcular si se ha usado legalmente la carta del ordenador y la del usuario y dar bonificacion a quien corresponda (al ganador de la mano),
    // y mostrar boton para "robar y seguir jugando" si aun quedan cartas posibles y si no solo "seguir jugando":
    // Mejor: llamar a la funcion de usar_cartas($carta1, $carta2).
    //        $cartaX = [palo]."-".[numero] (si isset "usar = x" de get)
    if (isset($HTTP_GET_VARS["usar"]) && trim($HTTP_GET_VARS["usar"]) != "" && !$HTTP_SESSION_VARS["hay_que_robar"] && !$HTTP_SESSION_VARS["fin_del_juego"])
     {
        $carta_enviada = trim($HTTP_GET_VARS["usar"]);
        $carta_enviada_array = explode("-", $carta_enviada);
        if (isset($carta_enviada_array[0]) && trim($carta_enviada_array[0]) != "" && isset($carta_enviada_array[1]) && trim($carta_enviada_array[1]) != "")
         {
            $palo_enviado_usuario = trim($carta_enviada_array[0]);
            $numero_enviado_usuario = trim($carta_enviada_array[1]);
            usar_cartas($palo_enviado_usuario, $numero_enviado_usuario);
         }
     }

    
    //2)
    // Si se ha robado, calcular que cartas son posibles y darles al ordenador y al usuario una carta posible a cada uno. Al robar poner ambas cartas en no posibles. Roba primero el ganador de la mano:
    // Mejor: funcion robar_cartas();  (si "robar = ok" de get)
    elseif (isset($HTTP_GET_VARS["robar"]) && $HTTP_GET_VARS["robar"] == "ok" && $HTTP_SESSION_VARS["hay_que_robar"])
     {
        robar_cartas();
     }


    //3)
    // Si aun quedan cartas: Mostrar las cartas, con form para seleccionar una (input radio) y boton de "usar carta".
    // Si ya no quedan ni en la baza (posibles) ni tiene el usuario ni el ordenador, finalizar juego y mostrar puntuaciones con boton e input hidden ("finalizar" = ok).
    //Mejor: Funcion mostrar_cartas();, y en esta calcular si aun hay cartas en las manos y si no hay mostrar puntuaciones con boton e input hidden => ("finalizar" = ok).
    //       Si aun quedan cartas en la baza y el usuario tiene menos de 5 cartas, poner boton "Robar". Si solo quedan en la mano o tiene 5 cartas, mostrar "Usar carta". Si no quedan en la baza, poner "ultimas cartas" como texto
//    else
//     {

        //Si el que ha ganado antes ha sido el ordenador, el tira la primera carta:
        if (isset($HTTP_SESSION_VARS["ultimo_ganador"]) && $HTTP_SESSION_VARS["ultimo_ganador"] == "ordenador" && !$HTTP_SESSION_VARS["hay_que_robar"])
         {
            if (!isset($HTTP_SESSION_VARS["palo_ordenador"]) && !isset($HTTP_SESSION_VARS["numero_ordenador"]) && !$HTTP_SESSION_VARS["fin_del_juego"]) { mostrar_carta_ordenador(); }
            if (trim($mensajes) == "" && !$HTTP_SESSION_VARS["fin_del_juego"]) { $mensajes .= "El ordenador usa <b>".$HTTP_SESSION_VARS["numero_ordenador"]." de ".ucfirst($HTTP_SESSION_VARS["palo_ordenador"])."</b><br>"; }
            //Se muestan las cartas de la jugada:
            if (trim($cartas_jugada) == "" && !$HTTP_SESSION_VARS["fin_del_juego"]) {$cartas_jugada .= "<center><table border=\"2\" width=\"80\" height=\"120\" cellspacing=\"0\" cellpadding=\"2\" align=\"center\"><tr><td align=\"center\"><center><b>".$HTTP_SESSION_VARS["numero_ordenador"]."<br>de<br>".ucfirst($HTTP_SESSION_VARS["palo_ordenador"])."</b><br><i>ordenador</i></center></td></tr></table></center>"; }

            //else { $mensajes .= "El ordenador usa <b>".$HTTP_SESSION_VARS["numero_ordenador"]." de ".ucfirst($HTTP_SESSION_VARS["palo_ordenador"])."</b><br>"; }
         }
        else { $numero_ordenador = ""; $palo_ordenador = ""; }

        
        //Se crean las puntuaciones:
        $puntuaciones = "Ordenador: <b>".$HTTP_SESSION_VARS["puntuacion_ordenador"]."</b><br>Usuario: <b>".$HTTP_SESSION_VARS["puntuacion_usuario"]."</b><hr>";
       
        //Se muestran las cartas del usuario:
        ver_cartas();

//     }
?>

    <center>
        <table border="1" width="640" align="center" cellspacing="0" cellpadding="0">
            <tr>
                <td valign="top">
                    <table border="1" width="500" align="center" cellspacing="0" cellpadding="15">
                    <?php
                        if (isset($errores) && trim($errores) != "" && !$HTTP_SESSION_VARS["fin_del_juego"]) { echo "<tr><td><center><h3>Errores</h3></center>".$errores."</td></tr>"; }
                        if (isset($mensajes) && trim($mensajes) != "" && !$HTTP_SESSION_VARS["fin_del_juego"]) { echo "<tr><td><center><h3>Mensajes</h3></center>".$mensajes."</td></tr>"; }
                        elseif ($HTTP_SESSION_VARS["fin_del_juego"])
                         {
                            echo "<tr><td><center><h3>Mensajes</h3></center>El juego ha finalizado<br><br>Ganador: ";
                            if ($HTTP_SESSION_VARS["puntuacion_ordenador"] > $HTTP_SESSION_VARS["puntuacion_usuario"]) { echo "<b>ordenador</b>"; }
                            elseif ($HTTP_SESSION_VARS["puntuacion_ordenador"] < $HTTP_SESSION_VARS["puntuacion_usuario"]) { echo "<b>usuario</b>"; }
                            elseif ($HTTP_SESSION_VARS["puntuacion_ordenador"] == $HTTP_SESSION_VARS["puntuacion_usuario"]) { echo "<b>empate</b>"; }
                            echo "</td></tr>";
                         }

                        if (isset($cartas_ordenador) && trim($cartas_ordenador) != "") { echo "<tr><td align=\"center\"><center><h3>Cartas ordenador</h3>".$cartas_ordenador."</center></td></tr>"; }
                        if (isset($cartas_jugada) && trim($cartas_jugada) != "") { $HTTP_SESSION_VARS["cartas_jugada"] = $cartas_jugada; }
//                        if (isset($HTTP_SESSION_VARS["cartas_jugada"]) && trim($HTTP_SESSION_VARS["cartas_jugada"]) != "" && !$HTTP_SESSION_VARS["fin_del_juego"]) { echo "<tr><td align=\"center\"><center><h3>Mesa</h3>".$HTTP_SESSION_VARS["cartas_jugada"]."</center></td></tr>"; }
                        if (isset($HTTP_SESSION_VARS["cartas_jugada"]) && trim($HTTP_SESSION_VARS["cartas_jugada"]) != "") { echo "<tr><td align=\"center\"><center><h3>Mesa</h3>".$HTTP_SESSION_VARS["cartas_jugada"]."</center></td></tr>"; }
                        echo "<tr><td align=\"center\"><center>";
                        if (isset($cartas_usuario) && trim($cartas_usuario) != "") { echo "<h3>Cartas usuario</h3>".$cartas_usuario."</center>"; }
                        if (isset($botones) && trim($botones) != "") { echo "<br><form method=\"get\" action=\"".$this_file."\" style=\"display:inline;\">".$sid_oculto.$botones."</form>"; }
                        echo "</center></td></tr>";
                    ?>
                    </table>
                </td>
                <td width="140" valign="top" align="center">
                    <center>
                        <h3 align="center">Puntuaciones:</h3>
                        <?php if (isset($puntuaciones) && trim($puntuaciones) != "") { echo $puntuaciones; } ?>
                    </center>
                </td>
            </tr>
        </table>
    </center>
