<?php
    //Se configura el BBClone:
    define("_BBC_PAGE_NAME", "spanish online");
    define("_BBCLONE_DIR", "../bbclone/");
    define("COUNTER", _BBCLONE_DIR."mark_page.php");
    if (is_readable(COUNTER)) include_once(COUNTER);

    //Programa por Juan Alba Maldonado (granvino@granvino.com).
    //Dedicado a Yasmina Llaveria del Castillo.


    //index.php - Indice del juego.


    //Se inicia sesion o se continua:
    session_name("lcma");
	session_start(); //session_start("lcma"); //For PHP7 compatibility (Added on 27 SEP 2018).

	//For PHP5 compatibility (Added on 27 SEP 2018):
	if (!isset($HTTP_GET_VARS) || isset($_GET)) { $HTTP_GET_VARS = &$_GET; }
	if (!isset($HTTP_SESSION_VARS) || isset($_SESSION)) { $HTTP_SESSION_VARS = &$_SESSION; }
    
    //Variable que define cual es esta pagina:
    $this_file = "index.php";
    
    //Variable para el modo debug, para ver las cartas del ordenador:
    $ver_cartas_del_ordenador = FALSE;

    //Se crea un input type hidden en una variable con el SID, por si el navegador no tiene soportadas la cookies. Si soporta las cookies, la variable estara vacia pero seteada:
    if (SID) { $sid_oculto = "<input type=\"hidden\" name=\"".session_name()."\" value=\"".session_id()."\">"; }
    else { $sid_oculto = ""; }

    //Se calcula si se ha enviado por GET el comenzar partida:
    if (isset($HTTP_GET_VARS["comenzar"]) && $HTTP_GET_VARS["comenzar"] == "ok") { $HTTP_SESSION_VARS["partida_comenzada"] = TRUE; unset($HTTP_SESSION_VARS["cartas_usadas"]); unset($HTTP_SESSION_VARS["puntuacion_ordenador"]); unset($HTTP_SESSION_VARS["puntuacion_usuario"]); unset($HTTP_SESSION_VARS["ultimo_ganador"]); unset($HTTP_SESSION_VARS["palo_ordenador"]); unset($HTTP_SESSION_VARS["numero_ordenador"]); unset($HTTP_SESSION_VARS["hay_que_robar"]); }
    //...o el finalizar partida:
    elseif (isset($HTTP_GET_VARS["finalizar"]) && $HTTP_GET_VARS["finalizar"] == "ok") { $HTTP_SESSION_VARS["partida_comenzada"] = FALSE; unset($HTTP_SESSION_VARS["cartas_usadas"]); unset($HTTP_SESSION_VARS["puntuacion_ordenador"]); unset($HTTP_SESSION_VARS["puntuacion_usuario"]); unset($HTTP_SESSION_VARS["ultimo_ganador"]); }

?>
<html>
    <head>
        <title>La Carta M&aacute;s Alta</title>
    </head>
    <body bgcolor="#0000aa" text="#ffffff" link="#dddddd" vlink="dddddd" alink="dddddd">
        <center>
            <h1 align="center">La Carta M&aacute;s Alta</h1>
        </center>
        <?php

            //Si la partida esta comenzada, se incluye el juego:
            if (isset($HTTP_SESSION_VARS["partida_comenzada"]) && $HTTP_SESSION_VARS["partida_comenzada"]) { include "juego.php"; }
            //...o si no, se incluye el boton para comenzarla:
            else
             {

        ?>
            <center>
                <form method="get" action="<?php echo $this_file; ?>">
                    <?php echo $sid_oculto; ?>
                    <input type="hidden" name="comenzar" value="ok">
                    <input type="submit" name="boton" value="Comenzar juego" style="background-color:#aa0000; font-weight:bold; color:#ffffff; border:#00ffff 5px dashed; cursor: pointer; cursor: hand;" title="Haz click aqu&iacute; para comenzar">
                </form>
            </center>
        <?php

             }

        ?>
        <br>
        <center>
            <font color="#bbbbbb" size="1" face="arial">Dedicado a Yasmina Llaveria del Castillo<br>Programa por Juan Alba Maldonado (<a href="mailto:granvino@granvino.com;">granvino@granvino.com</a>)</font>
        </center>
    </body>
</html>
