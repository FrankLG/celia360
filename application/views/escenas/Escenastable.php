<?php 
	if (isset($datos["error"])) {
			echo "<p style='color:red'>".$datos["error"]."</p>";
	}
	
	if (isset($datos["mensaje"])) {
		echo "<p style='color:blue'>".$datos["mensaje"]."</p>";
	}
	
?>

<script type="text/javascript">
  base_url = "<?php echo base_url();?>";
    
    $(document).ready(function(){                   
        
        $(".imagenes").click(function(){
            var enlace = base_url+"assets/imagenes/escenas/"+$(this).parent().prev().find(".cod").text()+".JPG";
            $(this).html("<img src='"+enlace+"' width='1250' height='470' align='center'>");
        });
                    

        $(".imagenes").contextmenu(function(event){             
            event.preventDefault();
            $(this).html("<i class='fa fa-eye' style='font-size:40px;'></i>");
        });
        
        $("#btn-admin-selector-zonas").click(function(){
		    location.href = base_url+"zonas/"
	    })
           
    });
    
/**
 * Esta función se ejecuta al pulsar el boton "Papelera" (borrar) de una escena de la tabla.
 * Lanza el borrado en el servidor mediante Ajax.
 * @param {String} cod Código de la escena que se va a borrar.
 **/    
function borrarscene(cod) {
	resultado = confirm("¿Está seguro de que quiere borrar esta escena?\n\nCUIDADO: esta acción no se puede deshacer.");
	var fila = "#fila"+cod;
	if (resultado) {
		url = "<?php echo base_url('/escenas/deletesceneAjax/'); ?>" +cod;
		$.ajax(url)
		.done(function(data){
			if(data.trim() > 0){
				$('#error_cabecera').html('');
				$('#mensaje_cabecera').html("<div class='alert alert-success ' role='alert' ><h7 class='mr-2'>Escena eliminada con éxito</h7><i class='far fa-check-circle'></i></div>");
				$(fila).remove();
			}else{
				$('#error_cabecera').html("<div class='alert alert-danger ' role='alert' ><h7 class='mr-2'>Error al eliminar la escena</h7><i class='fas fa-exclamation-circle'></i></div>")
				$('#mensaje_cabecera').html('');
			}
		});		
	}
}
            
              
                            
</script>

<div class="container mt-5">

	<div class="row">
		<div class="col-md-8 col-xs-12">
            <div id="mapa_escena">
<?php
	  $indice = 0;


      foreach ($mapa as $imagen) {

            echo "<div id='zona".$indice."' class='pisos' style='display: none;'>";
			echo "<img class='img-fluid' src='".base_url($imagen['url_img'])."' alt='zona$indice'>";
			
          foreach ($puntos as $punto) {

            if($punto['piso']==$indice){

			  $nombre_punto = $punto["id_escena"];
			  $salida = false;
			  foreach ($escenas_secundarias as $pan_sec){
				if($pan_sec['id_punto_mapa'] == $punto['id_punto_mapa']){
					$salida = true;
				}
			  }
			  
			  if($salida){
				echo "<div id='punto".$punto['id_punto_mapa']."' class='puntos tienePanoramas' style='left: ".$punto['left_mapa']."%; top: ".$punto['top_mapa']."%;' escena='".$punto['id_escena']."'>
				<span class='tooltipi'>Punto: ".$punto['id_punto_mapa']." - Escena: ".$nombre_punto."</span>
				</div>";
			  }else{

				echo "<div id='punto".$punto['id_punto_mapa']."' class='puntos' style='left: ".$punto['left_mapa']."%; top: ".$punto['top_mapa']."%;' escena='".$punto['id_escena']."'>
				<span class='tooltipi'>Punto: ".$punto['id_punto_mapa']." - Escena: ".$nombre_punto."</span>
				</div>";
			  }
			
              
            }
          }
		echo "</div>";
		
        $indice++;
	  }
?>
    </div>
</div>

<div class="col-md-4">
	<div class="card">
		<div class="card-body text-center">
		<?php
 if(count($mapa)==0){
     ?>
        <button class="botonmapa btn btn-primary m-3 w-75 text-center" id="btn-admin-mapa">Añadir mapa</button>
     <?php
 }else{
    ?>
        <div class="row">
            <div class="col-md-12">
                <button class="botonmapa btn btn-primary m-3 w-75 text-center" id="btn-subir-piso">Subir zona</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="botonmapa btn btn-primary m-3 w-75 text-center" id="btn-bajar-piso">Bajar zona</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="botonmapa btn btn-primary m-3 w-75 text-center" id="btn-admin-mapa">Admin mapa</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="botonmapa btn btn-primary m-3 w-75 text-center" id="btn-admin-selector-zonas">Admin selector de zonas</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="botonmapa btn btn-primary m-3 w-75 text-center" id="btn-show-pan-sec">Ver panoramas asociados</button>
            </div>
        </div>

     <?php
 }

