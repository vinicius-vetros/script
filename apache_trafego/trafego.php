<?php 

	//
	ini_set('display_errors', 1);
	error_reporting('E_ERROR | E_WARNING | E_PARSE');	

    /**
    *
    * 28/06/2023
    *
    * Análise de tráfego de domínios no Apache
    * 
    * @author VINICIUS BARSOTELI <vinicius@vetros.com.br>
    *
    */

    /*
    *
    * Instruções para UBUNTU:
    *
    * 1- Adicione essa linha no arquivo CONF de cada dominio ou no arquivo /etc/apache2/apache2.conf
    *
    * CustomLog "|/usr/sbin/rotatelogs /var/log/apache2/access-casem.log 7d" combined
    *
    * 2- Importante ter essa linha no arquivo apache2.conf para montar as informações que você quer ver no arquivo de log
    *
    * LogFormat "%h %l %u %t \"%r\" %>s %O %B \"%{Referer}i\" \"%{User-Agent}i\"" combined
    *
    * 3- Configure o logrotate
    * $ sudo nano /etc/logrotate.d/apache2
    *
    *
    **/

    // tenta abrir diretorio de logs do Apache
    if (!opendir('../../../log/apache2'))
        die('Execute sudo chmod -R 755 /var/log/apache2');

?>
<!DOCTYPE html>
<html>
<head>
<title>Análise de tráfego APACHE - Vetros</title>
<style> 
body {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 11px;
}
a {
    color: #000;
    text-decoration: none;
}
table {
    border-collapse: collapse;
    width: 100%;
}
th, td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}
table th {
    font-size: 14px;
}
tr:nth-child(even) {
    background-color: #f2f2f2;
}
</style>
</head>

<body>
<h1>Análise de tráfego APACHE (access.log)</h1>
<h2>/var/log/apache2/</h2>
<h3>Selecione um domínio para visualizar o tráfego</h3>
<?php 


    //
    $dominio = array(
        ['casem.com.br', 'casem'], 
        ['catalogo.casem.com.br', 'casem-catalogo'],
        ['shopdometal.com.br', 'shopdometal'],
        ['pedcell.com.br', 'pedcell']);

    //
    for ($i=0; $i<=sizeof($dominio); $i++)
        echo '<a href="?nome='.$dominio[$i][1].'&dominio='.$dominio[$i][0].'">'.$dominio[$i][0].'</a><br>';

    //
    if ($_GET['nome']) {

        //
        $logFile = '../../../log/apache2/access-'.$_GET['nome'].'.log'; // Replace with the path to your access.log file

        // Open the log file for reading
        $handle = fopen($logFile, 'r');

        // Check if the file was opened successfully
        if ($handle) {

            //
            $total_bytes += $bytes;

            //
            echo '<table width="100%">';
                echo '<tr>
                <th>Data</th>
                <th>IP origem</th>
                <th>Metodo</th>
                <th>URL</th>
                <th>Status code</th>
                <th>Bytes</th>
                </tr>';

            //
            $total_bytes = 0;

            // Read each line of the log file
            while (($line = fgets($handle)) !== false) {

                //
                $total_bytes += $bytes;
                
                // Split the line into an array of values
                $logData = explode(' ', $line);

                // Access individual log fields
                $ipAddress = $logData[0];
                $date = $logData[3];
                $method = $logData[5];
                $url = $_GET['dominio'].'/'.ltrim($logData[6], '/');
                $statusCode = $logData[8];
                $bytes = $logData[9];

                //
                //for ($i=0; $i<sizeof($logData); $i++)
                  //  echo $i.' = '.$logData[$i].'<br>';

                // Output the log entry
                echo '<tr>';
                echo '<td>'.str_replace('[', '', $date).'</td>';
                echo '<td>'.$ipAddress.'</td>';
                echo '<td>'.str_replace('"', '', $method).'</td>';
                echo '<td><a href="https://'.$url.'" target="_blank">'.substr($url, 0, 50).'...</a></td>';
                echo '<td>'.$statusCode.'</td>';
                echo '<td>'.number_format($bytes/1024, 2, '.', '').' KB</td>';
                echo '</tr>';

            }

            //
            echo '<tr>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td>Total tráfego:</td>';
            echo '<td>'.number_format($total_bytes / 1048576, 2, '.', '').' MB</td>';
            echo '</tr>';

            echo '</table>';

            // Close the file handle
            fclose($handle);
        } else
            echo 'Falha ao abrir o arquivo de log, verifique permissões em /var/log/apache2';

    }

?>
</body>

</html>
