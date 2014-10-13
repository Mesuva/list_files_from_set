<?php
defined('C5_EXECUTE') or die("Access Denied.");
use Concrete\Core\File\Set;
$includeAssetLibrary = true;
$al = Loader::helper('concrete/asset_library');
?>

<fieldset>
    <legend><?php echo t('Select File Set') ?></legend>
    <?php

    $filesets = FileSet::getMySets();
    $fsID = $controller->getFileSetID();

    ?>
    <div class="form-group">

        <?php echo t('Display'); ?>
        <input type="text" name="numberFiles" value="<?php echo $numberFiles ?>"
               style="width: 30px"> <?php echo t('files from:'); ?>

        <select name="fsID">
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
        </select><br/>
        <?php echo t('(leave blank or enter zero for all files in set)'); ?>
    </div>

    <div class="form-group">

        <?php  echo $form->checkbox('paginate', '1', $paginate); ?>
        <?php echo $form->label('paginate', t('Display pagination interface if more items are available than are displayed.')); ?>
    </div>

</fieldset>


<fieldset>

    <legend><?php echo t('Ordering') ?></legend>
    <div class="form-group">
        <select name="fileOrder">
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

<fieldset>

    <legend><?php echo t('Display options') ?></legend>
    <div class="form-group">
        <?php  echo $form->checkbox('displaySetTitle', '1', $displaySetTitle); ?>
        <?php echo $form->label('displaySetTitle', t('Display name of set')); ?>
        <br />

        <?php  echo $form->checkbox('replaceUnderscores', '1', $replaceUnderscores); ?>
        <?php echo $form->label('replaceUnderscores', t('Replace underscores in titles with spaces')); ?>
        <br />

        <?php  echo $form->checkbox('uppercaseFirst', '1', $uppercaseFirst); ?>
        <?php echo $form->label('uppercaseFirst', t('Uppercase first letter of title (lowercase rest)')); ?>
        <br />

        <?php  echo $form->checkbox('displaySize', '1', $displaySize); ?>
        <?php echo $form->label('displaySize', t('Display file size')); ?>
        <br />

        <?php  echo $form->checkbox('displayDateAdded', '1', $displayDateAdded); ?>
        <?php echo $form->label('displayDateAdded', t('Display date added')); ?>



        <br/>
        <?php echo t('File extension:'); ?>
        <select name="extension">
            <option
                value="show" <?php if ($extension == 'show') echo 'selected="selected"'; ?>><?php echo t('Leave in title (if present)'); ?></option>
            <option
                value="hide" <?php if ($extension == 'hide') echo 'selected="selected"'; ?>><?php echo t('Hide'); ?></option>
            <option
                value="brackets" <?php if ($extension == 'brackets') echo 'selected="selected"'; ?>><?php echo t('Always show (in brackets / column)'); ?></option>
        </select>
    </div>

</fieldset>

<fieldset>


    <legend><?php echo t('Empty file set message (optional)') ?></legend>
    <div class="form-group">
        <input id="noFilesMessage" name="noFilesMessage" value="<?php echo $noFilesMessage ?>" maxlength="255"
               style="width: 302px" type="text">
    </div>

</fieldset>

<fieldset>

    <div class="form-group">

        <legend><?php echo t('Title Override  (optional)') ?></legend>
        <input id="titleOverride" name="titleOverride" value="<?php echo $titleOverride ?>" maxlength="255"
               style="width: 302px" type="text"><br/>
        <?php echo t("(will replace title/filename, e.g. 'latest file')"); ?>


</fieldset>