<?php  

// Author: Ryan Hewitt - http://www.mesuva.com.au

defined('C5_EXECUTE') or die(_("Access Denied."));

class ListFilesFromSetPackage extends Package {

     protected $pkgHandle = 'list_files_from_set';
     protected $appVersionRequired = '5.6.2.1';
     protected $pkgVersion = '1.0.5';

     public function getPackageDescription() {
          return t("A block to display a list of files from a file set.");
     }

     public function getPackageName() {
          return t("List files from set");
     }
     
     public function install() {
          $pkg = parent::install();
     
          // install block 
          BlockType::installBlockTypeFromPackage('list_files_from_set', $pkg); 
     }
     
}

?>