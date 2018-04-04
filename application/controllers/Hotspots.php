<?php
      
defined('BASEPATH') OR exit('No se permite el acceso directo al script');

class Hotspots extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model("hotspotsModel");
        $this->load->model("UsuarioModel");
        $this->load->model("MapaModel","mapa");
    }
    
    /**
     * Método por defecto del controlador.
     * 
     * No hay una vista principal de hotspots. Todas las vistas de hotspots se invocan desde la
     * vista principal de escenas, así que redirigimos allí.
     */
    public function index(){
        redirect("escenas");
    }

    /**
     * Muestra el formulario genérico de inserción de hotspots.
     * 
     * Cuando llegamos aquí, ya hemos seleccionado con la vista de pannellum el pitch y el yaw donde
     * queremos crear el hotspot.
     * 
     * @param double $pitch Coordenada pitch del hotspot
     * @param double $yaw Coordenada yaw del hotspot
     * @param String $idescena Código de la escena donde se creará el hotspot
     */
    
    public function show_insert_hotspot($pitch, $yaw, $idescena) {
        $this->load->model("MapaModel","mapa");
        $datos["documentos"]= $this->hotspotsModel->getAllDocumentos();
	$datos["pitch"]= $pitch;
        $datos["yaw"]= $yaw;
        $datos["id_scene"]= $idescena;
        $datos["mapa"] = $this->mapa->cargar_mapa();
        $datos["puntos"] = $this->mapa->cargar_puntos();
        $datos["vista"]="hotspots/insertHotspot";
        $datos["id_hotspot"] = $this->hotspotsModel->ultimo_hotspot()+1;
        $datos["permiso"]=$this->UsuarioModel->comprueba_permisos($datos["vista"]);
        $this->load->view('admin_template', $datos);
    }
    
    /**
     * Actualiza el pitch y el yaw de un hotspot.
     * 
     * Funciona con cualquier tipo de hotspot. Luego redirige a la vista de pannellum de la escena
     * para poder seguir modificando hotspots de esa escena.
     * 
     * @param double $pitch Nueva coordenada pitch del hotspot
     * @param double $yaw Nueva coordenada yaw del hotspot
     * @param String $idescena Código de la escena donde está el hotspot
     * @param int $idhotspot Código del hotspot que se va a modificar
     */
    
    public function update_hotspot_pitchyaw($pitch, $yaw, $idescena, $idhotspot) {
        $result = $this->hotspotsModel->modificarPitchYaw($pitch, $yaw, $idhotspot);
        if ($result == 1) $mensaje = "Hotspot modificado con éxito";
        else $mensaje = "Ha ocurrido un error al modificar el hotspot";
        redirect('escenas/cargar_escena/' . $idescena . '/show_insert_hotspot/');
        /*
        $datos["pitch"]= $pitch;
        $datos["yaw"]= $yaw;
        $datos["id_scene"]= $idescena;
        $datos["tablaEscenas"] = $this->EscenasModel->getAll();
        $datos["vista"]="escenas/Escenastable";
        $datos["mapa"] = $this->mapa->cargar_mapa();
        $datos["puntos"] = $this->mapa->cargar_puntos();
        $datos["permiso"]=$this->UsuarioModel->comprueba_permisos($datos["vista"]);
        $this->load->view('admin_template', $datos);
         */
    }
    
    /**
     * Actualiza el pitch y el yaw con el que se entra a una escena, es decir, el punto
     * al que se mira al entrar en esa escena.
     * 
     * Luego redirige a la vista pannellum para seguir modificando cosas en esa escena.
     * 
     * @param double $pitch Coordenada pitch
     * @param double $yaw Coordenada yaw
     * @param String $codescena Código de escena
     */
    public function update_escena_pitchyaw($pitch, $yaw, $codescena) {
        $datos["resultado"] = $this->hotspotsModel->modificarPitchYawEscena($pitch, $yaw, $codescena);
        redirect('escenas/cargar_escena/' . $codescena . '/show_insert_hotspot/');
        /*
        $datos["pitch"]= $pitch;
        $datos["yaw"]= $yaw;
        $datos["tablaEscenas"] = $this->EscenasModel->getAll();
        $datos["vista"]="escenas/Escenastable";
	$datos["mapa"] = $this->mapa->cargar_mapa();
	$datos["puntos"] = $this->mapa->cargar_puntos();
        $datos["permiso"]=$this->UsuarioModel->comprueba_permisos($datos["vista"]);
        $this->load->view('admin_template', $datos);
         */
    }
    
    /**
     * TODO: documentación
     * 
     * @param type $pitch
     * @param type $yaw
     * @param type $codescena
     * @param type $idhotspot
     */
    public function update_hotspot_targets($pitch, $yaw, $codescena, $idhotspot) {
        $datos["resultado"] = $this->hotspotsModel->modificarTargetsHotspot($pitch, $yaw, $codescena, $idhotspot);
        redirect('escenas/cargar_escena/' . $codescena . '/show_insert_hotspot/');
    /*
        $datos["pitch"]= $pitch;
        $datos["yaw"]= $yaw;
        $datos["tablaEscenas"] = $this->EscenasModel->getAll();
        $datos["vista"]="escenas/Escenastable";
        $datos["mapa"] = $this->mapa->cargar_mapa();
	$datos["puntos"] = $this->mapa->cargar_puntos();
        $datos["permiso"]=$this->UsuarioModel->comprueba_permisos($datos["vista"]);
        $this->load->view('admin_template', $datos);
     * 
     */
    }

    /**
     * Actualiza un hostpot de tipo audio.
     * 
     * Asigna un nuevo audio a este hotspot. Los ids del audio y del hotspot se recibe por POST.
     */
    public function updateHotspotAudio() {
        $id = $this->input->post_get("id_hotspot");
        $aud = $this->input->post_get("clickHandlerArgs");
        $resultado = $this->hotspotsModel->modificarpuntoaudio($id, $aud);
        $cambio = $this->input->post_get("sceneId");
        if ($resultado == true) {
            $mensaje = "Hotspot modificado con éxito";
        } else {
            $mensaje = "Error al modificar el hotspot";
        }
        redirect('escenas/cargar_escena/' . $cambio . '/show_insert_hotspot/');
    }

    public function delete_hotspot($id){
        $codigo_escena=$this->hotspotsModel->cargar_codigo_escena($id);    // Sacamos el código de escena a la que pertenece este hotspot
        $resultado = $this->hotspotsModel->borrarHotspot($id);
        redirect('escenas/cargar_escena/' . $codigo_escena. '/show_insert_hotspot/');

       /* if ($resultado == 1) {
            $datos["mensaje"] = "Hotspot borrado correctamente";
            $datos["tablaHotspots"] = $this->hotspotsModel->buscarHotspots();
            $datos["vista"]="hotspots/hotspotsTable";
            $datos["permiso"]=$this->UsuarioModel->comprueba_permisos($datos["vista"]);
            $this->load->view('admin_template', $datos);
            }
        else {
            $datos["error"] = "Error al borrar el hotspot";
            $datos["tablaHotspots"] = $this->hotspotsModel->buscarHotspots();
            $datos["vista"]="hotspots/hotspotsTable";
            $datos["permiso"]=$this->UsuarioModel->comprueba_permisos($datos["vista"]);
            $this->load->view('admin_template',$datos);
        }*/
    }
    
    /**
     * Muestra la vista correspondiente para actualizar un hotspot.
     * Los hotspots pueden ser de varios tipos (video, audio, panel, etc).
     * @param int $id El id del hotspot
     * @param type $escena_inicial TODO
     */
    public function show_update_hotspot($id, $escena_inicial = null){
        $datos["tabla"]= $this->hotspotsModel->buscarUnHotspot($id);
	
        // TODO: comentario
        if ($datos["tabla"][0]["clickHandlerFunc"] == "puntos") {
            $datos["vista"]="hotspots/updateHotspot";
            if(isset($escena_inicial)){
                $datos["escena_inicial"]=$escena_inicial;
            }
	}
        // Hotspot de tipo video
	if ($datos["tabla"][0]["clickHandlerFunc"] == "video") {
            $datos["vista"]="hotspots/updateHotspotVideo";
 	}
        // Hotspot de tipo audio
	if ($datos["tabla"][0]["clickHandlerFunc"] == "musica") {
            $datos["vista"]="hotspots/updateHotspotAudio";
 	}
        // Hotspot de tipo panel (galería de imágenes con información)
	if ($datos["tabla"][0]["clickHandlerFunc"] == "panelInformacion") {
            $datos["vista"]="hotspots/updateHotspotPanel";
 	}
        // Hotspot de tipo escelera
	if ($datos["tabla"][0]["clickHandlerFunc"] == "escaleras") {
            $datos["vista"]="hotspots/updateHotspotEscaleras";
 	}
        
        $datos["codigo_escena"]=$this->hotspotsModel->cargar_codigo_escena($id);    // Sacamos el código de escena a la que pertenece este hotspot
        $datos["permiso"]=$this->UsuarioModel->comprueba_permisos($datos["vista"]);
        $datos["mapa"] = $this->mapa->cargar_mapa();
        $datos["puntos"] = $this->mapa->cargar_puntos();
        $this->load->view('admin_template', $datos);
    }
    
    /**
     * Procesa el UPDATE de un hotspot de tipo vídeo
     */
    public function updateHotspotVideo() {
        $id = $this->input->post_get("id_hotspot");
	$vid = $this->input->post_get("clickHandlerArgs");
	$resultado=$this->hotspotsModel->modificarpuntovideo($id, $vid);
	$anda=$this->input->post_get("sceneId");
	if ($resultado == true)
            $mensaje = "Hotspot modificado con éxito";
        else
            $mensaje = "Ha fallado la actualización del hotspot";

        redirect('escenas/cargar_escena/'.$anda.'/show_insert_hotspot/');
            /*
            $datos["tablaHotspots"] = $this->hotspotsModel->buscarHotspots();
            $datos["vista"]="hotspots/hotspotsTable";
            $datos["permiso"]=$this->UsuarioModel->comprueba_permisos($datos["vista"]);
            $this->load->view('admin_template', $datos);
            */
    }
    
    // trabajar los redirect
    public function process_update_hotspot(){
            $id = $this->input->post_get("id_hotspot");
            $tipoHotspot = $this->input->post_get("cssClass");
            $anda = $this->input->post_get("sceneId");
            if($tipoHotspot == "custom-hotspot-info")
                $resultado = $this->hotspotsModel->modificarHotspotPanel($id);
            else if($tipoHotspot == "custom-hotspot-salto")
                $resultado = $this->hotspotsModel->modificarHotspot($id);
            
            if ($resultado == true) {
                $mensaje = "La modificaci&oacute;n ha sido un &eacute;xito";
                redirect('escenas/cargar_escena/'.$anda.'/show_insert_hotspot/');
                //$datos["permiso"]=$this->UsuarioModel->comprueba_permisos($datos["vista"]);
                //$this->load->view('admin_template', $datos);
            }
            else {
                $mensaje = "La modificaci&oacute;n ha fallado";
                redirect('escenas/cargar_escena/'.$anda.'/show_insert_hotspot/');
                //$datos["permiso"]=$this->UsuarioModel->comprueba_permisos($datos["vista"]);
                //$this->load->view('admin_template', $datos);
            }
        
    }

   /**
    * TODO: documentación.
    */
    public function process_insert_scene(){
        $resultado = $this->hotspotsModel->insertarHotspotEscena();
        if ($resultado == true) {
            $anda=$this->input->post_get("id_scene");
            redirect('escenas/cargar_escena/'.$anda.'/show_insert_hotspot/');
        }else {
            $datos["error"] = "La inserci&oacute;n ha fallado";
            $datos["tablaHotspots"] = $this->hotspotsModel->buscarHotspots();
            $datos["vista"]="hotspots/hotspotsTable";
            $datos["permiso"]=$this->UsuarioModel->comprueba_permisos($datos["vista"]);
            $this->load->view('admin_template', $datos);
        }
    }
    
    

