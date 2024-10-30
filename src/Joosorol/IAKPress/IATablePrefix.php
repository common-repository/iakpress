<?php

/*
* This file is part of the IAKPress package.
*
* (c) Joosorol 
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace App\Joosorol\IAKPress;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;

class IATablePrefix
{
  protected $prefix = '';

  public function __construct($prefix)
  {
    $this->prefix = (string) $prefix;
  }

  public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
  {
    $classMetadata = $eventArgs->getClassMetadata();

    // check if prefix is not already append to tableName
    // if not append it
    $length = strlen($this->prefix);
    $str = substr($classMetadata->getTableName(), 0, $length);
    if ($str != $this->prefix) {
      $classMetadata->setTableName($this->prefix . $classMetadata->getTableName());
    }

    foreach ($classMetadata->getAssociationMappings() as $fieldName => $mapping) {
      if ($mapping['type'] == \Doctrine\ORM\Mapping\ClassMetadataInfo::MANY_TO_MANY) {
        $tableName = $classMetadata->associationMappings[$fieldName]['joinTable']['name'];
        $classMetadata->associationMappings[$fieldName]['joinTable']['name'] = $this->prefix . $tableName;
      }
    }
  }
}

