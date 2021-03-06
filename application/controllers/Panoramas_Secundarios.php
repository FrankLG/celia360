<?php 
class Panoramas_Secundarios extends CI_Controller {

	/*
	Controlador que gestiona las imagenes secundarias asociadas a una escena principal
	*/


public function __construct() {
    parent::__construct();
    $this->load->model("EscenasModel");
    $this->load->model("UsuarioModel");
	$this->load->model("PanoramasSecundariosModel");
}

	public function index(){ // Redirige al index del controlador Escenas
		redirect('Escenas/');
	}


public function show_panoramas_secundarios($codigo_escena, $datos = null){ //cargo la vista para insertar panoramas secundarios
	$datos['datos_escena'] = $this->EscenasModel->getOne($codigo_escena);
	$datos['tabla_escena_secundaria'] = $this->PanoramasSecundariosModel->getById($codigo_escena);
	$datos["vista"]="escenas/admin_pan_sec";
	$datos['cod_escena'] = $codigo_escena;
	$datos["permiso"] = $this->UsuarioModel->comprueba_permisos($datos["vista"]);
	
	if($datos['permiso']){
		$this->load->view("admin_template",$datos);
	}else{
		redirect('usuario');
	}
	
}

//Insercion de imagenes secundarias
public function insertSecondaryPanorama($id){
    $res = $this->PanoramasSecundariosModel->insertSecondaryPanoramas($id);
    $incorrectas = 0;
        for($i=0;$i<count($res);$i++){
            if($res[$i] == 0){
                $incorrectas++;
            }
        }
        echo $incorrectas; //devuelvo incorrectas y gestiono con ajax si es 0 o no       
	}
	// borrar imagen secundaria por ajax
	public function deletePanorama($id){
		$res = $this->PanoramasSecundariosModel->delete($id);
		echo $res; //capturo por ajax
	}
	
	public function updatePanorama(){ //actualización de imagenes
		$id = $this->input->get_post('id_imagen');
		$tituloImagen = $this->input->get_post('titulo_imagen');
		$fecha = $this->input->get_post('fecha');
		$codigo_escena = $this->input->get_post('id_escena_principal');
		$res = $this->PanoramasSecundariosModel->updatePanorama($id,$tituloImagen,$fecha);

		if($res == 1){
			$datos['mensaje'] = 'Actualizado con éxito';
		}else{
			$datos['error'] = 'Error al actualizar';
		}
		$this->show_panoramas_secundarios($codigo_escena,$datos);
	}

	//Cargar escena es una función que a diferencia de la que hay en el controlador
	//Escenas, esta recibe $datos['panorama_secundario'] = 1
	//Al recibir este 1, quiere decir que el tipo de escena que carga es
	//secundaria
	public function cargar_escena($escenaInicial, $redireccion, $piso = null){
        $this->load->library('session');
        if(isset($piso) && is_numeric($piso)){
            $this->session->piso=$piso; 
        }
        
        $redireccion = site_url("/hotspots/".$redireccion."/");
        $datos["redireccion_joptoch"]= $redireccion;
		$datos["escenaInicial"] = $escenaInicial;
		$datos['panorama_secundario'] = '1';
		$datos['cod_escena'] = $this->PanoramasSecundariosModel->getCodEscena($escenaInicial);
        $datos["idhotspot"]= "vacio";
		$this->load->view("escenas/jotpoch", $datos);	
	}
	
	public function consultaPanoramas($id_escena){
		$res = $this->PanoramasSecundariosModel->consultaPanoramas($id_escena);
		echo $res;

	}

	public function getCodEscena($cod){
		echo json_encode($this->PanoramasSecundariosModel->getCodEscena($cod));
	}

	public function updatePreview() {
		$res = $this->PanoramasSecundariosModel->updatePreview();

		echo $res;
	}

	public function deletePreview($id) {
		$res = $this->PanoramasSecundariosModel->deletePreview($id);
		echo $res;
	}
}

?>
