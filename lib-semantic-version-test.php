#!/usr/bin/php
<?php
  
  require_once('autoload.php');
  
  $vm = new LibSemanticVersion\VersionManager();
  print_r($vm->getVersionData());
  $vm->init(1, 0, 0, 'beta', '');
  print_r($vm->getVersionData());
  $vm->loadFromString("1.0.0-beta+exp.sha.5114f85");
  
  echo '\$vm->getVersionString() = '.$vm->getVersionString()."\n";
  
  print_r($vm->getVersionData());
  $vm->init(1, 0, 0, 'beta', '');
  $vm->saveToFile('test.json');
  //
