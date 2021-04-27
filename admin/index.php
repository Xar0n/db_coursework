<?php
require __DIR__ . '/../autoload.php';

use App\Exceptions\Db\DbException;
use App\Exceptions\Http\{
	HttpCode,
	Http403Exception
};
use App\View;

$urlParts = explode('/', $_SERVER['REQUEST_URI']);
$ctrl = !empty($urlParts[2]) ? ucfirst($urlParts[2]) . 'Controller' :
	'DefaultController';
$action = !empty($urlParts[3]) ? $urlParts[3] : 'index';

try {
	$class = '\\App\\Controllers\\admin\\' . $ctrl;
	$controller = new $class;
	$controller->action($action);
} catch (DbException $e) {
	$view = new View;
	$view->display(__DIR__ . '/../App/Templates/error_db.php');
} catch (HttpCode $e) {
	http_response_code($e->getCode());
	echo $e->getMessage();
} catch (Throwable $e) {
	echo $e->getMessage();
}