?>
		</div>
	</div>

</div>
</div> <!-- cierre .row -->

    <div class="row mt-3">
        <div class="col-md-12">
<?php
if(count($mapa)!=0){
	echo "<table class='table table-hover bg-secondary' id='cont'>";
	echo "<thead><tr id='cabecera'> 
		  <th> IdEscena</th>
		  <th>Previsualizar</th>
		  <th> Nombre del lugar </th>
		  <th> Codigo Escena </th>
		  <th> Pitch </th>
		  <th> Yaw </th>
		  <th> Eliminar </th>
		  <th> Modificar </th>
		  </tr></thead>";
	echo "<tfoot><tr id='cabecera'> 
		  <th> IdEscena</th>
		  <th>Previsualizar</th>
		  <th> Nombre del lugar </th>
		  <th> Codigo Escena </th>
		  <th> Pitch </th>
		  <th> Yaw </th>
		  <th> Eliminar </th>
		  <th> Modificar </th>
		  </tr></tfoot><tbody>";
	
        if (count($tablaEscenas) == 0) {
            echo "<tr><td align='center' colspan='7'>No hay registros para mostrar.</td></tr>";
        }
        else {
			
            foreach ($tablaEscenas as $escenas){

            $id=$escenas["id_escena"];
            $cod=$escenas["cod_escena"];
                    echo "<tr id='fila".$cod."'>

				<td align='center'>".$escenas['id_escena']."</td>
				<th>
				<div class='custom-hotspot-info' id='".$escenas['cod_escena']."'> 
					<span class='oculto'>".base_url($escenas['panorama'])."</span>
				</div>

				<div id='panorama-".$escenas['cod_escena']."' class='panoramas oculto'>
				</div>
				</th>
                <td align='center'>".$escenas['Nombre']."</td>
                <td align='center' class='cod'>".$escenas['cod_escena']."</td>
                <td align='center'>".$escenas['pitch']."</td>
                <td align='center'>".$escenas['yaw']."</td>

                <td align='center'>
                <a onclick='borrarscene(".$escenas["id_escena"].")'><i class='fa fa-trash text-primary' style='font-size:30px;'></i></a>
                </td>

                <td align='center'>
                <a href= '".site_url("/escenas/showUpdateScene/".$escenas['cod_escena'])."'> <i class='fa fa-edit text-primary' style='font-size:30px;'></i> </a></td>
                </tr>";
    ?>
    <?php
            }
        } // else
        echo "</tbody></table>";
    }
?>

        </div><!-- Final de col-->
    </div><!-- Final de row -->
</div><!-- Final de container -->
<script>

$(document).ready(function() {
	$.fn.dataTable.ext.errMode = 'throw';
        $('#cont').dataTable({

    	"language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontraron resultados en su búsqueda",
            "searchPlaceholder": "Buscar registros",
            "info": "Mostrando registros de _START_ al _END_ de un total de  _TOTAL_ registros",
            "infoEmpty": "No existen registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "search": "Buscar:",
            "paginate": {
	            "first":    "Primero",
	            "last":    "Último",
	            "next":    "Siguiente",
	            "previous": "Anterior"
	    },
        }
        });
    });

	$(document).ready(function(){
		$("#btn-show-pan-sec").click(function(){
			if ($('.puntos.tienePanoramas').css('background-color') == 'rgb(255, 255, 255)'){
				$('.puntos.tienePanoramas').css('background','red');
				$(this).css('background-color','#c38107');
			}else{
				$('.puntos.tienePanoramas').css('background','white');
				$('.puntos.tienePanoramas').css('color','rgb(0, 0, 0)');
				$(this).css('background-color','#DF691A');
			}
		});
	});
</script>

<script>

    $(document).ready(function(){
		$("#cont").on("click", ".custom-hotspot-info", function(){
            id = $(this).attr('id');
            img = $(this).find('span').text();

            pannellum.viewer('panorama-'+id, {
                "type": "equirectangular",
                "panorama": img,
                "autoLoad": true
            });
            $('#panorama-'+id).toggleClass('oculto');
        });
    });


</script>
      
