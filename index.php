<?php
	require 'Slim/Slim.php';
	require 'idiormparis/idiorm.php';
	require 'idiormparis/paris.php';
	require 'models/Avatar.php';

	\Slim\Slim::registerAutoloader();

	$env = isset($_SERVER['HTTP_HOST']) && ($_SERVER['HTTP_HOST'] === 'apps.socialhappen.com') ? 'production' : 'dev';

	$config = array(
		'dev' => array(
			'db' => array(
				'host' => 'localhost',
				'dbname' => 'friendlab',
				'username' => 'root',
				'password' => ''
			)
		),
		'production' => array(
			'db' => array(
				'host' => 'http://www.figabyte.com',
				'dbname' => 'friendlab',
				'username' => 'friendlab',
				'password' => 'guvuwhifipav'
			)
		)
	);

	$host = $config[$env]['db']['host'];
	$dbname = $config[$env]['db']['dbname'];
	$dbuser = $config[$env]['db']['username'];
	$dbpass = $config[$env]['db']['password'];

	ORM::configure("mysql:host={$host};dbname={$dbname}");
	ORM::configure('username',$dbuser);
	ORM::configure('password',$dbpass);

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
				'success' => TRUE,
				'id'=>$ava->id,
				'gold'=>$ava->gold,
				'hungry'=>$ava->hungry,
				'energy'=>$ava->energy,
				'clean'=>$ava->clean,
				'edit'=>$ava->edit,
				'sleep'=>$ava->sleep,
				'avatar'=>$ava->avatar,
				'pic'=>$ava->pic
			);
		}

		$res->body(json_encode($return));
	});

	$app->post('/new/:id/:avaid/:pic/:time',function($id,$avaid,$pic,$time) use($app){
		$new = Model::factory('Avatar')->create();
		$new->id=$id;
		$new->gold=100;
		$new->hungry=100;
		$new->energy=100;
		$new->clean=100;
		$new->sleep=0;
		$new->edit=$time;
		$new->avatar=$pic;
		$new->pic=$avaid;
		$new->save();

		$res = $app->response();
		$res['Content-Type'] = 'application/json';
		$res->body(json_encode(array('success' => TRUE)));
	});

	$app->post('/del/:id',function($id) use($app){
		$ava = Model::factory('Avatar')
		->where('id',$id)
		->find_one();
		$ava->delete($id);

		$res = $app->response();
		$res['Content-Type'] = 'application/json';
		$res->body(json_encode(array('success' => TRUE)));
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

	$app->post('/:id/capture',function($id) use($app){
		$im = imagegrabscreen();
		imagepng($im,"/share_image/"$id+".png");
		$url = "http://app.socialhappen.com/friendlab/share_image/"+$id+".png";

		$app_id = "405891112842517";
		$app_secret = "433a6313167f3ec12db2f9b87e693566";

		$code = $_REQUEST["code"];

		//Obtain the access_token with publish_stream permission
		if(empty($code)){
			$dialog_url= "http://www.facebook.com/dialog/oauth?" . "client_id=" . $app_id . "&redirect_uri=" . urlencode( $post_login_url) . "&scope=publish_stream";
			echo("<script>top.location.href='" . $dialog_url . "'</script>");
		}else{
			$token_url="https://graph.facebook.com/oauth/access_token?" . "client_id=" . $app_id . "&redirect_uri=" . urlencode( $post_login_url) . "&client_secret=" . $app_secret . "&code=" . $code;
			$response = file_get_contents($token_url);
			$params = null;
			parse_str($response, $params);
			$access_token = $params['access_token'];

			// Show photo upload form to user and post to the Graph URL
			$graph_url= "https://graph.facebook.com/"+$id+"/photos?" . "url=" . urlencode($url) . "&method=POST" . "&access_token=" .$access_token;

		}
		imagedestroy($im);
	});

	$app->run();
?>