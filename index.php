<?

$root_path = '/var/zpanel/hostdata/esaruhan/public_html/tarifeoner_com/';

require_once($root_path . '/config.php');
require_once($path['fw'] . "lib/general.lib.php");
require_once($path['fw'] . "lib/routing.lib.php");
require_once($path['fw'] . "modules/routing.mod.php");


//onemli tanimlar
$routing = new routing();
$route = new routes($routing->Router());
$debug = $route->getDebug();
switch ($route->getMaster()) {
    case "faturaanaliz":
        include_once($path['tpl'] . 'header.php');
        include_once($path['tpl'] . 'fatura.php');
        include_once ($path['tpl'] . 'footer.php');
        break;
    case "hakkimizda":
        include_once($path['tpl'] . 'header.php');
        include_once($path['tpl'] . 'aboutus.php');
        include_once ($path['tpl'] . 'footer.php');
        break;
    case "kullanimsartlari":
        include_once($path['tpl'] . 'header.php');
        include_once($path['tpl'] . 'tos.php');
        include_once ($path['tpl'] . 'footer.php');
        break;
   case "ebaoauth":
        include_once($path['tpl'] . '/oauth-php/example/client/googledocs.php');
        
        break;
    default:
        include_once($path['tpl'] . 'header.php');
        include_once($path['tpl'] . 'body.php');
        include_once ($path['tpl'] . 'footer.php');
        
}
?>
