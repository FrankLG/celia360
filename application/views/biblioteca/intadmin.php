 <link rel='stylesheet' href=https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css>
    

    <style type="text/css">
           
        label{
        
            margin-left: 10px;
        
        }
        
        #caja input[type=text]{
            
            width:70%;            
        }
        
        .img-cerrar{
         
            width: 20px; height: 20px;
        }
 
        .cerrar{
            
            position:relative;
            top:-428px;
            left:45%;
        }
        
        .cerrar1{
            position:relative;
            top:-388px;
            left:45%;
        }
        .cerrarBorrar{
            position:relative;
            top:-192px;
            left:47%;
        }
    </style>

    <script>
	<?php
	    //echo "var tabla_json = '".json_encode($tabla)."';";
	?>
	    var tabla_json = '[{"id_libro":"5","titulo":"Apuntes para una historia del Instituto Celia Viñas de Almera","autor":"D.Trino Gomez Ruiz","editorial":"I.E.S Celia Viñs","lugar_edicion":"Almeria","fecha_edicion":"2013-10-01","ISBN":"565989","tipo":"1","apaisado":"0"},{"id_libro":"6","titulo":"Nacimiento y primeros pasos de un edificio: el I.E.S Celia Viñas","autor":"D.Jose Luis Ruz Marquez","editorial":"I.E.S Celia Viñas","lugar_edicion":"Almeria","fecha_edicion":"2000-10-08","ISBN":"0","tipo":"1","apaisado":"0"},{"id_libro":"7","titulo":"Gramática elemental de la lengua castellana","autor":"D.Hilario del Olmo Minguez","editorial":"almeria","lugar_edicion":"Almeríaa","fecha_edicion":"1808-05-01","ISBN":"2","tipo":"1","apaisado":"0"},{"id_libro":"8","titulo":"Sumario de psicología","autor":"D.Agustín Arredondo Garcíaa","editorial":"a","lugar_edicion":"Valladolid","fecha_edicion":"2018-01-14","ISBN":"46","tipo":"1","apaisado":"0"},{"id_libro":"9","titulo":"El esplendor de Almería en el siglo XI","autor":"E. Castro Guisola","editorial":"Caja Rural Intermediterránea, Cajama.","lugar_edicion":"Almeria","fecha_edicion":"2018-01-28","ISBN":"8495531186","tipo":"1","apaisado":"1"},{"id_libro":"10","titulo":"Exposición y critica de la doctrina transformista","autor":"Agustin Arredondo","editorial":"D. Mariano Alvares y Robles","lugar_edicion":"Almería","fecha_edicion":"2018-01-05","ISBN":"7","tipo":"1","apaisado":"0"}]';

		var tabla = JSON.parse(tabla_json);
	    var id_columna = 'titulo';


	    function ordenarCampo(campo) {
	        id_columna = campo;
	        tabla.sort(ordenacion);
	        html = "<table id='cont' style='margin-top:10px;'><tr id='cabecera'><th>Id<a href='#' onClick='ordenarCampo(\"id_libro\")'><i title='Ordenar' class='fas fa-caret-down' aria-hidden='true'></i></a></th><th>Titulo<a href='#' onClick='ordenarCampo(\"titulo\")'><i title='Ordenar' class='fas fa-caret-down' aria-hidden='true'></i></a></th><th>Autor<a href='#' onClick='ordenarCampo(\"autor\")'><i title='Ordenar' class='fas fa-caret-down' aria-hidden='true'></i></a></th><th>Editorial<a href='#' onClick='ordenarCampo(\"editorial\")'><i title='Ordenar' class='fas fa-caret-down' aria-hidden='true'></i></a></th><th>Lugar de edicion<a href='#' onClick='ordenarCampo(\"lugar_edicion\")'><i title='Ordenar' class='fas fa-caret-down' aria-hidden='true'></i></a></th><th>Fecha de edicion<a href='#' onClick='ordenarCampo(\"fecha_edicion\")'><i title='Ordenar' class='fas fa-caret-down' aria-hidden='true'></i></a></th><th>ISBN<a href='#' onClick='ordenarCampo(\"ISBN\")'><i title='Ordenar' class='fas fa-caret-down' aria-hidden='true'></i></a></th><th>Tipo<a href='#' onClick='ordenarCampo(\"tipo\")'><i title='Ordenar' class='fas fa-caret-down' aria-hidden='true'></i></a></th><th>Apaisado<a href='#' onClick='ordenarCampo(\"apaisado\")'><i title='Ordenar' class='fas fa-caret-down' aria-hidden='true'></i></a></th><td colspan='3'><a href='/biblioteca/showinsertlibro'><i class='fa fa-plus' aria-hidden='true'></i><i title='Insertar libro' class='fa fa-book' aria-hidden='true'></i></a></td></tr>";
	        for(var i in tabla)  {
	            fila = tabla[i];
	            html = html + "<tr id='libro" + fila['id_libro'] + "'><td>" + fila["id_libro"] + "</td><td>" + fila["titulo"] + "</td><td>" + fila["autor"] + "</td><td>" + fila["editorial"] + "</td><td>" + fila["lugar_edicion"] + "</td><td>" + fila["fecha_edicion"] + "</td><td>" + fila["ISBN"] + "</td><td>" + fila["tipo"] + "</td><td>" + fila["apaisado"] + "</td><td></td><td><a href='/biblioteca/showmodificarlibro/" + fila["id_libro"] + "'><i title='Modificar' class='fa fa-edit' aria-hidden='true'></i></a><td><a href='/biblioteca/showinsertimg/" + fila["id_libro"] + "'><i title='Insertar Páginas' class='fas fa-file-alt' aria-hidden='true'></i></a></td><td><a href='#' onClick='borrarlibro(" + fila['id_libro'] + ")'><i title='Eliminar' class='fa fa-trash' aria-hidden='true'></i></a></td><td><a href='/biblioteca/verLibro/" + fila["id_libro"] + "'>Ver libro</a></td></tr>";
	        }
	        html = html + "</table>";
	        $("#cont").empty();
	        $("#cont").html(html);

	    }


	    function ordenacion(a, b) {

	        if (eval("a."+id_columna) === eval("b."+id_columna)) {
	            return 0;
	        }
	        else {
	            return (eval("a."+id_columna) < eval("b."+id_columna)) ? -1 : 1;
	        }
	    }


	</script>

    <div>
        <?php

          
            echo"<a class='insert' onclick='mostrar()' > <i class='fas fa-plus-circle'></i> Insertar Libro</a>"; 
            echo "<table id='cont' style='margin-top:10px;'>";
                    echo "<tr id='cabecera'>
                            <th>Id<a href='#' onClick='ordenarCampo(\"id_libro\")'><i title='Ordenar' class='fas fa-caret-down' aria-hidden='true'></i></a></th>
                            <th>Titulo<a href='#' onClick='ordenarCampo(\"titulo\")'><i title='Ordenar' class='fas fa-caret-down' aria-hidden='true'></i></a></th>
                            <th>Autor<a href='#' onClick='ordenarCampo(\"autor\")'><i title='Ordenar' class='fas fa-caret-down' aria-hidden='true'></i></a></th>
                            <th>Editorial<a href='#' onClick='ordenarCampo(\"editorial\")'><i title='Ordenar' class='fas fa-caret-down' aria-hidden='true'></i></a></th>
                            <th>Lugar de edicion<a href='#' onClick='ordenarCampo(\"lugar_edicion\")'><i title='Ordenar' class='fas fa-caret-down' aria-hidden='true'></i></a></th>
                            <th>Fecha de edicion<a href='#' onClick='ordenarCampo(\"fecha_edicion\")'><i title='Ordenar' class='fas fa-caret-down' aria-hidden='true'></i></a></th>
                            <th>ISBN<a href='#' onClick='ordenarCampo(\"ISBN\")'><i title='Ordenar' class='fas fa-caret-down' aria-hidden='true'></i></a></th>
                            <th>Tipo<a href='#' onClick='ordenarCampo(\"tipo\")'><i title='Ordenar' class='fas fa-caret-down' aria-hidden='true'></i></a></th>
                            <th>Apaisado<a href='#' onClick='ordenarCampo(\"apaisado\")'><i title='Ordenar' class='fas fa-caret-down' aria-hidden='true'></i></a></th>
                            <th>Modificar</th>
                            <th>Páginas</th>
                            <th>Eliminar</th>
                            
                           </tr>";


               
                /*echo "<a href='index.php?accion=showinsertlibro'><i class='fa fa-plus' aria-hidden='true'></i><i title='Insertar libro' class='fa fa-book' aria-hidden='true'></i></a>";*/
                foreach ($tabla as $usu) {
                    $id = $usu['id_libro'];
                    echo "<tr id='libro".$id."'>
                            <td >".$usu["id_libro"]."</td>
                            <td id='titulo_libro_".$id."'>".$usu["titulo"]."</td>
                            <td id='autor_libro_".$id."'>".$usu["autor"]."</td>
                            <td id='editorial_libro_".$id."'>".$usu["editorial"]."</td>
                            <td id='lugar_edicion_".$id."'>".$usu["lugar_edicion"]."</td>
                            <td id='fecha_edicion_".$id."'>".$usu["fecha_edicion"]."</td>
                            <td id='isbn_libro_".$id."'>".$usu["ISBN"]."</td>";
                            if($usu["tipo"]==0){
                                echo "<td>Biblioteca</td>";
                              }else{
                                echo "<td>Historia</td>";
                              }
                              if($usu["apaisado"]==0){
                                echo "<td>Normal</td>";
                              }else{
                                echo "<td>Apaisado</td>";
                              }                            
                            echo" <td>
                            <a onclick='mostrarm(".$usu['id_libro'].")'> <i class='fa fa-edit' style='font-size:20px;'></i></a>
                            <td><a href='".site_url("/biblioteca/showinsertimg/".$usu["id_libro"])."'><i class='fas fa-file-alt' style='font-size:20px;'></i></a></td>
                            <td><a href='#' onclick='mostrarborrar(".$usu['id_libro'].")'><i title='Eliminar' class='fa fa-trash' aria-hidden='true'></i></a></td>

                           </tr>";
                }
                echo "</table>";

                //Modal confirmacion eliminar libro
                echo"<div id='eliminarLibro'>
                      <div id='caja'>
                          <h1>Procede a eliminar el libro: <span id='idlibroborrar' ></span> </h1>
                          <form action='".site_url("biblioteca/deletelibro")."' method='get'>

                          <label>¿Desea eliminar el directorio que contiene las imagenes?</label>
                            <select name = 'bcarpeta'>
                              <option value='0'selected>No</option>
                              <option value='1'>Si</option>
                            </select>
                            <span class='highlight'></span>
                            <span class='bar'></span>

                            <input id='borrar_id_libro' type='hidden' name='id_libro'>
                            <input class='boton' type='submit' value='Eliminar'>
                          </form>

                        <a class='cerrarBorrar' href='#' onclick='cerrar()'><img class='img-cerrar' src='" .
                        base_url("assets/css/cerrar_icon.png") . "'></img></a>
                      </div>
                    </div>";
                //MODAL MODIFICAR LIBROS
                echo "<div id='modificar'>";
                echo "<div id='caja'>";
                    echo "
                    <h1>Modificar Libro</h1>
                        <div >
                            <form id='xxx' action='".site_url("biblioteca/modifiedLibro/")."' method='get'>
                                <div class='group'>      
                                  <input type='text' name='titulo' id='modif_titulo'  required>
                                  <span class='highlight'></span>
                                  <span class='bar'></span>
                                  <label>Titulo</label>
                                </div>
                                <div class='group'>      
                                  <input type='text' name='autor' id='modif_autor' required>
                                  <span class='highlight'></span>
                                  <span class='bar'></span>
                                  <label>Autor</label>
                                </div>
                                <div class='group'>      
                                  <input type='text' name='editorial' id='modif_editorial' required>
                                  <span class='highlight'></span>
                                  <span class='bar'></span>
                                  <label>Editorial</label>
                                </div>
                                <div class='group'>      
                                  <input type='text' name='lugar_edicion' id='modif_lugar_edicion' required>
                                  <span class='highlight'></span>
                                  <span class='bar'></span>
                                  <label>Lugar de Edición</label>
                                </div>
                                <div class='group'>      
                                  <input type='date' name='fecha_edicion' id='modif_fecha_edicion' required>
                                  <span class='highlight'></span>
                                  <span class='bar'></span>
                                  <label>Fecha de Edicion</label>
                                </div>
                                <div class='group'>      
                                  <input type='text' name='ISBN' id='modif_isbn' >
                                  <span class='highlight'></span>
                                  <span class='bar'></span>
                                  <label>I S B N </label>
                                </div>";

                                if($usu["tipo"]==0){
                                  echo"
                                  <div class='group'>      
                                    <select name='tipo'>
                                      <option value='0'selected>Biblioteca</option>
                                      <option value='1'>Historia</option>
                                    </select>
                                    <span class='highlight'></span>
                                    <span class='bar'></span>
                                    <label>Tipo</label>
                                  </div>";
                                }else{
                                  echo"
                                  <div class='group'>      
                                    <select name='tipo'>
                                      <option value='0'>Biblioteca</option>
                                      <option value='1'selected>Historia</option>
                                    </select>
                                    <span class='highlight'></span>
                                    <span class='bar'></span>
                                    <label>Tipo</label>
                                  </div>";
                                }
                                if ($usu["apaisado"]==0) {
                                   echo"
                                  <div class='group'>      
                                    <select name='apaisado'>
                                      <option value='0' selected>No</option>
                                      <option value='1'>Si</option>
                                    </select>
                                    <span class='highlight'></span>
                                    <span class='bar'></span>
                                    <label>Apaisado</label>
                                  </div>";
                                }else{
                                    echo"
                                    <div class='group'>      
                                      <select name='apaisado'>
                                        <option value='0'>No</option>
                                        <option value='1' selected>Si</option>
                                      </select>
                                      <span class='highlight'></span>
                                      <span class='bar'></span>
                                      <label>Apaisado</label>
                                    </div>";
                                  }
                                echo"
                            <input type='hidden' id='modif_id_libro' name='id_libro'>
                            <input type='submit' class='enviar'>
                        </form>
                        <a class='cerrar1' href='#' onclick='cerrar()'><img class='img-cerrar' src='" .
                        base_url("assets/css/cerrar_icon.png") . "'></img></a>
                    </div> ";
                 echo "</div>";
                 echo "</div>";


                 //MODAL INSERTAR LIBROS

                 echo "<div id='insertar'>";
                 echo "<div id='caja'>";
                 echo"

                    <h1>Insertar libro</h1>
                    <div >
                        <form action='".site_url("biblioteca/insertlibro")."' method='get'>
                            <div class='group'>      
                              <input type='text' name='titulo' required>
                              <span class='highlight'></span>
                              <span class='bar'></span>
                              <label>Titulo</label>
                            </div>
                            <div class='group'>      
                              <input type='text' name='autor' required>
                              <span class='highlight'></span>
                              <span class='bar'></span>
                              <label>Autor</label>
                            </div>
                            <div class='group'>      
                              <input type='text' name='editorial' required>
                              <span class='highlight'></span>
                              <span class='bar'></span>
                              <label>Editorial</label>
                            </div>
                            <div class='group'>      
                              <input type='text' name='lugar' required>
                              <span class='highlight'></span>
                              <span class='bar'></span>
                              <label>Lugar de Edición</label>
                            </div>
                            <div class='group'>      
                              <input type='date' name='fecha' value='Fecha de Edición' required>
                              <span class='highlight'></span>
                              <span class='bar'></span>
                              <label>Fecha de Edición</label>
                            </div>
                            <div class='group'>      
                              <input type='text' name='isbn' required>
                              <span class='highlight'></span>
                              <span class='bar'></span>
                              <label>I S B N </label>
                            </div>
                            <div class='group'>      
                              <select name='tipo'>
                                <option value='0' selected>Biblioteca</options>
                                <option value='1'>Historia</options>
                              </select>
                              <span class='highlight'></span>
                              <span class='bar'></span>
                              <label>Tipo</label>
                            </div>
                            <div class='group'>      
                              <select name='apaisado'>
                                <option value='0'selected >No</options>
                                <option value='1' >Si</options>
                              </select>
                              <span class='highlight'></span>
                              <span class='bar'></span>
                              <label>Apaisado</label>
                            </div>

                           <br/><br/>
                            <input class='boton' type='submit'>
                        </form>
                        <a class='cerrar' href='#' onclick='cerrar()'><img class='img-cerrar' src='" .
                        base_url("assets/css/cerrar_icon.png") . "'></img></a>
                    </div>
                ";
                 echo "</div>";
                 echo "</div>";

    ?>

     <script >


            function respuesta(r){
                if(r==0){
                    alert("Error");
                }else{
                    selector = "#libro"+parseInt(r);
                    $(selector).remove();
                }
            }

            function mostrarm(id_libro){
                titulo = document.getElementById("titulo_libro_"+id_libro).innerHTML;
                autor = document.getElementById("autor_libro_"+id_libro).innerHTML;
                editorial = document.getElementById("editorial_libro_"+id_libro).innerHTML;
                lugar_edicion = document.getElementById("lugar_edicion_"+id_libro).innerHTML;
                fecha_edicion = document.getElementById("fecha_edicion_"+id_libro).innerHTML;
                isbn = document.getElementById("isbn_libro_"+id_libro).innerHTML;
                pasar_id=id_libro;

                $("#modif_titulo").val(titulo);
                $("#modif_autor").val(autor);
                $("#modif_editorial").val(editorial);
                $("#modif_lugar_edicion").val(lugar_edicion);
                $("#modif_fecha_edicion").val(fecha_edicion);
                $("#modif_isbn").val(isbn);
                $("#modif_id_libro").val(pasar_id);

                $("#modificar").show();
            }

            function mostrarborrar(id_libro){

                b_idlibro=id_libro;
                $("#borrar_id_libro").val(b_idlibro);
                $("#idlibroborrar").text(b_idlibro);

                $("#eliminarLibro").show();
            }

            function borrarlibro(){
                id_libro=$("borrar_id_libro").val();
                alert(id_libro);
                confirmacion=confirm("¿Estas seguro que desea borrar el libro?");

                if(confirmacion==true)
                  $.get("<?php echo base_url('biblioteca/deletelibro/');?>"+id_libro,null,respuesta);

            }

            function mostrar(){
                $("#insertar").show();
                
            }

            function alertid(id_libro){
               alert("EL nombre de la carpeta que contenga el libro debera ser: "+id_libro);
            }
            function cerrar(){
              
                $("#insertar").hide();
                $("#modificar").hide();
                $("#eliminarLibro").hide();

            }  

            function ordenacion(a, b) {

		        if (eval("a."+id_columna) === eval("b."+id_columna)) {
		            return 0;
		        }
		        else {
		            return (eval("a."+id_columna) < eval("b."+id_columna)) ? -1 : 1;
		        }
		    }
        
    </script>

</div>




