<?php
  
namespace LibSemanticVersion;

class VersionData 
{
  public $major;
  public $minor;
  public $patch;
  public $prerelease;
  public $metadata;
    
  public function __construct($major, $minor, $patch, $prerelease = "", $metadata = "")
  {
    $this->major = $major;
    $this->minor = $minor;
    $this->patch = $patch;
    $this->prerelease   = trim($prerelease);
    $this->metadata     = trim($metadata);
  }
  
  public function getVersionString()
  {
    $result = $this->major . "." . $this->minor . "." . $this->patch;
    if (strlen($this->prerelease) > 0)
      $result .= "-".$this->prerelease;
    if (strlen($this->metadata) > 0)
      $result .= "+".$this->metadata;
    return $result;
  }
  
}