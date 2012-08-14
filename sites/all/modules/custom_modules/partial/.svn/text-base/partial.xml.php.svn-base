<?php
// $Id$
/**
 * Partials Module
 * Copyright Hemisphere 3 Solutions 2007
 */

class Partial {
}

function partial_create_xml($dom, $node, $name, $value) {
  if ($name == 'properties') {
    if (!empty($value)) {
      foreach ($value as $key=>$property) {
        $childnode = $node->appendChild($dom->createElement('property'));
        foreach ($property as $key=>$value) {
          partial_create_xml($dom, $childnode, $key, $value);
        }        
      }
    }
  } else if (($name == 'internal_template') || ($name == 'internal_css') || ($name == 'internal_js') || ($name == 'internal_php')) {
    $child = $node->appendChild($dom->createElement($name));
    $child->appendChild($dom->createCDATASection($value));    
  } else if ($name == 'pid') {
    //do nothing
  } else {
    $child = $node->appendChild($dom->createElement($name));
    $child->appendChild($dom->createTextNode($value));
  }
}

function partial_parse_xml($dom, $name) {
  $nodeList = $dom->getElementsByTagName($name);
  if ($nodeList) {
    return $nodeList->item(0)->nodeValue;
  }
}

function partial_to_xml($partial) {
  $dom = new DOMDocument('1.0');
  
  $node = $dom->appendChild($dom->createElement('partial'));
  foreach ($partial as $key=>$value) {
    partial_create_xml($dom, $node, $key, $value);
  }

  $dom->formatOutput = true;
  return $dom->saveXML();
}

function partial_from_xml($xmlstr) {
  $retVal = new Partial();
  $dom = new DOMDocument('1.0'); 
  $dom->loadXML($xmlstr);  

  $retVal->title = partial_parse_xml($dom, 'title');
  $retVal->module = partial_parse_xml($dom, 'module');
  $retVal->theme = partial_parse_xml($dom, 'theme');
  $retVal->throttle = partial_parse_xml($dom, 'throttle');
  
  //partial specific stuff
  $retVal->partial_description = partial_parse_xml($dom, 'partial_description');
  $retVal->partial_file = partial_parse_xml($dom, 'partial_file');
  $retVal->use_folder = partial_parse_xml($dom, 'use_folder');
  $retVal->node_prefix = partial_parse_xml($dom, 'node_prefix');

  $retVal->provide_page = partial_parse_xml($dom, 'provide_page');
  $retVal->page_title = partial_parse_xml($dom, 'page_title');
  $retVal->page_url = partial_parse_xml($dom, 'page_url');

  $retVal->provide_simple_page = partial_parse_xml($dom, 'provide_simple_page');
  $retVal->simple_page_title = partial_parse_xml($dom, 'simple_page_title');
  $retVal->simple_page_url = partial_parse_xml($dom, 'simple_page_url');

  $retVal->provide_block = partial_parse_xml($dom, 'provide_block');
  $retVal->block_title = partial_parse_xml($dom, 'block_title');

  $retVal->provide_view_style = partial_parse_xml($dom, 'provide_view_style');

  $retVal->use_internal_template = partial_parse_xml($dom, 'use_internal_template');
  $retVal->internal_template = partial_parse_xml($dom, 'internal_template');

  $retVal->use_internal_css = partial_parse_xml($dom, 'use_internal_css');
  $retVal->internal_css = partial_parse_xml($dom, 'internal_css');

  $retVal->use_internal_js = partial_parse_xml($dom, 'use_internal_js');
  $retVal->internal_js = partial_parse_xml($dom, 'internal_js');

  $retVal->use_internal_php = partial_parse_xml($dom, 'use_internal_php');
  $retVal->internal_php = partial_parse_xml($dom, 'internal_php');

  $nodeList = $dom->getElementsByTagName('property');    
  for ($i = 0; $i < $nodeList->length; $i++) {
    $propertyNode = $nodeList->item($i);
    $property = array(); 
    $property['name'] = partial_parse_xml($propertyNode, 'name');
    $property['label'] = partial_parse_xml($propertyNode, 'label');
    $property['type'] = partial_parse_xml($propertyNode, 'type');
    $property['attributes'] = partial_parse_xml($propertyNode, 'attributes');
    $property['value'] = partial_parse_xml($propertyNode, 'value');
    $retVal->properties[] = $property;
  }    
  return $retVal;
}
