<?php


use LibSemanticVersion\VersionData;

class VersionDataTest extends \PHPUnit_Framework_TestCase
{
  
  public function testConstructor() 
  {
    $verData = new LibSemanticVersion\VersionData(1, 2, 3, "beta", "20150315");

    $this->assertEquals(1, $verData->major);
    $this->assertEquals(2, $verData->minor);
    $this->assertEquals(3, $verData->patch);
    $this->assertEquals('beta', $verData->prerelease);
    $this->assertEquals('20150315', $verData->metadata);
  }
  
  public function testGetVersionString()
  {
    $verData = new LibSemanticVersion\VersionData(1, 2, 3, "beta", "20150315");
    $this->assertEquals('1.2.3-beta+20150315', $verData->getVersionString());
    $verData->metadata = '';
    $this->assertEquals('1.2.3-beta', $verData->getVersionString());
    $verData->prerelease = '';
    $this->assertEquals('1.2.3', $verData->getVersionString());    
  }
  
}
