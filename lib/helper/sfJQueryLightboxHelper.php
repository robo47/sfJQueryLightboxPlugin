<?php

/**
 * @package sfJQueryLightboxPlugin
 * 
 * @author Artur Rozek
 * @version 2.0.0
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

  echo link_to($thumb_tag, $image_url, $image_link_options);
}

light_image_activate();
function light_image_activate()
{
  if (!sfContext::hasInstance()) return;

  //add resources
  $response = sfContext::getInstance()->getResponse();

  //check if jqueryreloaded plugin is activated
  if (sfConfig::has('sf_jquery_web_dir') && sfConfig::has('sf_jquery_core'))
    $response->addJavascript(sfConfig::get('sf_jquery_web_dir'). '/js/'.sfConfig::get('sf_jquery_core'));
  else
    throw new Exception("Theres is no JqueryReloaded plugin !");
    
  //JQuery Lightbox specific
  $response->addJavascript(sfConfig::get("app_sf_jquery_lightbox_js_dir").'jquery.lightbox-0.5.js');
  $response->addStylesheet(sfConfig::get("app_sf_jquery_lightbox_css_dir").'jquery.lightbox-0.5.css');

  $code = "$(function() {
    $('a.lightbox').lightBox({
      imageLoading: '".sfConfig::get('app_sf_jquery_lightbox_imageLoading')."',
      imageBtnClose: '".sfConfig::get('app_sf_jquery_lightbox_imageBtnClose')."',
      imageBtnPrev: '".sfConfig::get('app_sf_jquery_lightbox_imageBtnPrev')."',
      imageBtnNext: '".sfConfig::get('app_sf_jquery_lightbox_imageBtnNext')."',
      imageBlank: '".sfConfig::get('app_sf_jquery_lightbox_imageBlank')."',
      txtImage: '".sfConfig::get('app_sf_jquery_lightbox_txtImage')."',
      txtOf: '".sfConfig::get('app_sf_jquery_lightbox_txtOf')."' });
  });";

  echo javascript_tag($code);
}