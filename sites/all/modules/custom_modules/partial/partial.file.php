<?php
// $Id$
/**
 * Partials Module
 */

class PartialFile {
  
  private $key;
  private $label;
  private $extension;
  
  function __construct($key, $label, $extension, $allowInternal=true) {
    $this->key = $key;
    $this->label = $label;
    $this->extension = $extension;
    $this->allowInternal = $allowInternal;
  }
  
  function getKey() {
    return $this->key;
  }
  
  function getLabel() {
    return $this->label;
  }

  function getExtension() {
    return $this->extension;
  }

  function getLoadButton() {
    return 'partial_load_' . $this->key;
  }
  
  function getSaveButton() {
    return 'partial_save_' . $this->key;
  }

  function getUseField() {
    return 'use_internal_' . $this->key;
  }

  function getFileField() {
    return 'internal_' . $this->key;
  }

  function getFullPath($partial, $node=null) {
    $prefix = '/partials/';
    if ($partial->use_folder && !empty($partial->partial_file)) {
      $prefix .= $partial->partial_file . '/';
    }
    if (!empty($node) && $partial->node_prefix) {
      $prefix .= $node->type . '-';
    }
    
    return path_to_theme() . $prefix . $partial->partial_file . $this->extension;
  }

  function getDirPath($partial) {
    $prefix = '/partials/';
    if ($partial->use_folder && !empty($partial->partial_file)) {
      $prefix .= $partial->partial_file . '/';
    }
    return path_to_theme() . $prefix;
  }

  function getVirtualPath($partial) {
    return PARTIAL_PATH_PREFIX . $partial->partial_file . $this->extension;
  }

  function getUseValue($partial) {
    $useField = $this->getUseField();
    return $partial->$useField;
  }
  
  function setUseValue($partial, $value) {
    $useField = $this->getUseField();
    $partial->$useField = $value;
  }
  
  function getFileValue($partial) {
    $fileField = $this->getFileField();
    return $partial->$fileField;
  }
  
  function setFileValue($partial, $value) {
    $fileField = $this->getFileField();
    $partial->$fileField = $value;
  }
  
  function hasPhysicalFile($partial) {
    $fullPath = $this->getFullPath($partial);
    return file_exists($fullPath);
  }

  function resolveFileValue($partial) {
    $template = null;
    $useField = $this->getUseField();
    if ($partial->$useField) {
      $fileField = $this->getFileField();      
      $template = $partial->$fileField;
    } else {
      $fullPath = $this->getFullPath($partial);
      if (file_exists($fullPath)) {
        $fileArray = file($fullPath);
        $template = implode($fileArray);
      }
    }
    return $template;
  }

  function getRealFileValue($partial) {
    $template =  $this->resolveFileValue($partial);
    if ($template) {
      $template = '<code>' . $template . '</code>';
      $template = codefilter_filter('prepare', 0, -1, $template);
      $template = codefilter_filter('process', 0, -1, $template);
      /*
      $useField = $this->getUseField();
      if ($partial->$useField) {
        $template = "<h2>Internal $this->label</h2><div class='internal$this->key'>" . $template . '</div>';
      } else {
        $template = "<h2>$this->label File</h2><div class='file$this->key'>" . $template . '</div>';
      }
      */
    }
    return $template;
  }
}