////////////////////////////Zygis - MOVIDAS DEL CMS//////////////////////////

   /**
    * TODO: documentación.
    */
  public function process_insert_panel(){
            $joshua = $this->hotspotsModel->insertarHotspotPanel();
            $datos["mensaje"] = "La inserci&oacute;n ha sido un &eacute;xito";
            $datos["vista"]="hotspots/hotspotPanel";
            $datos["idhs"]=$joshua[0];
            $datos["escena_actual"]=$joshua[1];
            //cargar el modelo
            $this->load->model("ImagenModel");
            //acciones para ver el listado de imagenes
            $datos["lista_imagenes"] = $this->ImagenModel->buscar_todo();
            $datos["permiso"]=$this->UsuarioModel->comprueba_permisos($datos["vista"]);
            $this->load->view('admin_template', $datos);
    }
  
   /**
    * TODO: documentación.
    */
    public function process_insert_escaleras(){
            $joshua = $this->hotspotsModel->insertarHotspotEscalera();
            $datos["mensaje"] = "La inserci&oacute;n ha sido un &eacute;xito";
            $datos["permiso"]=$this->UsuarioModel->comprueba_permisos($datos["vista"]);
            $anda = $this->input->post_get("sceneId");
            redirect('escenas/cargar_escena/'.$anda.'/show_insert_hotspot/');
    }
    
  
   /**
    * TODO: documentación.
    */
  public function show_panel_info(){
    //cargar el modelo
    $this->load->model("ImagenModel");
    //acciones para ver el listado de imagenes
    $datos["lista_imagenes"] = $this->ImagenModel->buscar_todo();
    //Se lo paso a la vista
    $datos["vista"]="hotspots/hotspotPanel";
    $datos["permiso"]=$this->UsuarioModel->comprueba_permisos($datos["vista"]);
    $this->load->view('admin_template', $datos); 
  }
  
   /**
    * TODO: documentación.
    */
  public function add_imgs_hotspot(){
    //Añade las imagenes a la base de datos
    $resultado = $this->hotspotsModel->insertar_imagenes_hotspot();
    echo base_url("escenas/cargar_escena/".$resultado[1]."/show_insert_hotspot/null");
   
  }
  
   /**
    * TODO: documentación.
    */
  public function modify_panel_info($idhs){
    $datos["idhs"] = $idhs;
    $datos["imagenes_seleccionadas"]=$this->hotspotsModel->get_imgs_asociadas_al_hotspot($idhs);
    //cargar el modelo
    $this->load->model("ImagenModel");
    //acciones para ver el listado de imagenes
    $datos["lista_imagenes"] = $this->ImagenModel->buscar_todo();
    $datos["vista"]="hotspots/hotspotPanel";
    $datos["permiso"]=$this->UsuarioModel->comprueba_permisos($datos["vista"]);
    $this->load->view('admin_template', $datos); 
 }
  
   /**
    * TODO: documentación.
    */
 public function load_panel(){
  $id = $_REQUEST["id_hotspost"];
  $resultado = $this->hotspotsModel->cargar_imagenes_panel($id);
  //TODO: añadir mensaje de la situacion
 }

   /**
    * TODO: documentación.
    */
 public function load_video(){
    $id = $_REQUEST["idVideo"];
    $resultado = $this->hotspotsModel->cargar_video($id);
    echo $resultado;
    //TODO: añadir mensaje de la situacion
}

   /**
    * TODO: documentación.
    */
