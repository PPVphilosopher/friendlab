<?php
	require 'Slim/Slim.php';
	require 'idiormparis/idiorm.php';
	require 'idiormparis/paris.php';
	require 'models/Avatar.php';

	\Slim\Slim::registerAutoloader();

	ORM::configure('mysql:host=localhost;dbname=friendlab');
	ORM::configure('username','root');
	ORM::configure('password','');

	$app = new \Slim\Slim();

	$app->get('/:id/status',function($id) use($app){
		$ava = Model::factory('Avatar')
		->where('id',$id)
		->find_one();
		$res = $app->response();
		$res['Content-Type'] = 'application/json';
		if(!$ava){
			$return = array('success' => FALSE);
		}else{
			$return = array(
				'id'=>$ava->id,
				'gold'=>$ava->gold,
				'hungry'=>$ava->hungry,
				'energy'=>$ava->energy,
				'clean'=>$ava->clean,
				'edit'=>$ava->edit,
				'sleep'=>$ava->sleep,
				'avatar'=>$ava->avatar,
				'pic'=>$ava->pic,
				'type'=>$ava->type
			);
		}

		$res->body(json_encode($return));
	});

	$app->post('/:id/post/:e/:h/:c/:t/:p/:g',function($id,$e,$h,$c,$t,$p,$g) use($app){
		$ava = Model::factory('Avatar')
		->where('id',$id)
		->find_one();
		$ava->gold=$g;
		$ava->energy=$e;
		$ava->hungry=$h;
		$ava->clean=$c;
		$ava->edit=$t;
		$ava->sleep=$p;
		$ava->save();

		$res = $app->response();
		$res['Content-Type'] = 'application/json';
		$res->body(json_encode(array('success' => TRUE)));
	});

	$app->get('/', function() use ($app) {
		$res = $app->response();
		$res['Content-Type'] = 'application/json';
		$res->body(json_encode(array('success' => TRUE)));
	});

	$app->run();
?>