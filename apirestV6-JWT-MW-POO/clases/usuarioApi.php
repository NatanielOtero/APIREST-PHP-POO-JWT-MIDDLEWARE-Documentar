<?php

require_once "usuario.php";
/**
 *
 */
class userApi extends user implements IApiUsable
{
  public function TraerUno($request, $response, $args) {
     	  $id=$args['id'];
        $usuario=user::traerUs($id);
        if(!$usuario)
        {
            $objDelaRespuesta= new stdclass();
            $objDelaRespuesta->error="No esta el usuario";
            $NuevaRespuesta = $response->withJson($objDelaRespuesta, 500);
        }else
        {
            $NuevaRespuesta = $response->withJson($usuario, 200);
        }
        return $NuevaRespuesta;
    }
     public function TraerTodos($request, $response, $args) {
      	$usuarios= user::traerTodos();
     	$newresponse = $response->withJson($usuarios, 200);
    	return $newresponse;
    }
      public function CargarUno($request, $response, $args) {

        $objDelaRespuesta= new stdclass();

        $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        $name= $ArrayDeParametros['usuario'];
        $pass= $ArrayDeParametros['pass'];
        $id= $ArrayDeParametros['id'];

        $user = new user();
        $user->user=$name;
        $user->pass=$pass;
        $user->id=$id;
        $user->altaUs();
        $archivos = $request->getUploadedFiles();
        $destino="./fotos/";
        //var_dump($archivos);
        //var_dump($archivos['foto']);
        if(isset($archivos['foto']))
        {
            $nombreAnterior=$archivos['foto']->getClientFilename();
            $extension= explode(".", $nombreAnterior)  ;
            //var_dump($nombreAnterior);
            $extension=array_reverse($extension);
            $archivos['foto']->moveTo($destino.$titulo.".".$extension[0]);
        }
        //$response->getBody()->write("se guardo el cd");
        $objDelaRespuesta->respuesta="Se guardo el Usuario.";
        return $response->withJson($objDelaRespuesta, 200);
    }
      public function BorrarUno($request, $response, $args) {
     	$ArrayDeParametros = $request->getParsedBody();
     	$id=$ArrayDeParametros['id'];
     	$us= new user();
     	$us->id=$id;
     	$cantidadDeBorrados=$us->bajaUs();

     	$objDelaRespuesta= new stdclass();
	    $objDelaRespuesta->cantidad=$cantidadDeBorrados;
	    if($cantidadDeBorrados>0)
	    	{
	    		 $objDelaRespuesta->resultado="algo borro!!!";
	    	}
	    	else
	    	{
	    		$objDelaRespuesta->resultado="no Borro nada!!!";
	    	}
	    $newResponse = $response->withJson($objDelaRespuesta, 200);
      	return $newResponse;
    }

     public function ModificarUno($request, $response, $args) {
     	//$response->getBody()->write("<h1>Modificar  uno</h1>");
     	$ArrayDeParametros = $request->getParsedBody();
	    //var_dump($ArrayDeParametros);
	    $user = new user();
	    $user->id=$ArrayDeParametros['id'];
	    $user->user=$ArrayDeParametros['usuario'];
	    $user->pass=$ArrayDeParametros['pass'];


	   	$resultado =$user->modUs();
	   	$objDelaRespuesta= new stdclass();
		//var_dump($resultado);
		$objDelaRespuesta->resultado=$resultado;
        $objDelaRespuesta->tarea="modificar";
		return $response->withJson($objDelaRespuesta, 200);
    }








}




 ?>
