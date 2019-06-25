<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("app/views/head.php"); ?>
    <title>Codigos QR</title>
    <link rel="stylesheet" type="text/css" href="<?php echo constant("URL");?>resources/css/registro.css">
</head>
<?php 
if(isset($this->cajas) and $this->cajas != "" and $this->cajas != null){

    require_once("resources/libs/PDF/tFPDF/tfpdf.php");
    require("resources/libs/PDF/pdf/rpdf.php");

    $cajas   = $this->cajas["id"];
    $titulos = $this->cajas["title"];
    
    $totalCajas = count($cajas);
    $qrd = 70;//tamaño del codigo
    $space = 3;//espacio entre borde y codigos
    $boxesByPage = 8;//maximo de cajas que se imprimiran en pantalla
    $paginasTotales = ceil($totalCajas / $boxesByPage);//total de paginas a imprimir
    $index = 0;//contador index del array
    $o = 1;

    //posicion
    $boxPercent = 0.82;

    $pdf = new RPDF('p','mm','letter');
    $pdf -> SetFont('Arial','B',13);

    do{
        //por cada pagina
        if($paginasTotales > 0){
            $pdf->AddPage();
        }

        $posicion = 0;

        while($index < ($o*$boxesByPage) and isset($cajas[$index])){

            $level = $space + $qrd * $posicion;//altura a la que se imprimiran los codigos
            
            $pdf->TextWithDirection($space*5, $level + $qrd * $boxPercent, "ID: " . $cajas[$index], 'U');
            $pdf->TextWithDirection($space*7.5, $level + $qrd * $boxPercent, "Titulo: " . $titulos[$index],'U');
            $pdf->TextWithDirection($space*10, $level + $qrd * $boxPercent, "# " . ($index+1),'U');
            $pdf->Image(
                "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=". constant("URL") ."api/caja/$cajas[$index]&.png",
                $space*2 + $qrd/3 + 2,
                $level-4,
                $qrd,
                $qrd
            );

            $index++;

            if(isset($cajas[$index])){
                $pdf->TextWithDirection($qrd + 40, $level + $qrd * $boxPercent, "ID: " . $cajas[$index], 'U');
                $pdf->TextWithDirection($qrd + 47, $level + $qrd * $boxPercent, "Titulo: " . $titulos[$index], 'U');
                $pdf->TextWithDirection($qrd + 54, $level + $qrd * $boxPercent, "# " . ($index+1), 'U');
                $pdf->Image(
                    "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=". constant("URL") ."api/caja/$cajas[$index]&.png",
                    $qrd*1.8,
                    $level-4,
                    $qrd,
                    $qrd
                );
                $index++;
            }
            $posicion++;
        }
        
        $paginasTotales--;
        $o++;

    }while($paginasTotales > 0 and isset($cajas[$index]));

    $pdf->Output('QRCodes.pdf','I');

}else{
    echo "
    <div class='webpage'>
        <div class='window'>
            <div class='margin'>
                <h3>No hay datos por mostrar.</h3>
                <br>
                <p>Dirigete a <a href='" . constant("URL") . "'>Este sitio</a> en la seccion de administracion 
                para poder imprimir los codigos QR. Si el sistema continua mandanote este 
                mensaje a pesar de haber seguido estos pasos, contacta al programador 
                Alejandro Gómez García para que pueda brindarte ayuda sobre este error.</p>
            </div>
        </div>
    </div>
    ";
}
?>
</html>
