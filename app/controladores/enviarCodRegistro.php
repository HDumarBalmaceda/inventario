<?php
function enviarCodigoWhatsapp($nombreUsuario, $correo, $codigo) {
    $token = "x8dyl34vuk40mh6q"; // Reemplaza con tu token válido
    $instance_id = "instance128328";
    $telefono_destino = "573203877354"; // aqui en lo ultimo va un 4 

    $mensaje = "🍩 *¡Bienvenido a Dunkin’ Inventario!* 🍩\n"
             . "────────────────────────────\n"
             . "👤 *Nombre:* $nombreUsuario\n"
             . "📧 *Correo:* $correo\n"
             . "🔐 *Tu código de verificación:* *$codigo*\n"
             . "⏳ *Válido por:* 3 minutos\n"
             . "────────────────────────────\n"
             . "☕ Usa este código para completar tu registro en nuestro sistema.\n"
             . "¡Gracias por ser parte de la familia *Dunkin’*! 💜🧡";

    $url = "https://api.ultramsg.com/$instance_id/messages/chat";
    $data = [
        'token' => $token,
        'to' => $telefono_destino,
        'body' => $mensaje
    ];

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_exec($curl);
    curl_close($curl);
}
?>