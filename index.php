<?php 

/**
 * $argv[0] = é o nome do script ex. index.php
 * $argv[1] = é o ano inicial
 * $argv[2] = é o ano final
 * $argv[3] = é o status de exibição do log, se true exibe o log durante o processo. padrão false
 */

$ano_inicial=isset($argv[1])  && intval($argv[1])?$argv[1]:2009;
$ano_final=isset($argv[2])  && intval($argv[2]) ?$argv[2]:2019;
$show_log=isset($argv[3]) && $argv[3]==true ?$argv[3]:false;


 $resultado=array();

 for ($ano=$ano_inicial;$ano <= $ano_final; $ano++) { 
    
  $resultado[$ano]=  renomeia_arquivos($ano);
  

}
print('Processo finalizado!');

if($show_log){
    print_r($resultado);
}

  function utf8Fix($msg){
    $accents = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç");
    $utf8 = array("Ã¡","Ã ","Ã¢","Ã£","Ã¤","Ã©","Ã¨","Ãª","Ã«","Ã­","Ã¬","Ã®","Ã¯","Ã³","Ã²","Ã´","Ãµ","Ã¶","Ãº","Ã¹","Ã»","Ã¼","Ã§","Ã","Ã€","Ã‚","Ãƒ","Ã„","Ã‰","Ãˆ","ÃŠ","Ã‹","Ã","ÃŒ","ÃŽ","Ã","Ã“","Ã’","Ã”","Ã•","Ã–","Ãš","Ã™","Ã›","Ãœ","Ã‡");
    $fix = str_replace($utf8, $accents, $msg);
    return $fix;
    }

function renomeia_arquivos($ano){
    $log_file = fopen("log.txt", "w") or die("Unable to open file!");

    $meses=array('01','02','03','04','05','06','07','08','09','10','11','12');
    $files=array();
    $total=array();
    
    $log= 'Ano: '.$ano.'\n';

    fwrite($log_file, $log);

    foreach ($meses as  $value) {
        $log= '---Mês: '.$value.'\n';

        fwrite($log_file, $log);

        $local="$ano".'/'."$value".'/*';
     
        $files= glob($local);


        if($files){
            $total[$local]=count($files);

            foreach( $files as $filename){
                $log= '------arquivos_nome_original: '.$filename.'\n';
                fwrite($log_file, $log);

                rename( "$filename", utf8Fix($filename));
             
            }
        }
    }
    
    fclose($log_file);

    return $total;


}




