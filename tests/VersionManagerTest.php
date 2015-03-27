<?php


use LibSemanticVersion\VersionManager;
use LibSemanticVersion\VersionTypes;

class VersionManagerTest extends \PHPUnit_Framework_TestCase
{
  protected $testFiles = array();
  
  protected function generateRandomTestFilename()
  {
    $n = mt_rand(999, 9999999);
    $fn = "~TESTFILE$n.test";
    return $fn;
  }
  
  protected function addTestFile($filename)
  {
    $this->testFiles[] = $filename;  
  }
  
  protected function addRandomTestFile() 
  {
    $fn = $this->generateRandomTestFilename();
    $this->addTestFile($fn);
    return $fn;
  }
  
  protected function cleanupTestFiles()
  {
    foreach($this->testFiles as $tfn) {
      if (file_exists($tfn))
        unlink($tfn);
    }
    $this->testFiles = array();
  }
  
  function tearDown()
  {
    $this->cleanupTestFiles();  
  }
  
  public function testInitAndGetVersionData() 
  {
    $vm = $this->getMockBuilder('LibSemanticVersion\VersionManager')
            ->disableOriginalConstructor()
            ->setMethods(array('getVersionString'))
            ->getMock();
   
    $vm->init(1, 2, 0, '', '');
    $this->assertEquals(1, $vm->getVersionData()->major);
    $this->assertEquals(2, $vm->getVersionData()->minor);
    $this->assertEquals(0, $vm->getVersionData()->patch);
  }
  
  public function testIncrease()
  {
    $vm = new LibSemanticVersion\VersionManager();
    $vm->init(1, 2, 3, '', '');
    $vm->increase(VersionTypes::MAJOR);
    $this->assertEquals(2, $vm->getVersionData()->major);
    $this->assertEquals(0, $vm->getVersionData()->minor);
    $this->assertEquals(0, $vm->getVersionData()->patch);
    
    $vm->init(1, 2, 3, '', '');
    $vm->increase(VersionTypes::MINOR);
    $this->assertEquals(1, $vm->getVersionData()->major);
    $this->assertEquals(3, $vm->getVersionData()->minor);
    $this->assertEquals(0, $vm->getVersionData()->patch);
    
    $vm->init(1, 2, 3, '', '');
    $vm->increase(VersionTypes::PATCH);
    $this->assertEquals(1, $vm->getVersionData()->major);
    $this->assertEquals(2, $vm->getVersionData()->minor);
    $this->assertEquals(4, $vm->getVersionData()->patch);
  }
  
  public function testVersionShortcutMethods()
  {
    $vm = new LibSemanticVersion\VersionManager();
    $vm->init(1, 2, 3, 'alpha', 'sha.1a2b3c');
    $this->assertEquals(1, $vm->major());
    $this->assertEquals(2, $vm->minor());
    $this->assertEquals(3, $vm->patch());
    $this->assertEquals('alpha', $vm->prerelease());
    $this->assertEquals('sha.1a2b3c', $vm->metadata());
  }

  public function testLoadFromString()
  {
    $vm = new LibSemanticVersion\VersionManager();
    $vm->loadFromString('1.2.3-pr.1+md1');
    $this->assertEquals(1, $vm->major());
    $this->assertEquals(2, $vm->minor());
    $this->assertEquals(3, $vm->patch());
    $this->assertEquals('pr.1', $vm->prerelease());
    $this->assertEquals('md1', $vm->metadata());
  }
  
  public function testSaveToFile()
  {
    $fn = $this->addRandomTestFile();
    $vm = new LibSemanticVersion\VersionManager();
    $vm->saveToFile($fn);
    $this->assertJsonStringEqualsJsonFile($fn, json_encode($vm->getVersionData()));
    $this->assertTrue(file_exists($fn));
    $this->cleanupTestFiles();
  }
  
  public function testLoadFromFile()
  {
    $fn = $this->addRandomTestFile();
    $data = '{"major":1,"minor":2,"patch":3,"prerelease":"beta","metadata":"md"}';
    file_put_contents($fn, $data);
    $vm = new LibSemanticVersion\VersionManager();
    
    $this->assertTrue($vm->loadFromFile($fn));
    $this->assertEquals(1, $vm->getVersionData()->major);
    $this->assertEquals(2, $vm->getVersionData()->minor);
    $this->assertEquals(3, $vm->getVersionData()->patch);
    $this->assertEquals('beta', $vm->getVersionData()->prerelease);
    $this->assertEquals('md', $vm->getVersionData()->metadata);
    $this->assertFalse( $vm->loadFromFile("~BADFILE".$this->generateRandomTestFilename()) );
    $this->cleanupTestFiles();
  }
  
}
