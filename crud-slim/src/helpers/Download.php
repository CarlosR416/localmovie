<?php  

namespace App\Helpers;


class Download 
{

	function image($url, $img){
        
        $direccion=trim($img);
        $direccionweb = $direccion;
        $metodocurl = curl_init();
        curl_setopt($metodocurl, CURLOPT_URL, $direccionweb);
        curl_setopt($metodocurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($metodocurl, CURLOPT_SSLVERSION,3);
        $curlDatos = curl_exec ($metodocurl);

        curl_close ($metodocurl);

        // Declaramos la ruta para almacenar los archivos descargados
        $rutadescarga = $url;

        $miarchivo = fopen($rutadescarga, "w+");

        fputs($miarchivo, $curlDatos);

        fclose($miarchivo);

        return true;
    }

}


?>