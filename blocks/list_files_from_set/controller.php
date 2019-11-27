<?php
namespace Concrete\Package\ListFilesFromSet\Block\ListFilesFromSet;

use Concrete\Core\File\FileList;
use Concrete\Core\Block\BlockController;
use Concrete\Core\Support\Facade\Config;
use Concrete\Core\File\Set\Set as FileSet;
use Concrete\Core\Search\Pagination\PaginationFactory;

class Controller extends BlockController
{
    protected $btInterfaceWidth = 660;
    protected $btInterfaceHeight = 450;
    protected $btTable = 'btListFilesFromSet';
    protected $btWrapperClass = 'ccm-ui';
    protected $btDefaultSet = 'basic';

    public function getBlockTypeDescription()
    {
        return t("Displays a list of files from a file set.");
    }

    public function getBlockTypeName()
    {
        return t("List Files From Set");
    }

    public function getJavaScriptStrings()
    {
        return array('fileset-required' => t('You must select a file set.'));
    }

    public function validate($args)
    {
        $e = $this->app->make('helper/validation/error');
        if ($args['fsID'] < 1) {
            $e->add(t('You must select a file set.'));
        }
        return $e;
    }

    function save($args)
    {
        $args['numberFiles'] = ($args['numberFiles'] > 0) ? $args['numberFiles'] : 0;
        $args['displaySetTitle'] = ($args['displaySetTitle']) ? '1' : '0';
        $args['replaceUnderscores'] = ($args['replaceUnderscores']) ? '1' : '0';
        $args['displaySize'] = ($args['displaySize']) ? '1' : '0';
        $args['displayDateAdded'] = ($args['displayDateAdded']) ? '1' : '0';
        $args['uppercaseFirst'] = ($args['uppercaseFirst']) ? '1' : '0';
        $args['paginate'] = ($args['paginate']) ? '1' : '0';
        $args['forceDownload'] = ($args['forceDownload']) ? '1' : '0';

        parent::save($args);
    }

    public function getFileSetID()
    {
        return $this->fsID;
    }

    public function getFileSetName()
    {
        if ($this->fileSetName)
            return $this->fileSetName;
        else {
            $fs = FileSet::getById($this->fsID);
            if ($fs) {
                return $fs->getFileSetName();
            }
        }

        return false;
    }

    public function view() {
        $this->set('files', $this->getFileSet());
        $this->set('app', $this->app);
    }

    public function getFileSet()
    {
        $fs = FileSet::getById($this->fsID);
        $files = array();

        // if the file set exists (may have been deleted)
        if ($fs && $fs->fsID) {

            $this->fileSetName = $fs->getFileSetName();
            $fl = new FileList();

            if (version_compare(Config::get('concrete.version'), '8.2', '>=')) {
                $fl->ignorePermissions();
            }

            $fl->filterBySet($fs);

            if ($this->fileOrder == 'date_asc')
                $fl->sortBy('fDateAdded', 'asc');
            elseif ($this->fileOrder == 'date_desc')
                $fl->sortBy('fDateAdded', 'desc');
            elseif ($this->fileOrder == 'alpha_asc')
                $fl->sortBy('fvTitle', 'asc');
            elseif ($this->fileOrder == 'alpha_desc')
                $fl->sortBy('fvTitle', 'desc');
            elseif ($this->fileOrder == 'set_order')
                $fl->sortBy('fsDisplayOrder', 'asc');
            elseif ($this->fileOrder == 'set_order_rev')
                $fl->sortBy('fsDisplayOrder', 'desc');

            if ($this->numberFiles > 0){
                $fl->setItemsPerPage($this->numberFiles);
            } else {
                $fl->setItemsPerPage(10000);
            }

            $factory = new PaginationFactory(\Request::getInstance());
            if (method_exists($fl, 'createPaginationObject')) {
                $pagination = $fl->createPaginationObject();
                $pagination = $factory->deliverPaginationObject($fl, $pagination);
            } else {
                $pagination = $factory->createPaginationObject($fl);
            }

            $files = $pagination->getCurrentPageResults();
            if ($pagination->getTotalPages() > 1) {

                if ($this->paginate) {
                    $pagination = $pagination->renderDefaultView();
                    $this->set('pagination', $pagination);
                }
            }
        }

        return $files;
    }


    public function getSearchableContent()
    {
        $files = $this->getFileSet();
        $search = '';
        foreach ($files as $f) {
            $fv = $f->getApprovedVersion();
            $filename = $fv->getFileName();
            $title = $f->getTitle();
            $description = $f->getDescription();
            $tags = $f->getTags();
            $search .= $title . ' ' . $filename . ' ' . $description . ' ' . $tags . '<br/>';
        }
        return $this->getFileSetName() . ' ' . $search;
    }

    public function add() {
        $this->set('app', $this->app);
    }

    public function edit() {
        $this->set('app', $this->app);
    }
}

