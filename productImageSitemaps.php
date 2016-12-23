<?php $output= '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
define('MAGENTO_ROOT', getcwd());
$mageFilename = MAGENTO_ROOT . '/app/Mage.php';
require_once $mageFilename;
Mage::app();
$base=Mage::getBaseUrl();
$collection = Mage::getModel('catalog/product')->getCollection()
->addAttributeToSelect('id,url');
foreach ($collection as $product) {
	$output.= '<url>';
  $_images = Mage::getModel('catalog/product')->load($product->getId())->getMediaGalleryImages();
 $output.= '<loc>'.$product->getProductUrl().'</loc>'; 
  foreach ($_images as $_image) { 
$output.= '<image:image><image:loc>'.$base.'media/catalog/product'.$_image->getFile().'</image:loc>';
if($_image->getLabel()) $output.= '<image:caption>'.htmlspecialchars($_image->getLabel()).'</image:caption>';
$output.= '</image:image>';
}$output.= '</url>';
}
$output.='</urlset>';
file_put_contents('i_site.xml',$output);

echo '<a href=i_site.xml>open sitemap</a>';
?>