public function process_insert_video(){
        $resultado = $this->hotspotsModel->insertarHotspotVideo();
		$anda=$this->input->post_get("id_scene");
        if ($resultado == true) {
			echo $anda;
			redirect('escenas/cargar_escena/'.$anda.'/show_insert_hotspot/');
            /*$datos["mensaje"] = "La inserci&oacute;n ha sido un &eacute;xito";
            $datos["tablaHotspots"] = $this->hotspotsModel->buscarHotspots();
            $datos["vista"]="hotspots/hotspotsTable";
            $datos["permiso"]=$this->UsuarioModel->comprueba_permisos($datos["vista"]);
            $this->load->view('admin_template', $datos);*/
        }else {
            $datos["error"] = "La inserci&oacute;n ha fallado";
            $datos["tablaHotspots"] = $this->hotspotsModel->buscarHotspots();
            $datos["vista"]="hotspots/hotspotsTable";
            $datos["permiso"]=$this->UsuarioModel->comprueba_permisos($datos["vista"]);
            $this->load->view('admin_template', $datos);
        }
    }

   /**
    * TODO: documentación.
    */
public function load_audio(){
    $id = $_REQUEST["id_hotspot"];
    $resultado = $this->hotspotsModel->cargar_audio($id);
    //var_dump($resultado);
    //TODO: añadir mensaje de la situacion
}
   /**
    * TODO: documentación.
    */
    public function process_insert_audio() {

        $resultado = $this->hotspotsModel->insertarHotspotAudio();
        $cambio = $this->input->post_get("id_scene");

        if ($resultado == true) {

            redirect('escenas/cargar_escena/' . $cambio . '/show_insert_hotspot/');

        } else {
            $datos["error"] = "La inserci&oacute;n ha fallado";
            $datos["tablaHotspots"] = $this->hotspotsModel->buscarHotspots();
            $datos["vista"] = "hotspots/hotspotsTable";
            $datos["permiso"] = $this->UsuarioModel->comprueba_permisos($datos["vista"]);
            $this->load->view('admin_template', $datos);
        }
    }

   /**
    * TODO: documentación.
    */
    public function process_insert_hotspot(){
    $res=$this->hotspotsModel->process_insert_hotspot();
     if($res){
         echo"se a insertado correctamente";
         $datos["tablaHotspots"] = $this->hotspotsModel->buscarHotspots();
         $datos["vista"]="hotspots/hotspotsTable";
         $datos["permiso"]=$this->UsuarioModel->comprueba_permisos($datos["vista"]);
         $this->load->view('admin_template', $datos);
         
     }else{
         echo"fallo al insertar hotspot";
     }
 }

   /**
    * Borra el último hotspot.
    */
 public function borrarUltimo(){
    $ultimo = $this->hotspotsModel->ultimo_hotspot();
    $resultado = $this->hotspotsModel->borrarHotspot($ultimo);
    //echo $resultado;

 }
}
