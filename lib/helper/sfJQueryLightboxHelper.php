<?php

/**
 * @package sfJQueryLightboxPlugin
 * 
 * @author Artur Rozek
 * @version 1.0.0
 * 
 */

/**
 * Returns an image link to use the lightbox function for 1 image.
 *
 * @param thumb_url          thumbnail url
 * @param image_url          full image url
 * @param image_link_options additional html attributes to add to image link (e.g.: array ('title' => 'My image'))
 * @param thumb_options      additional html attributes to add to thumb image tag (e.g.: array ('border' => 5))
 * 
 * @author Artur Rozek
 */
function light_image($thumb_url, $image_url, $image_link_options = array(), $thumb_options = array() )
{
  //make lightbox effect
  $thumb_tag = image_tag($thumb_url, $thumb_options);
  
  $image_link_options['class'] = isset($image_link_options['class']) ? $image_link_options['class']." lightbox" : 'lightbox';

  return link_to($thumb_tag, $image_url, $image_link_options);
}

function light_image_activate($txtImage = "Zdjęcie", $txtOf = "z")
{
  //add resources
  $response = sfContext::getInstance()->getResponse();
  if (sfConfig::has('sf_jquery_web_dir') && sfConfig::has('sf_jquery_core'))
    $response->addJavascript(sfConfig::get('sf_jquery_web_dir'). '/js/'.sfConfig::get('sf_jquery_core'));
  else
    $response->addJavascript(sfConfig::get('sf_jquery_lightbox_js_dir').'jquery-1.3.1.min.js');
    
  //JQuery Lightbox specific
  $response->addJavascript('/sfJQueryLightboxPlugin/js/jquery.lightbox-0.5.js');
  $response->addStylesheet('/sfJQueryLightboxPlugin/css/jquery.lightbox-0.5.css');

  $code = "$(function() {
    $('a.lightbox').lightBox({
      imageLoading: '/sfJQueryLightboxPlugin/images/lightbox-ico-loading.gif',
      imageBtnClose: '/sfJQueryLightboxPlugin/images/lightbox-btn-close.gif',
      imageBtnPrev: '/sfJQueryLightboxPlugin/images/lightbox-btn-prev.gif',
      imageBtnNext: '/sfJQueryLightboxPlugin/images/lightbox-btn-next.gif',
      imageBlank: '/sfJQueryLightboxPlugin/images/lightbox-blank.gif',
      txtImage: '$txtImage',
      txtOf: '$txtOf' });
  });";

  return javascript_tag($code);
}