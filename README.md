## lib-semantic-version ##
---

`lib-semantic-version` is a PHP library for working with the semantic version 2.0.0 standard.  See <a href="http://semver.org/spec/v2.0.0.html">semver.org</a>.
[![Build Status](https://travis-ci.org/patinthehat/lib-semantic-version.png)](https://travis-ci.org/patinthehat/lib-semantic-version)

---

### Namespace ###

All classes in `lib-semantic-version` are under the `LibSemanticVersion` namespace.

---

### Classes ###

  - `VersionTypes`: This simply stores constant values for MAJOR, MINOR, and PATCH.
  - `VersionData`: This stores the actual version data: major, minor, patch, prerelease, and metadata.  It also implements a function to generate a valid semver string.
  - `VersionManager`: This class handles saving and loading version string to file, creating VersionData objects from valid semver strings, increasing version numbers, and more.


### Sample Usage ###

  *The file `lib-semantic-version-test.php` shows some example usage of the provided classes, in addition to what is here.*


```php

  //here we load the version data from a string, then save it to a 
  //file for later use
  $vm = new LibSemanticVersion\VersionManager();
  $vm->loadFromString("1.2.0-beta");
  $vm->saveToFile('test.json');

  //---

  //same as the above example, but we use init() here to initialize
  //each portion of the semantic version individually.
  $vm = new LibSemanticVersion\VersionManager();
  $vm->init(1, 2, 0, 'beta', '');
  $vm->saveToFile('test.json');

  //---

  //sample code loading from a string, then using the version
  //manager to increase the patch portion of the version.
  //you can easily specify VersionTypes::MAJOR to increase the
  //major version, and so forth.

  $vm = new LibSemanticVersion\VersionManager();
  $vm->loadFromString("1.2.3");
  $vm->increase();

  //this will output "1.2.4"
  echo $vm->getVersionData()->patch . PHP_EOL;
```

---

### TODO ###

  - [ ] Add more sample code
  - [ ] Add better descriptions for Classes.
  - [ ] Make readme more robust

---

### Pull Requests ###

  - Any pull requests should be accompanied by PHPUnit unit tests.  The aim is for 100% code coverage.

---

### License ###

`lib-semantic-version` is available under the <a href="LICENSE">MIT license</a>.