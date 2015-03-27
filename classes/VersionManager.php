<?php

namespace LibSemanticVersion;

class VersionManager
{
  /**
   * 
   * @var VersionData
   */
  protected $versionData;

  public function __construct()
  {
    $this->init(0, 0, 0, '', '');
  }
  
  public function init($major, $minor, $patch, $prerelease, $metadata)
  {
    $this->versionData = new VersionData($major, $minor, $patch, $prerelease, $metadata);
  }
  
  public function saveToFile($filename)
  {
    $json = json_encode($this->versionData);
    file_put_contents($filename, $json);
  }

  protected function get_default($a, $item, $default) {
    return (isset($a[$item]) ? $a[$item] : $default);
  }
    
  public function loadFromFile($filename)
  {
    if (file_exists($filename)) {
      $json = file_get_contents($filename);
      $data = json_decode($json, true);
      $major = $this->get_default($data, 'major', 0);
      $minor = $this->get_default($data, 'minor', 0);
      $patch = $this->get_default($data, 'patch', 0);
      $prerelease = $this->get_default($data, 'prerelease', '');
      $metadata = $this->get_default($data, 'metadata', '');
      $this->versionData = new VersionData($major, $minor, $patch, $prerelease, $metadata);
      
      return true;
    }
    return false;
  }
  
  public function getVersionString()
  {
    return $this->getVersionData()->getVersionString();
  }
  
  public function getVersionData()
  {
    return $this->versionData;
  }
  
  public function loadFromString($versionStr) 
  {
    $re = '/(\d{1,})\.(\d{1,})\.(\d{1,})(-[a-zA-Z0-9\-\.]{1,}){0,1}(\+[a-zA-Z0-9\-\.]{1,}){0,1}/';
    preg_match_all($re, $versionStr, $m);
    $this->versionData->major = $m[1][0];
    $this->versionData->minor = $m[2][0];
    $this->versionData->patch = $m[3][0];
    $this->versionData->prerelease = substr($m[4][0],1);  //strip leading -
    $this->versionData->metadata = substr($m[5][0],1);  //strip leading +
  }
  
  public function major()
  {
    return $this->versionData->major;
  }
  
  public function minor()
  {
    return $this->versionData->minor;
  }
  
  public function patch()
  {
    return $this->versionData->patch;
  }

  public function prerelease()
  {
    return $this->versionData->prerelease;
  }
  
  public function metadata()
  {
    return $this->versionData->metadata;
  }
  
  public function increase($versionType = VersionTypes::PATCH)
  {
    switch($versionType) {
      case VersionTypes::MAJOR:
        $this->versionData->major++;
        //#8: Patch and minor version MUST be reset to 0 when major version is incremented.
        $this->versionData->minor = 0;
        $this->versionData->patch = 0;
        break;
      case VersionTypes::MINOR:
        $this->versionData->minor++;
        //#7: Patch version MUST be reset to 0 when minor version is incremented.
        $this->versionData->patch = 0;
        break;
      case VersionTypes::PATCH:
        $this->versionData->patch++;
        break;
    }
  }
  
}