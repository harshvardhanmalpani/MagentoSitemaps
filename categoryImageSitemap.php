<?php $output= '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
define('MAGENTO_ROOT', getcwd());
$mageFilename = MAGENTO_ROOT . '/app/Mage.php';
require_once $mageFilename;
Mage::app();
$base=Mage::getBaseUrl();
$categories = Mage::getModel('catalog/category')
                    ->getCollection()
                    ->addAttributeToSelect('url')
                    ->addAttributeToSelect('meta_title')
                    ->addAttributeToSelect('name')
                    ->addAttributeToSelect('image');
foreach ($categories as $cat) {
	if($cat->getLevel() && $cat->getImageUrl()){
	$output.= '<url>';
   $output.= '<loc>'.$cat->getUrl().'</loc>'; 
$output.= '<image:image><image:loc>'.$cat->getImageUrl().'</image:loc>';
if($cat->getMetaTitle()) $output.= '<image:caption>'.htmlspecialchars($cat->getMetaTitle()).'</image:caption>';
else $output.= '<image:caption>'.htmlspecialchars($cat->getName()).'</image:caption>';
$output.= '</image:image>';
$output.= '</url>';
}
}
$output.='</urlset>';
file_put_contents('c_site.xml',$output);

echo '<a href=c_site.xml>open sitemap</a>';
?>
