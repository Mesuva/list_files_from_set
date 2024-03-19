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
    protected $btInterfaceHeight = 480;
    protected $btTable = 'btListFilesFromSet';
    protected $btWrapperClass = 'ccm-ui';
    protected $btDefaultSet = 'basic';
    protected $fsID;

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
        $args['numberFiles'] = (isset($args['numberFiles']) && (int)$args['numberFiles'] > 0) ? $args['numberFiles'] : 0;
        $args['displaySetTitle'] = (isset($args['displaySetTitle'])) ? '1' : '0';
        $args['replaceUnderscores'] = (isset($args['replaceUnderscores'])) ? '1' : '0';
        $args['displaySize'] = (isset($args['displaySize'])) ? '1' : '0';
        $args['displayDateAdded'] = (isset($args['displayDateAdded'])) ? '1' : '0';
        $args['uppercaseFirst'] = (isset($args['uppercaseFirst'])) ? '1' : '0';
        $args['paginate'] = (isset($args['paginate'])) ? '1' : '0';
        $args['forceDownload'] = (isset($args['forceDownload'])) ? '1' : '0';
        parent::save($args);
    }

    public function getFileSetID()
    {
        $this->fsID = isset($this->fsID) ? $this->fsID : null;
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

        $this->set('numberFiles', 0);
        $this->set('paginate', 1);
        $this->set('forceDownload', 0);
        $this->set('fileOrder', 1);
        $this->set('displaySetTitle', 0);
        $this->set('replaceUnderscores', 1);
        $this->set('uppercaseFirst', 0);
        $this->set('displaySize', 1);
        $this->set('displayDateAdded', 0);
        $this->set('extension', 0);
        $this->set('noFilesMessage', '');
        $this->set('titleOverride', '');
        $this->set('app', $this->app);
    }

    public function edit() {
        $this->set('app', $this->app);
    }
}

