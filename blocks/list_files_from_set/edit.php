<?php
defined('C5_EXECUTE') or die("Access Denied.");
use Concrete\Core\File\Set\Set as FileSet;

$includeAssetLibrary = true;
$al = $app->make('helper/concrete/asset_library');
?>

<?php
echo $app->make('helper/concrete/ui')->tabs(array(
    array('fileset', t('Select File Set'), true),
    array('display', t('Display Options'))));

$prefix = '';

$version = $app->make('config')->get('concrete.version');
if (version_compare($version, '9.0', '<')) {
    $prefix = 'ccm-tab-content-';
}

?>

<div class="tab-content">

    <div class="ccm-tab-content tab-pane active" id="<?= $prefix; ?>fileset">
        <fieldset>
            <?php
            $filesets = FileSet::getMySets();
            $fsID = $controller->getFileSetID();
            ?>
            <div class="form-group">

                <label class="control-label mb-2" for="numberFiles"><?php echo t('Display'); ?>
                    <?php echo $form->text('numberFiles', $numberFiles, array('maxlength'=>'10', 'style'=>'display: inline; width: 70px')); ?>
                    <?php echo t('files from:'); ?>
                </label>

                <select name="fsID" class="form-control">
                    <?php

                    echo "<option value=\"\">* " . t('Select File Set') . " *</option>";

                    foreach ($filesets as $fset) {
                        $fsn = $fset->getFileSetName();
                        $selfsID = $fset->getFileSetId();

                        $select = '';

                        if ($fsID == $selfsID) {
                            $select = ' selected="selected" ';
                        }

                        echo "<option " . $select . " value=\"" . $selfsID . "\">$fsn</option>";
                    }
                    ?>
                </select>
                <div class="help-block"><?php echo t('(leave blank or enter zero for all files in set)'); ?></div>
            </div>

            <div class="form-group">
                <div class="form-check">
                    <?php echo $form->checkbox('paginate', '1', $paginate); ?>
                    <?php echo $form->label('paginate', t('Display pagination interface if more items are available than are displayed.')); ?>
                </div>
            </div>

            <div class="form-group">
                <div class="form-check">
                    <?php echo $form->checkbox('forceDownload', '1', $forceDownload); ?>
                    <?php echo $form->label('forceDownload', t('Force files to download')); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->label('fileOrder', t('Ordering')); ?>
                <select name="fileOrder" class="form-control">
                    <option
                            value="date_desc" <?php if ($fileOrder == 'date_desc') echo 'selected="selected"'; ?>><?php echo t('Date added (newest first)'); ?></option>
                    <option
                            value="date_asc" <?php if ($fileOrder == 'date_asc') echo 'selected="selected"'; ?>><?php echo t('Date added (oldest first)'); ?></option>
                    <option
                            value="alpha_asc" <?php if ($fileOrder == 'alpha_asc') echo 'selected="selected"'; ?>><?php echo t('Alphabetical'); ?></option>
                    <option
                            value="alpha_desc" <?php if ($fileOrder == 'alpha_desc') echo 'selected="selected"'; ?>><?php echo t('Alphabetical (reversed)'); ?></option>
                    <option
                            value="set_order" <?php if ($fileOrder == 'set_order') echo 'selected="selected"'; ?>><?php echo t('Set order'); ?></option>
                    <option
                            value="set_order_rev" <?php if ($fileOrder == 'set_order_rev') echo 'selected="selected"'; ?>><?php echo t('Set order (reversed)'); ?></option>
                </select>
            </div>
        </fieldset>
    </div>

    <div class="ccm-tab-content tab-pane " id="<?= $prefix; ?>display">
        <fieldset>
            <div class="form-group">
                <div class="form-check">
                    <?php echo $form->checkbox('displaySetTitle', '1', $displaySetTitle); ?>
                    <?php echo $form->label('displaySetTitle', t('Display name of set')); ?>
                </div>
            </div>

            <div class="form-group">
                <div class="form-check">
                    <?php echo $form->checkbox('replaceUnderscores', '1', $replaceUnderscores); ?>
                    <?php echo $form->label('replaceUnderscores', t('Replace underscores in titles with spaces')); ?>
                </div>
            </div>

            <div class="form-group">
                <div class="form-check">
                    <?php echo $form->checkbox('uppercaseFirst', '1', $uppercaseFirst); ?>
                    <?php echo $form->label('uppercaseFirst', t('Uppercase first letter of title (lowercase rest)')); ?>
                </div>
            </div>

            <div class="form-group">
                <div class="form-check">
                    <?php echo $form->checkbox('displaySize', '1', $displaySize); ?>
                    <?php echo $form->label('displaySize', t('Display file size')); ?>
                </div>
            </div>

            <div class="form-group">
                <div class="form-check">
                    <?php echo $form->checkbox('displayDateAdded', '1', $displayDateAdded); ?>
                    <?php echo $form->label('displayDateAdded', t('Display date added')); ?>
                </div>
            </div>

            <div class="form-group">
                <label for="extension" class="control-label"><?php echo t('File extension:'); ?></label>
                <select name="extension" class="form-control">
                    <option
                            value="show" <?php if ($extension == 'show') echo 'selected="selected"'; ?>><?php echo t('Leave in title (if present)'); ?></option>
                    <option
                            value="hide" <?php if ($extension == 'hide') echo 'selected="selected"'; ?>><?php echo t('Hide'); ?></option>
                    <option
                            value="brackets" <?php if ($extension == 'brackets') echo 'selected="selected"'; ?>><?php echo t('Always show (in brackets / column)'); ?></option>
                </select>
            </div>

            <div class="form-group">
                <label for="noFilesMessage" class="control-label"><?php echo t('Empty file set message (optional)'); ?></label>
                <?php  echo $form->text('noFilesMessage', $noFilesMessage, array('maxlength'=>'255')); ?>
            </div>

            <div class="form-group">
                <label for="titleOverride" class="control-label"><?php echo t('Title Override  (optional)'); ?></label>
                <?php  echo $form->text('titleOverride', $titleOverride, array('maxlength'=>'255')); ?>
                <div class="help-block"><?php echo t("(will replace title/filename, e.g. 'latest file')"); ?></div>
            </div>
        </fieldset>
    </div>

</div>
