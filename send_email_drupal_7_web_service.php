<?php

	/**
	 Inicializar el email	
	*/
	function enviar_objetivos_mail($key, &$message, $params) {
	  global $user;

	  $options = array(
	    'langcode' => $message['language']->language,
	  );
	  //Mails por diferentes tipos de casos
	  switch ($key) {

	  	case 'objetivo_observado':

	      $message['subject'] = t('Observaciones de objetivos', array('@site-name' => variable_get('site_name', 'Drupal')), $options);
	      $message['body'][] = $params['body']; // pasar por parametro el contenido del email 
	      //$message['body'][] = t('texot de prueba', array('@name' => $userid), $options);     

	    break;
	    
	    case 'objetivo_finalizado':

	      $message['subject'] = t('Objetivo culminado del colaborador', array('@site-name' => variable_get('site_name', 'Drupal')), $options);
	      $message['body'][] = $params['body']; // pasar por parametro el contenido del email 
	      //$message['body'][] = t('texot de prueba', array('@name' => $userid), $options);     

	    break;

	    case 'objetivo_aprobado':

	      $message['subject'] = t('Objetivos aprobados por jefe', array('@site-name' => variable_get('site_name', 'Drupal')), $options);
	      $message['body'][] = $params['body']; // pasar por parametro el contenido del email 
	      //$message['body'][] = t('texot de prueba', array('@name' => $userid), $options);     

	    break;

	    
	  }
	}

	/**
	 template del email - contenido del email
	*/
	function enviar_objetivos_mail_template($key, $nameUser=null, $jefename=null){

		//Contenido por diferentes tipos de casos
		switch ($key){	

			

			case 'objetivo_observado':
				$html = '<div>
							Estimado '.$nameUser .' se han adjuntado observaciones a tus objetivos, por favor revisarlos.						
						</div> ';

				return $html;
			break;	

			case 'objetivo_finalizado':	

	$html = '<div>Hola '.$jefename.':<br> El colaborador '.$nameUser.' ha ingresado sus objetivos a nuestra plataforma.<br>	Te invitamos a ingresar a la sección “Desarrollo” y hacer click en “Mi equipo” a fin de validar los objetivos planteados por '.$nameUser.' para el año 2017 y contribuir en la etapa de creación de objetivos del proceso de Evaluación de Desempeño.<br> Ante cualquier consulta no dudes en poner en contacto con Recursos Humanos.
	Muchas gracias!, <br> Puede revisarlos en en el siguiente enlace: <br> <a href="/"> </a> </div> ';

				return $html;

			break;

			case 'objetivo_aprobado':
				$html = '<div>
							Estimado '.$nameUser .' tus objetivos fueron arpobados.						
						</div> ';

				return $html;
			break;
		}
			
	}

		/**
		enviar el mail de confirmacion de objetifos finalizados
	*/
	function enviar_objetivos_mail_complete_objetivo_send($to, $params) {

	  $module = 'enviar_objetivos';
	  $key = 'objetivo_finalizado';//->tipo de correo

	  // Specify 'to' and 'from' addresses.
	  //mail origen
	  $from = variable_get('site_mail', 'atypax@gmail.com');   
	  $language = language_default();

	  //variable para el elvio de mail
	  $result = drupal_mail($module, $key, $to, $language, $params, $from);

	  //mensajes de confirmacion o error de salida de email
	  if ($result['result'] == TRUE) {
	    drupal_set_message(t('Your message has been sent.'));
	    return 'Your message has been sent.';
	  }
	  else {
	    drupal_set_message(t('There was a problem sending your message and it was not sent.'), 'error');
	    return 'There was a problem sending your message and it was not sent.';
	  }

	}

	/**
		enviar el mail
	*/
	function enviar_objetivos_mail_observacion_objetivo_send($to, $params) {

	  $module = 'enviar_objetivos';
	  $key = 'objetivo_observado';//->tipo de correo

	  // Specify 'to' and 'from' addresses.
	  //mail origen
	  $from = variable_get('site_mail', 'atypax@gmail.com');   
	  $language = language_default();

	  //variable para el elvio de mail
	  $result = drupal_mail($module, $key, $to, $language, $params, $from);

	  //mensajes de confirmacion o error de salida de email
	  if ($result['result'] == TRUE) {
	    drupal_set_message(t('Your message has been sent.'));
	    return 'Your message has been sent.';
	  }
	  else {
	    drupal_set_message(t('There was a problem sending your message and it was not sent.'), 'error');
	    return 'There was a problem sending your message and it was not sent.';
	  } 

	}

	/**
		enviar el mail de aprobacion de objetivo
	*/
	function enviar_objetivos_mail_aprobacion_objetivo_send($to, $params) {

	  $module = 'enviar_objetivos';
	  $key = 'objetivo_aprobado';//->tipo de correo

	  // Specify 'to' and 'from' addresses.
	  //mail origen
	  $from = variable_get('site_mail', 'xxxx@gmail.com');   
	  $language = language_default();

	  //variable para el elvio de mail
	  $result = drupal_mail($module, $key, $to, $language, $params, $from);

	  //mensajes de confirmacion o error de salida de email
	  if ($result['result'] == TRUE) {
	    drupal_set_message(t('Your message has been sent.'));
	    return 'Your message has been sent.';
	  }
	  else {
	    drupal_set_message(t('There was a problem sending your message and it was not sent.'), 'error');
	    return 'There was a problem sending your message and it was not sent.';
	  }

	}


	/**
		Servicio Web que se encarga de enviar el correo
	*/
	function nombre_modulo_services_resources_send_objetivos($idUser, $key){


		/*if(!isset($_POST['idUser'])){
					//si no envía el id de usuario
					return array('status' => 0, 'message' => 'Debes enviar el ID del usuario');
				}
					
		$idUser = $_POST['idUser'];*/
		$userdata = user_load($idUser);
		$nameUser = $userdata->field_nombre['und'][0]['value'].' '.$userdata->field_apellido['und'][0]['value'];
	
		switch ($key){	

			case 'objetivo_finalizado':	
				
				
				//cargar datos del usuario y el jefe
				
			    $jefedata = user_load($userdata->field_jefe['und'][0]['target_id']);
				
				$to = $jefedata->mail;

				$jefename = $jefedata->field_nombre['und'][0]['value'].' '.$jefedata->field_apellido['und'][0]['value'];

				$params = array(        
			       	 'body' => enviar_objetivos_mail_template($key, $nameUser,$jefename),
			    );

				return enviar_objetivos_mail_complete_objetivo_send($to, $params); 
			//return $userdata;
			break;	

			case 'objetivo_observado':	
				
				$to = $userdata->mail;
				$jefename = null;
				//$nameUser = $userdata->name;

				$params = array(        
			       	 'body' => enviar_objetivos_mail_template($key, $nameUser,$jefename),
			    );

			    return enviar_objetivos_mail_observacion_objetivo_send($to, $params);
			break;

			case 'objetivo_aprobado':	
				
				$to = $userdata->mail;
				//$to = 'planeamiento@nombre_modulo.com.pe';
				//$to = 'crojas@atypax.com';

				$jefename = null;
				//$nameUser = $userdata->name;

				$params = array(        
			       	 'body' => enviar_objetivos_mail_template($key, $nameUser,$jefename),
			    );

			    return enviar_objetivos_mail_aprobacion_objetivo_send($to, $params);
			break;
		}	
		
	
	}

	/***
		#############Servicios web que se ejecutaran dependiendo del caso 
	***/

	/**
		confirmar objetivos al jefe directo
		idUser-> id del colaborador
	*/
	function nombre_modulo_services_resources_confirm_objetivo(){
		$post = file_get_contents("php://input");
		$post_dec = json_decode($post);
		$idUser  = $post_dec->idUser;
		
		if(!isset($idUser)){
			//si no envía el id de usuario
			return array('status' => 0, 'message' => 'Debes enviar el ID del usuario');
		}	

		$userdata = user_load($idUser);

		if (!isset($userdata->field_jefe['und'][0]['target_id'])) {
			return 'colaborador no tiene asignado jefe';
		}

		$nodoid  = $post_dec->nodoid;

		if(!isset($nodoid)){
			//si no envía el id de usuario
			return array('status' => 0, 'message' => 'Debes enviar el ID del nodo');
		}

		$evaluacion = node_load($nodoid);
				$evaluacion->field_estado_ingreso_objetivo['und'][0]['value'] = 1;
		node_save($evaluacion);

		$key = 'objetivo_finalizado';		

		return nombre_modulo_services_resources_send_objetivos($idUser, $key);
		//return 'notificacion enviada';
	}

	/**
		notificar observaciones
	*/
	function nombre_modulo_services_resources_observacion_objetivo(){

		$idUser = $_POST['idUser'];
		
		if(!isset($_POST['idUser'])){
			//si no envía el id de usuario
			return array('status' => 0, 'message' => 'Debes enviar el ID del usuario');
		}	

		$nodoid = $_POST['nodoid'];

		if(!isset($_POST['nodoid'])){
			//si no envía el id de usuario
			return array('status' => 0, 'message' => 'Debes enviar el ID del nodo');
		}

		$observacion = $_POST['observacion'];

		if(!isset($_POST['observacion'])){
			//si no envía el id de usuario
			return array('status' => 0, 'message' => 'Debes enviar tus observaciones');
		}

		$evaluacion = node_load($nodoid);
		//return $evaluacion;
				$evaluacion->field_estado_ingreso_objetivo['und'][0]['value'] = 2;
				$evaluacion->field_observacion['und'][0]['value'] = $observacion;
		node_save($evaluacion);

		$key = 'objetivo_observado';
		//return 'hola';
		return nombre_modulo_services_resources_send_objetivos($idUser, $key);


	}

	/**
		notificar de aprobación 
	*/
	function nombre_modulo_services_resources_aprobacion_objetivo(){

		$idUser = $_POST['idUser'];
		
		if(!isset($_POST['idUser'])){
			//si no envía el id de usuario
			return array('status' => 0, 'message' => 'Debes enviar el ID del usuario');
		}	

		$nodoid = $_POST['nodoid'];

		if(!isset($_POST['nodoid'])){
			//si no envía el id de usuario
			return array('status' => 0, 'message' => 'Debes enviar el ID del nodo');
		}

	

		$evaluacion = node_load($nodoid);
		//return $evaluacion;
				$evaluacion->field_estado_ingreso_objetivo['und'][0]['value'] = 3;
				$evaluacion->field_observacion['und'][0]['value'] = $observacion;
		node_save($evaluacion);

		$key = 'objetivo_aprobado';
		//return 'hola';
		return nombre_modulo_services_resources_send_objetivos($idUser, $key);

	}