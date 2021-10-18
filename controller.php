<?php

// Author: Ryan Hewitt - http://www.mesuva.com.au
namespace Concrete\Package\ListFilesFromSet;
use Concrete\Core\Package\Package;
use Concrete\Core\Block\BlockType\BlockType;

class Controller extends Package {

    protected $pkgHandle = 'list_files_from_set';
    protected $appVersionRequired = '8.0';
    protected $pkgVersion = '1.2';

    public function getPackageDescription() {
        return t("A block to display a list of files from a file set.");
    }

    public function getPackageName() {
        return t("List Files From Set");
    }

    public function install() {
        $pkg = parent::install();
        // install block
        BlockType::installBlockType('list_files_from_set', $pkg);
    }
}
