<?php
    
    //funciones.php - Funciones con las cartas.

    
    //Se recogen las cartas (se completa la baza con todas las cartas):
    function recoger_cartas()
     {
        
        global $HTTP_SESSION_VARS;
        
        //Cartas en la baza (se ponen todas):
        $HTTP_SESSION_VARS["cartas_en_baza"] = array(
                                                     "bastos" => array(
                                                                        1 => TRUE,
                                                                        2 => TRUE,
                                                                        3 => TRUE,
                                                                        4 => TRUE,
                                                                        5 => TRUE,
                                                                        6 => TRUE,
                                                                        7 => TRUE,
                                                                        8 => TRUE,
                                                                        9 => TRUE,
                                                                        10 => TRUE,
                                                                        11 => TRUE,
                                                                        12 => TRUE
                                                                ),
                                                     "oros" => array(
                                                                        1 => TRUE,
                                                                        2 => TRUE,
                                                                        3 => TRUE,
                                                                        4 => TRUE,
                                                                        5 => TRUE,
                                                                        6 => TRUE,
                                                                        7 => TRUE,
                                                                        8 => TRUE,
                                                                        9 => TRUE,
                                                                        10 => TRUE,
                                                                        11 => TRUE,
                                                                        12 => TRUE
                                                                ),
                                                     "espadas" => array(
                                                                        1 => TRUE,
                                                                        2 => TRUE,
                                                                        3 => TRUE,
                                                                        4 => TRUE,
                                                                        5 => TRUE,
                                                                        6 => TRUE,
                                                                        7 => TRUE,
                                                                        8 => TRUE,
                                                                        9 => TRUE,
                                                                        10 => TRUE,
                                                                        11 => TRUE,
                                                                        12 => TRUE
                                                                ),
                                                     "copas" => array(
                                                                        1 => TRUE,
                                                                        2 => TRUE,
                                                                        3 => TRUE,
                                                                        4 => TRUE,
                                                                        5 => TRUE,
                                                                        6 => TRUE,
                                                                        7 => TRUE,
                                                                        8 => TRUE,
                                                                        9 => TRUE,
                                                                        10 => TRUE,
                                                                        11 => TRUE,
                                                                        12 => TRUE
                                                                )
                                                    );

        //Cartas del usuario (se le quitan todas):
        $HTTP_SESSION_VARS["cartas_usuario"] = array(
                                                     "bastos" => array(
                                                                        1 => FALSE,
                                                                        2 => FALSE,
                                                                        3 => FALSE,
                                                                        4 => FALSE,
                                                                        5 => FALSE,
                                                                        6 => FALSE,
                                                                        7 => FALSE,
                                                                        8 => FALSE,
                                                                        9 => FALSE,
                                                                        10 => FALSE,
                                                                        11 => FALSE,
                                                                        12 => FALSE
                                                                ),
                                                     "oros" => array(
                                                                        1 => FALSE,
                                                                        2 => FALSE,
                                                                        3 => FALSE,
                                                                        4 => FALSE,
                                                                        5 => FALSE,
                                                                        6 => FALSE,
                                                                        7 => FALSE,
                                                                        8 => FALSE,
                                                                        9 => FALSE,
                                                                        10 => FALSE,
                                                                        11 => FALSE,
                                                                        12 => FALSE
                                                                ),
                                                     "espadas" => array(
                                                                        1 => FALSE,
                                                                        2 => FALSE,
                                                                        3 => FALSE,
                                                                        4 => FALSE,
                                                                        5 => FALSE,
                                                                        6 => FALSE,
                                                                        7 => FALSE,
                                                                        8 => FALSE,
                                                                        9 => FALSE,
                                                                        10 => FALSE,
                                                                        11 => FALSE,
                                                                        12 => FALSE
                                                                ),
                                                     "copas" => array(
                                                                        1 => FALSE,
                                                                        2 => FALSE,
                                                                        3 => FALSE,
                                                                        4 => FALSE,
                                                                        5 => FALSE,
                                                                        6 => FALSE,
                                                                        7 => FALSE,
                                                                        8 => FALSE,
                                                                        9 => FALSE,
                                                                        10 => FALSE,
                                                                        11 => FALSE,
                                                                        12 => FALSE
                                                                )
                                                    );



        //Cartas del ordenador (se le quitan todas igual que al usuario):
        $HTTP_SESSION_VARS["cartas_ordenador"] = $HTTP_SESSION_VARS["cartas_usuario"];

     }


    function contar_cartas_en_mano()
        {
            //Se hacen globales las funciones que se van a necesitar:
            global $HTTP_SESSION_VARS;
            
            $numero_de_cartas_usuario = 0;
            $numero_de_cartas_ordenador = 0;
            foreach ($HTTP_SESSION_VARS["cartas_en_baza"] as $palo => $array)
             {
                foreach ($array as $numero => $true_o_false)
                 {
                    //Si se encuentra la carta en la mano del usuario, agregar una unidad al contador correspondiente:
                    if ($HTTP_SESSION_VARS["cartas_usuario"][$palo][$numero]) { $numero_de_cartas_usuario++; }

                    //Si se encuentra la carta en la mano del ordenador, agregar una unidad al contador correspondiente:
                    if ($HTTP_SESSION_VARS["cartas_ordenador"][$palo][$numero]) { $numero_de_cartas_ordenador++; }
                 }
             }
        
            //Si ninguno de los dos tiene cartas en la mano, se finaliza el juego:
            if ($numero_de_cartas_usuario == 0 && $numero_de_cartas_ordenador == 0) { $HTTP_SESSION_VARS["fin_del_juego"] = TRUE; }
        }



    //Da 5 cartas al usuario y al ordenador, distintas entre si y las borra de la baza (posibles):
    function repartir_cartas()
     {
        
        //Se hacen las variables globales que vamos a necesitar:
        global $cartas;
        global $HTTP_SESSION_VARS;
        
        //Selecciona una de $cartas["palos"] y $cartas["numeros"] aleatoriamente, y si aun esta en la baza la quita de ella y se la da al usuario o al ordenador:
        $palos = explode(",",$cartas["palos"]);
        $numeros = explode(",",$cartas["numeros"]);
        
        //Contador de cartas repartidas al usuario:
        $x = 0;
        //Contador de cartas repartidas al ordenador:
        $i = 0;

        //Variables con el texto a mostrar para saber que cartas se han repartido:
        $mensaje_cartas_usuario = "";
        $mensaje_cartas_ordenador = "";
        
        while ($x<5 || $i <5)
         {

            $palo_aleatorio_usuario = rand(0,3);
            $palo_aleatorio_ordenador = rand(0,3);

            $numero_aleatorio_usuario = rand(0,11);
            $numero_aleatorio_ordenador = rand(0,11);

            //Si esta la carta aleatoria del usuario en la baza y el numero de cartas repartidos a este es menor a 5:    
            if ($HTTP_SESSION_VARS["cartas_en_baza"][$palos[$palo_aleatorio_usuario]][$numeros[$numero_aleatorio_usuario]] && $x < 5)
             {
                //Se le da la carta al usuario:
                $HTTP_SESSION_VARS["cartas_usuario"][$palos[$palo_aleatorio_usuario]][$numeros[$numero_aleatorio_usuario]] = TRUE;
                //Se borra la carta de la baza:
                $HTTP_SESSION_VARS["cartas_en_baza"][$palos[$palo_aleatorio_usuario]][$numeros[$numero_aleatorio_usuario]] = FALSE;
                //Se agrega una unidad al contador de cartas repartidas al usuario:
                $x++;
                $mensaje_cartas_usuario .= "<b>".$numeros[$numero_aleatorio_usuario]."</b> de <b>".ucfirst($palos[$palo_aleatorio_usuario])."</b><br>";
             }

            //Si esta la carta aleatoria del ordenador en la baza y el numero de cartas repartidos a este es menor a 5:
            if ($HTTP_SESSION_VARS["cartas_en_baza"][$palos[$palo_aleatorio_ordenador]][$numeros[$numero_aleatorio_ordenador]] && $i < 5)
             {
                //Se le da la carta al ordenador:
                $HTTP_SESSION_VARS["cartas_ordenador"][$palos[$palo_aleatorio_ordenador]][$numeros[$numero_aleatorio_ordenador]] = TRUE;
                //Se borra la carta de la baza:
                $HTTP_SESSION_VARS["cartas_en_baza"][$palos[$palo_aleatorio_ordenador]][$numeros[$numero_aleatorio_ordenador]] = FALSE;
                //Se agrega una unidad al contador de cartas repartidas al ordenador:
                $i++;
                $mensaje_cartas_ordenador .= "<b>".$numeros[$numero_aleatorio_ordenador]."</b> de <b>".ucfirst($palos[$palo_aleatorio_ordenador])."</b><br>";
             }

//         "X = $x<br>";
//        echo "I = $i<br>";
        
         }
        
//        echo "Salida";
         
//         echo "<b><u>C</u>artas usuario</b>:<br>";
//         print_r($HTTP_SESSION_VARS["cartas_usuario"]);
//         echo "<br>".$mensaje_cartas_usuario;
//         echo "<br><br><b><u>C</u>artas ordenador</b>:<br>";
//         print_r($HTTP_SESSION_VARS["cartas_ordenador"]);         
//         echo "<br>".$mensaje_cartas_ordenador;
        
     }




    
    //Calcular aleatoriamente un palo y un numero de los posibles, y calcular si aun estan en la baza.
    //Si ya no hay cartas en la baza, devuelve FALSE.
    //Si es asi, setear (globalmente) las cartas del usuario y del ordenador con las nueva elegidas y quitar de posibles (de la baza) estas mismas.
    //Si no es asi, volver a llamarse recursivamente.
    //Devuelve TRUE al encontrar carta.
    function robar_cartas()
     {
        global $HTTP_SESSION_VARS;
        global $mensajes;
        global $errores;
        global $botones;
        global $cartas_jugada;
        global $ver_cartas_del_ordenador;
    
        $mensajes .= "Se ha elegido robar carta<br>";

        //Repartir cartas de la baza a cada uno. Quitarlas de la baza.
        $se_ha_repartido_al_usuario = FALSE;
        $se_ha_repartido_al_ordenador = FALSE;
        foreach ($HTTP_SESSION_VARS["cartas_en_baza"] as $palo => $array)
         {
            foreach ($array as $numero => $true_o_false)
             {
                //Si esta seteada, y no se ha repartido al usuario todavia se reparte al usuario y se quita de la baza:
                if ($HTTP_SESSION_VARS["cartas_en_baza"][$palo][$numero] && !$se_ha_repartido_al_usuario) { $HTTP_SESSION_VARS["cartas_usuario"][$palo][$numero] = TRUE; $HTTP_SESSION_VARS["cartas_en_baza"][$palo][$numero] = FALSE; $se_ha_repartido_al_usuario = TRUE; $palo_usuario_robada = $palo; $numero_usuario_robada = $numero;}
                //Y si no, si esta seteada, y no se ha repartido al ordenador todavia se reparte al ordenador y se quita de la baza:
                elseif ($HTTP_SESSION_VARS["cartas_en_baza"][$palo][$numero] && !$se_ha_repartido_al_ordenador) { $HTTP_SESSION_VARS["cartas_ordenador"][$palo][$numero] = TRUE; $HTTP_SESSION_VARS["cartas_en_baza"][$palo][$numero] = FALSE; $se_ha_repartido_al_ordenador = TRUE; $palo_ordenador_robada = $palo; $numero_ordenador_robada = $numero; }
             }
         }

        //Si los dos (ordenador y usuario) no tienen el mismo numero de cartas, dar error:
        //FALTA CALCULARRRRRR       

        //Se muestra el mensaje de quien roba, y se simula que ha robado primero el ultimo ganador:
        $mensajes .= "El ultimo ganador (".$HTTP_SESSION_VARS["ultimo_ganador"].") roba primero...<br>";
        if ($HTTP_SESSION_VARS["ultimo_ganador"] == "usuario")
         {
             $mensajes .= "El usuario roba un <b>".$numero_usuario_robada." de ".ucfirst($palo_usuario_robada)."</b><br>";
             if ($ver_cartas_del_ordenador) { $mensajes .= "El ordenador roba un <b>".$numero_ordenador_robada." de ".$palo_ordenador_robada."</b><br>"; }
             else { $mensajes .= "El ordenador roba otra carta<br>"; }
         }
        else
         {
             if ($ver_cartas_del_ordenador) { $mensajes .= "El ordenador roba un <b>".$numero_ordenador_robada." de ".$palo_ordenador_robada."</b><br>"; }
             else { $mensajes .= "El ordenador roba una carta<br>"; }
             $mensajes .= "El usuario roba un <b>".$numero_usuario_robada." de ".ucfirst($palo_usuario_robada)."</b><br>";
         }

        //Se quitan las cartas de la mesa:
        $cartas_jugada = "";
        $HTTP_SESSION_VARS["cartas_jugada"] = "";
        
        //Se quita el boton de robar:
        $botones = "";
        
        //Se unsetea la variable para que ya no se tenga que robar:
        $HTTP_SESSION_VARS["hay_que_robar"] = FALSE;

        //Se comprueba si hay cartas en la baza, y si no las hay se setea la variable para que no vuelva a ejecutarse robar:
        $hay_cartas_en_la_baza = FALSE;
        foreach ($HTTP_SESSION_VARS["cartas_en_baza"] as $palo => $array)
         {
            foreach ($array as $numero => $true_o_false)
             {
                //Si hay cartas en la baza, se setea TRUE:
                if ($HTTP_SESSION_VARS["cartas_en_baza"][$palo][$numero]) { $hay_cartas_en_la_baza = TRUE; }
             }
         }

        if ($hay_cartas_en_la_baza == FALSE) { $HTTP_SESSION_VARS["hay_cartas_en_la_baza"] = FALSE; }
        else { $HTTP_SESSION_VARS["hay_cartas_en_la_baza"] = TRUE; }


     }
    
    //Calcula si la carta del ordenador y la del usuario son legales (las poseen ellos) y si es asi, decidir el ganador. Dar puntos a este.
    function usar_cartas($palo_usuario, $numero_usuario)
     {
        
        //Se hacen las variables globales que vamos a necesitar:
//        global $cartas;
        //global $carta_ordenador;
        global $HTTP_SESSION_VARS;
//        global $HTTP_GET_VARS;
        global $this_file;
        global $mensajes;
        global $errores;
        global $numero_ordenador;
        global $palo_ordenador;
        global $cartas_jugada;
        global $mensaje_ganador;
        global $botones;

//        echo "estoy en usar<br>";

        //Si ya no quedan cartas en la baza y no se ha enviado el boton continuar, sale de la funcion:
        if ($HTTP_SESSION_VARS["ultimo_ganador"] == "ordenador" && !$HTTP_SESSION_VARS["hay_cartas_en_la_baza"] && !$HTTP_SESSION_VARS["continuar"]) { $HTTP_SESSION_VARS["continuar"] = TRUE; return FALSE; }

        if (isset($HTTP_SESSION_VARS["palo_ordenador"]) && isset($HTTP_SESSION_VARS["numero_ordenador"]) && !$HTTP_SESSION_VARS["hay_que_robar"]) { $mensajes .= "El ordenador usa <b>".$HTTP_SESSION_VARS["numero_ordenador"]." de ".ucfirst($HTTP_SESSION_VARS["palo_ordenador"])."</b><br>"; }

        $mensajes .= "Se ha elegido usar carta <b>".$numero_usuario." de ".ucfirst($palo_usuario)."</b><br>";

        //Calcula si es valida la carta usada por el usuario:
        if (!isset($HTTP_SESSION_VARS["cartas_usuario"][$palo_usuario][$numero_usuario]) || isset($HTTP_SESSION_VARS["cartas_usuario"][$palo_usuario][$numero_usuario]) && !$HTTP_SESSION_VARS["cartas_usuario"][$palo_usuario][$numero_usuario]) { $errores .= "E<u>RROR</u>: <b>Carta de usuario no encontrada</b><br>"; return FALSE; }

        //Calcula si esta seteada la variable de sesion con el ultimo ganador:
        if (!isset($HTTP_SESSION_VARS["ultimo_ganador"]) || trim($HTTP_SESSION_VARS["ultimo_ganador"]) == "") { $errores .= "E<u>RROR</u>: <b>Variable de sesion con ultimo ganador inexistente o invalida.</b><br>"; }

        //Si el ganador es el usuario:
        if ($HTTP_SESSION_VARS["ultimo_ganador"] == "usuario")
         {
            mostrar_carta_ordenador($palo_usuario, $numero_usuario);
//            $mensajes .= "<br><br>Si el ordenador tira segundo, usa: ".$numero_ordenador." de ".$palo_ordenador."<br><br>";
         }

        //0) Comprobar que la carta del usuario sea legal (este en la mano del ordenador). Si no, dar aviso diciendo que es erroneo y mostrar boton "Ok".
        //1) Mostrar la carta del usuario ($cartas_usuario).
        //2) Si $carta_ordenador no esta seteada o esta vacia y el ordenador es el ultimo ganador, llamar a la funcion ($carta_ordenador = mostrar_carta_ordenador();). Si esta sin setear y no es el ultimo el ordenador, o esta seteada y el ultimo no es el ordenador, dar error fatal y salir de la funcion.
        //3) Mostrar el ganador y dar puntos a quien corresponda. Mostrar boton "Ok".
        //Acordarse de setear una variable de sesion con el ultimo ganador => el ultimo ganador le toca tirar primero ($HTTP_SESSION_VARS["ultimo_granador"] = "ordenador"|"usuario").
        //Acordarse de quitar de las cartas del usuario la carta usada y del ordenador igual.

        //Determina el ganador y le da puntos, ademas de mostrar el mensaje. Setea el ultimo ganador:
        $mensaje_ganador = "";
        if ($numero_usuario > $HTTP_SESSION_VARS["numero_ordenador"]) { $mensajes .= "Ganas t&uacute;<br>"; $mensaje_ganador = "Ganas t&uacute;"; $HTTP_SESSION_VARS["puntuacion_usuario"]++; $HTTP_SESSION_VARS["ultimo_ganador"] = "usuario"; }
        elseif ($numero_usuario < $HTTP_SESSION_VARS["numero_ordenador"]) { $mensajes .= "Gana el ordenador<br>"; $mensaje_ganador = "Gana el ordenador"; $HTTP_SESSION_VARS["puntuacion_ordenador"]++; $HTTP_SESSION_VARS["ultimo_ganador"] = "ordenador"; }
        elseif ($numero_usuario == $HTTP_SESSION_VARS["numero_ordenador"]) { $mensajes .= "No gana nadie (empate)<br>"; $mensaje_ganador = "Empate"; $HTTP_SESSION_VARS["puntuacion_ordenador"]++; $HTTP_SESSION_VARS["puntuacion_usuario"]++; $HTTP_SESSION_VARS["ultimo_ganador"] = $HTTP_SESSION_VARS["ultimo_ganador"]; }
      
        //Borra las cartas usadas:
        $HTTP_SESSION_VARS["cartas_ordenador"][$HTTP_SESSION_VARS["palo_ordenador"]][$HTTP_SESSION_VARS["numero_ordenador"]] = FALSE;
        $HTTP_SESSION_VARS["cartas_usuario"][$palo_usuario][$numero_usuario] = FALSE;
        
        //Muestra las cartas de la jugada:
        $cartas_jugada .= "<table width=\"180\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tr><td><center><table border=\"2\" width=\"80\" height=\"120\" cellspacing=\"0\" cellpadding=\"2\" align=\"center\"><tr><td align=\"center\"><center><b>".$HTTP_SESSION_VARS["numero_ordenador"]."<br>de<br>".ucfirst($HTTP_SESSION_VARS["palo_ordenador"])."</b><br><i>ordenador</i></center></td></tr></table></center></td><td>";
        $cartas_jugada .= "<center><table border=\"2\" width=\"80\" height=\"120\" cellspacing=\"0\" cellpadding=\"2\" align=\"center\"><tr><td align=\"center\"><center><b>".$numero_usuario."<br>de<br>".ucfirst($palo_usuario)."</b><br><i>usuario</i></center></td></tr></table></center></td></tr></table>";
        $cartas_jugada .= $mensaje_ganador;
        //$cartas_jugada .= "<br><form method=\"get\" action=\"".$this_file."\" style=\"display:inline;\"><input type=\"hidden\" name=\"robar\" value=\"ok\"><input type=\"submit\" name=\"boton\" value=\"Robar Carta\" style=\"background-color:#aa0000; font-weight:bold; color:#ffffff; border:#00ffff 5px dashed; cursor: pointer;\" title=\"Haz click aqu&iacute; para Robar Carta\"></form>";

        //Se quitan las variables de sesion con la carta usada por el ordenador:
        unset($HTTP_SESSION_VARS["numero_ordenador"]);
        unset($HTTP_SESSION_VARS["palo_ordenador"]);

        //Si aun hay cartas en la baza, se setea la variable para que sea obligatorio robar y no se pueda usar mas hasta no robar:
        if ($HTTP_SESSION_VARS["hay_cartas_en_la_baza"]) { $HTTP_SESSION_VARS["hay_que_robar"] = TRUE; }

//        $HTTP_SESSION_VARS["continuar"] = FALSE;

        if ($HTTP_SESSION_VARS["ultimo_ganador"] == "ordenador" && !$HTTP_SESSION_VARS["hay_cartas_en_la_baza"] && $HTTP_SESSION_VARS["continuar"]) { $HTTP_SESSION_VARS["continuar"] = FALSE; }

        return TRUE;    

     }
     

    //Muestra la carta el ordenador (tira su carta en la mesa):
    function mostrar_carta_ordenador($palo_usuario = "", $numero_usuario = "")
     {

        //1) Comprobar que la carta usada por el ordenador sea legal (este en la mano del ordenador).
        global $HTTP_SESSION_VARS;        
        global $numero_ordenador;
        global $palo_ordenador;
        global $cartas_jugada;
        global $errores;
        global $mensajes;

        //Si ya no quedan cartas, sale de la funcion:
        if ($HTTP_SESSION_VARS["fin_del_juego"]) { return FALSE; }

//        if ($HTTP_SESSION_VARS["ultimo_ganador"] == "ordenador" && !$HTTP_SESSION_VARS["hay_cartas_en_la_baza"] && !$HTTP_SESSION_VARS["continuar"]) { echo "<br>Se setea continuar en TRUE en la funcion mostrar_Carta_ordenador<br>"; $HTTP_SESSION_VARS["continuar"] = TRUE; }

        //Si ya no quedan cartas en la baza y no se ha enviado el boton continuar, sale de la funcion:
        //if ($HTTP_SESSION_VARS["ultimo_ganador"] == "ordenador" && !$HTTP_SESSION_VARS["hay_cartas_en_la_baza"] && !$HTTP_SESSION_VARS["continuar"]) { return FALSE; }

        //Se setean las variables a vacias, por si acaso:
        $numero_ordenador = "";
        $palo_ordenador = "";        

        //Se unsetea la matriz donde se guardaran las cartas del ordenador:
        unset($array_con_cartas_ordenador);

        foreach ($HTTP_SESSION_VARS["cartas_en_baza"] as $palo => $array)
         {
            foreach ($array as $numero => $true_o_false)
             {
                //Si se encuentra la carta en la mano del ordenador, se guarda en la array:
                if ($HTTP_SESSION_VARS["cartas_ordenador"][$palo][$numero]) { $array_con_cartas_ordenador[] = $numero.",".$palo;  }
             }
         }

        if (!isset($array_con_cartas_ordenador)) { return FALSE; }

        //Se ordena la array de menor a mayor:
        asort($array_con_cartas_ordenador);

        //Se extraen los numeros y los palos de las cartas que tiene el ordenador en mano:
        foreach ($array_con_cartas_ordenador as $indice => $valor)
         {
            //$array_con_cartas_ordenador_nuevo[] = $valor;
            $numero_y_palo_separados = explode(",", $array_con_cartas_ordenador[$indice]);
            $numero_separado[] = $numero_y_palo_separados[0];
            $palo_separado[] = $numero_y_palo_separados[1];
         }

        //Se ordena todo de menor a mayor, esta vez si xD: 
        $array_con_cartas_ordenador = "";
        asort($numero_separado);
        foreach ($numero_separado as $indice => $valor)
         {
            $array_con_cartas_ordenador[] = $valor.",".$palo_separado[$indice];
         }

        //Si se ha enviado el palo y el numero del usuario, significa que este tiro primero:
        if (trim($palo_usuario) != "" && trim($numero_usuario) != "")
         {
            //Se extrae el numero de la carta que ha usado el usuario:
            $carta_encontrada = FALSE;
            foreach($array_con_cartas_ordenador as $indice => $valor)
             {
                $array_con_cartas_ordenador_separado = explode(",",$array_con_cartas_ordenador[$indice]);
                $palo_ordenador_temporal = $array_con_cartas_ordenador_separado[1];
                $numero_ordenador_temporal = $array_con_cartas_ordenador_separado[0];

                if ($numero_ordenador_temporal >= $numero_usuario && !$carta_encontrada) { $numero_ordenador = $numero_ordenador_temporal; $palo_ordenador = $palo_ordenador_temporal; $carta_encontrada = TRUE; }
             }
            
            //if (!isset($numero_ordenador) || !isset($palo_ordenador) || isset($palo_ordenador) && trim($numero_ordenador) == "" || isset($palo_ordenador) && trim($palo_ordenador) == "" || !is_numeric($numero_ordenador)) { $errores .= "E<u>RROR</u>: <b>El ordenador no encontr&oacute; ninguna carta para usar</b><br>"; return FALSE; }

            //Si no se ha encontrado carta, se escoge la mas pequeña:
            if (!isset($carta_encontrada) || isset($carta_encontrada) && !$carta_encontrada)
             {
                //$numero_ordenador = ; $palo_ordenador = ;
                if (isset($array_con_cartas_ordenador[0])) { $carta_usada_ordenador_array = explode(",",$array_con_cartas_ordenador[0]); $numero_ordenador = $carta_usada_ordenador_array[0]; $palo_ordenador = $carta_usada_ordenador_array[1]; }
                elseif (isset($array_con_cartas_ordenador[1])) { $carta_usada_ordenador_array = explode(",",$array_con_cartas_ordenador[1]); $numero_ordenador = $carta_usada_ordenador_array[0]; $palo_ordenador = $carta_usada_ordenador_array[1]; }
                elseif (isset($array_con_cartas_ordenador[2])) { $carta_usada_ordenador_array = explode(",",$array_con_cartas_ordenador[2]); $numero_ordenador = $carta_usada_ordenador_array[0]; $palo_ordenador = $carta_usada_ordenador_array[1]; }
                elseif (isset($array_con_cartas_ordenador[3])) { $carta_usada_ordenador_array = explode(",",$array_con_cartas_ordenador[3]); $numero_ordenador = $carta_usada_ordenador_array[0]; $palo_ordenador = $carta_usada_ordenador_array[1]; }
                elseif (isset($array_con_cartas_ordenador[4])) { $carta_usada_ordenador_array = explode(",",$array_con_cartas_ordenador[4]); $numero_ordenador = $carta_usada_ordenador_array[0]; $palo_ordenador = $carta_usada_ordenador_array[1]; }
                else { $errores .= "E<u>RROR</u>: </b>El ordenador no encontro ninguna carta para usar</b><br>"; return FALSE; }
             }

            if (!isset($numero_ordenador) || !isset($palo_ordenador) || isset($palo_ordenador) && trim($numero_ordenador) == "" || isset($palo_ordenador) && trim($palo_ordenador) == "" || !is_numeric($numero_ordenador)) { $errores .= "E<u>RROR</u>: <b>El ordenador no encontr&oacute; ninguna carta para usar</b><br>"; return FALSE; }

            //Representar graficamente la jugada del ordenador y dar el mensaje:
            $mensajes .= "El ordenador usa <b>".$numero_ordenador." de ".ucfirst($palo_ordenador)."</b> contra tu <b>".$numero_usuario." de ".ucfirst($palo_usuario)."</b><br>";
            //$cartas_jugada .= "<center><table border=\"2\" width=\"80\" height=\"120\" cellspacing=\"0\" cellpadding=\"2\" align=\"center\"><tr><td align=\"center\"><center><b>".$numero_ordenador."<br>de<br>".ucfirst($palo_ordenador)."</b><br><i>ordenador</i></center></td></tr></table></center>";
             
         }
        //Si no, el ordenador tira primero:
        else
         {
            //Se usa la carta mas baja:
            if (isset($array_con_cartas_ordenador[0])) { $carta_usada_ordenador_array = explode(",",$array_con_cartas_ordenador[0]); $numero_ordenador = $carta_usada_ordenador_array[0]; $palo_ordenador = $carta_usada_ordenador_array[1]; }
            elseif (isset($array_con_cartas_ordenador[1])) { $carta_usada_ordenador_array = explode(",",$array_con_cartas_ordenador[1]); $numero_ordenador = $carta_usada_ordenador_array[0]; $palo_ordenador = $carta_usada_ordenador_array[1]; }
            elseif (isset($array_con_cartas_ordenador[2])) { $carta_usada_ordenador_array = explode(",",$array_con_cartas_ordenador[2]); $numero_ordenador = $carta_usada_ordenador_array[0]; $palo_ordenador = $carta_usada_ordenador_array[1]; }
            elseif (isset($array_con_cartas_ordenador[3])) { $carta_usada_ordenador_array = explode(",",$array_con_cartas_ordenador[3]); $numero_ordenador = $carta_usada_ordenador_array[0]; $palo_ordenador = $carta_usada_ordenador_array[1]; }
            elseif (isset($array_con_cartas_ordenador[4])) { $carta_usada_ordenador_array = explode(",",$array_con_cartas_ordenador[4]); $numero_ordenador = $carta_usada_ordenador_array[0]; $palo_ordenador = $carta_usada_ordenador_array[1]; }
            else { $errores .= "E<u>RROR</u>: </b>El ordenador no encontro ninguna carta para usar</b><br>"; return FALSE; }

            if (!isset($numero_ordenador) || !isset($palo_ordenador) || isset($palo_ordenador) && trim($numero_ordenador) == "" || isset($palo_ordenador) && trim($palo_ordenador) == "" || !is_numeric($numero_ordenador)) { $errores .= "E<u>RROR</u>: <b>El ordenador no encontr&oacute; ninguna carta para usar</b><br>"; return FALSE; }

            //Ya que el ordenador ha tirado primero, se le quita su carta de su baraja:
            $HTTP_SESSION_VARS["cartas_ordenador"][$palo_ordenador][$numero_ordenador] = FALSE;

            //Representar graficamente la jugada del ordenador y dar el mensaje:
            $mensajes .= "El ordenador usa <b>".$numero_ordenador." de ".ucfirst($palo_ordenador)."</b><br>";
            //$cartas_jugada = "<center><table border=\"2\" width=\"80\" height=\"120\" cellspacing=\"0\" cellpadding=\"2\" align=\"center\"><tr><td align=\"center\"><center><b>".$numero_ordenador."<br>de<br>".ucfirst($palo_ordenador)."</b><br><i>ordenador</i></center></td></tr></table></center>";

         }


//       $HTTP_SESSION_VARS["continuar"] = FALSE;
         
        //Se ponen las variables de sesion con el palo y el numero que ha usado el ordenador:
        $HTTP_SESSION_VARS["palo_ordenador"] = $palo_ordenador;
        $HTTP_SESSION_VARS["numero_ordenador"] = $numero_ordenador;
        return TRUE;

     }

    
    //Muestra las cartas del usuario:
    function ver_cartas()
     {
     
        //Se hacen las variables globales que vamos a necesitar:
        global $HTTP_SESSION_VARS;
        global $HTTP_GET_VARS;
        global $this_file;
        global $mensajes;
        global $errores;
        global $botones;
        global $cartas_usuario;
        global $cartas_ordenador;
        global $ver_cartas_del_ordenador;
        global $sid_oculto;

        //Texto del boton (predeterminado):
        $boton = "Error";
        
        //Determina si se acaba el juego (FALSE = no se acaba):
        $fin_juego = FALSE;
        
        //Calcular si aun hay cartas en la baza y el numero de cartas de cada usuario:
        $hay_cartas_en_la_baza = FALSE;
        $numero_de_cartas_usuario = 0;
        $numero_de_cartas_ordenador = 0;
        $mensaje_cartas_usuario = "";
        $mensaje_cartas_ordenador = "";

        $cartas_usuario = "<center><table border=\"1\" align=\"center\" height=\"120\" cellspacing=\"0\" cellpadding=\"2\"><tr>";
        $cartas_ordenador = "<center><table border=\"1\" align=\"center\" height=\"120\" cellspacing=\"0\" cellpadding=\"2\"><tr>";

        foreach ($HTTP_SESSION_VARS["cartas_en_baza"] as $palo => $array)
         {
            foreach ($array as $numero => $true_o_false)
             {
                //Si hay cartas en la baza, se setea TRUE:
                if ($HTTP_SESSION_VARS["cartas_en_baza"][$palo][$numero]) { $hay_cartas_en_la_baza = TRUE; }

                //Si se encuentra la carta en la mano del usuario, agregar una unidad al contador correspondiente:
                if ($HTTP_SESSION_VARS["cartas_usuario"][$palo][$numero])
                 {
                    $numero_de_cartas_usuario++;
                    $cartas_usuario .= "<td align=\"center\" width=\"80\"><center><b>".$numero."</b><br>de<br><b>".ucfirst($palo)."</b>";
                    if (!isset($HTTP_GET_VARS["usar"]) || isset($HTTP_GET_VARS["usar"]) && trim($HTTP_GET_VARS["usar"]) == "" || !$HTTP_SESSION_VARS["hay_cartas_en_la_baza"])
                     {
//                        if ($HTTP_SESSION_VARS["hay_cartas_en_la_baza"] || !$HTTP_SESSION_VARS["hay_cartas_en_la_baza"] && $HTTP_SESSION_VARS["ultimo_ganador"] == "usuario" || !$HTTP_SESSION_VARS["hay_cartas_en_la_baza"] && $HTTP_SESSION_VARS["ultimo_ganador"] == "ordenador" && !$HTTP_SESSION_VARS["continuar"])
  //                       {
                            if ($HTTP_SESSION_VARS["hay_cartas_en_la_baza"] || !$HTTP_SESSION_VARS["hay_cartas_en_la_baza"] && $HTTP_SESSION_VARS["continuar"] || !$HTTP_SESSION_VARS["hay_cartas_en_la_baza"] && $HTTP_SESSION_VARS["ultimo_ganador"] == "usuario")
                             {
                                $cartas_usuario .= "<br><form method=\"get\" action=\"".$this_file."\" style=\"display:inline;\"><input type=\"hidden\" name=\"usar\" value=\"".$palo."-".$numero."\">".$sid_oculto."<input type=\"submit\" name=\"boton\" value=\"usar\" style=\"background-color:#aa0000; font-weight:bold; color:#ffffff; border:#00ffff 2px dotted; cursor: pointer; cursor: hand;\" title=\"Haz click aqu&iacute; para usar esta carta\"></form>";
                             }
    //                     }
                     }
                    $cartas_usuario .= "</center></td>";
                 }

                //Si se encuentra la carta en la mano del ordenador, agregar una unidad al contador correspondiente:
                if ($HTTP_SESSION_VARS["cartas_ordenador"][$palo][$numero]) { $numero_de_cartas_ordenador++; if ($ver_cartas_del_ordenador) { $cartas_ordenador .= "<td align=\"center\" width=\"80\"><center><b>".$numero."</b><br>de<br><b>".ucfirst($palo)."</b></center></td>"; } else { $cartas_ordenador .= "<td align=\"center\" width=\"80\"><center><b>XXX</b></center></td>"; } }
             }
         }

        $cartas_usuario .= "</tr></table><i>Usuario tiene ".$numero_de_cartas_usuario." cartas</i></center>";
        $cartas_ordenador .= "</tr></table><i>Ordenador tiene ".$numero_de_cartas_ordenador." cartas</i></center>";

        //Si hay cartas en la baza...
        if ($hay_cartas_en_la_baza)
         {

            //Si el numero de cartas es 5, setear el boton "Usar Carta"
            if ($numero_de_cartas_usuario == 5 && $numero_de_cartas_ordenador == 5)
             {
                //$boton = "Usar Carta";
             }
            //Si el numero de cartas es 4, setear el boton "Robar Carta"
            elseif ($numero_de_cartas_usuario == 4 && $numero_de_cartas_ordenador == 4 && $HTTP_SESSION_VARS["hay_que_robar"])
             {
                $boton = "Robar Carta";
             }

            //Si el numero de cartas de alguno de los jugadores es menor a 4 o mayor que 6, o no tienen el mismo numero de cartas, dar un error fatal:
            //elseif ($numero_de_cartas_usuario < 4 || $numero_de_cartas_ordenador < 4 || $numero_de_cartas_usuario > 5 || $numero_de_cartas_ordenador > 5 || $numero_de_cartas_usuario != $numero_de_cartas_ordenador) { $errores .= "E<u>RROR</u>: <b>Hay cartas en la baza y/o el usuario (</b>".$numero_de_cartas_usuario."<b>) o el ordenador (</b>".$numero_de_cartas_ordenador."<b>) tienen un numero err&oacute;neo de cartas.</b><br>"; }

         }
        //Si no hay cartas en la baza...
        else
         {
            
            //Si tenemos al menos una carta, setear el boton "Usar Carta":
            if ($numero_de_cartas_usuario >= 1 && $numero_de_cartas_ordenador >= 1)
             {
                //$boton = "Usar Carta";
             }
            //Si no tenemos cartas (igual a 0), setear el boton "Jugar Otra Vez" (poner input hidden "finalizar = ok")
            if ($numero_de_cartas_usuario == 0 && $numero_de_cartas_ordenador == 0)
             {
                $boton = "Jugar Otra Vez";
                $fin_juego = TRUE;
                $HTTP_SESSION_VARS["fin_del_juego"] = TRUE;
             }

            //elseif ($numero_de_cartas_usuario < 4 || $numero_de_cartas_ordenador < 4) { $boton = "Continuar"; }
            //Si el usuario o el ordenador tienen menos de 0 cartas o mas de 5, o no tienen el mismo numero de cartas, dar un error fatal:
            //if ($numero_de_cartas_usuario < 0 || $numero_de_cartas_ordenador < 0 || $numero_de_cartas_usuario > 5 || $numero_de_cartas_ordenador > 5 || $numero_de_cartas_usuario != $numero_de_cartas_ordenador) { $errores .= "E<u>RROR</u>: <b>No hay cartas en la baza y/o el usuario (</b>".$numero_de_cartas_usuario."<b>) o el ordenador (</b>".$numero_de_cartas_ordenador."<b>) tienen un numero err&oacute;neo de cartas.</b><br>"; }

         }

        //Representar cartas y el formulario con el boton y los hidden correspondientes:
        //$mensajes .= "<i>Usuario tiene ".$numero_de_cartas_usuario." cartas</i>:<br>".$mensaje_cartas_usuario."<br>";
        //$mensajes .= "<i>Ordenador tiene ".$numero_de_cartas_ordenador." cartas</i>:<br>".$mensaje_cartas_ordenador."<br>";
       
        ?>
        <form method="get" action="<?php echo $this_file; ?>">
            <?php
                echo $sid_oculto;
                if ($fin_juego) { $botones = "<input type=\"hidden\" name=\"finalizar\" value=\"ok\">"; }
//                elseif ($boton == "Usar Carta")
//                 {
                    //Mostrar input type radio o algo asi para seleccionar la carta (name de la variable = usar, valor = carta X).
                   
//                 }
                elseif ($boton == "Robar Carta") { $botones = "<input type=\"hidden\" name=\"robar\" value=\"ok\">"; }
                if (!$HTTP_SESSION_VARS["hay_cartas_en_la_baza"] && $HTTP_SESSION_VARS["ultimo_ganador"] == "ordenador" && !$HTTP_SESSION_VARS["continuar"] && !$HTTP_SESSION_VARS["fin_del_juego"]) { $botones .= "<input type=\"hidden\" name=\"usar\" value=\"continuar-ok\"><input type=\"submit\" name=\"boton\" value=\"Continuar\" style=\"background-color:#aa0000; font-weight:bold; color:#ffffff; border:#00ffff 5px dashed; cursor: pointer; cursor: hand;\" title=\"Haz click aqu&iacute; para continuar\">"; }
                if ($boton != "Error") { $botones .= "<input type=\"submit\" name=\"boton\" value=\"".$boton."\" style=\"background-color:#aa0000; font-weight:bold; color:#ffffff; border:#00ffff 5px dashed; cursor: pointer; cursor: hand;\" title=\"Haz click aqu&iacute; para ".$boton."\">"; }
            ?>
        </form>
        
        <?php
     
     }
    
?>
