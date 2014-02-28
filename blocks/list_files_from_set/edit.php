<?php    
defined('C5_EXECUTE') or die("Access Denied.");
$includeAssetLibrary = true;
$al = Loader::helper('concrete/asset_library');
?>

<div class="ccm-block-field-group">
<h2><?php   echo t('Select File Set')?></h2>
<?php   

	Loader::model('file_list');
    Loader::model('file_set');
    $filesets = FileSet::getMySets();
    $fsID = $controller->getFileSetID();
    
?>


<?php   echo t('Display'); ?> 
<input type="text" name="numberFiles" value="<?php   echo $numberFiles?>" style="width: 30px"> <?php   echo t('files from:'); ?> 
 
<select name="fsID">
<?php    
 	
 	echo "<option value=\"\">* " . t('Select File Set') ." *</option>";
 	
    foreach ($filesets as $fset) {
        $fsn = $fset->getFileSetName();
        $selfsID = $fset->getFileSetId();
        
        $select = ''; 
        
        if ($fsID == $selfsID) {
        	$select = ' selected="selected" '; 
        
        }
        
     echo "<option " . $select . " value=\"" . $selfsID. "\">$fsn</option>";    }
?>
</select><br />
<?php   echo t('(leave blank or enter zero for all files in set)'); ?>
<br />
</div><div class="ccm-block-field-group">

<h2><?php   echo t('Ordering')?></h2>
<select name="fileOrder">
<option value="date_desc" <?php   if ($fileOrder == 'date_desc') echo 'selected="selected"';?>><?php   echo t('Date added (newest first)');?></option>
<option value="date_asc" <?php   if ($fileOrder == 'date_asc') echo 'selected="selected"';?>><?php   echo t('Date added (oldest first)');?></option>
<option value="alpha_asc" <?php   if ($fileOrder == 'alpha_asc') echo 'selected="selected"';?>><?php   echo t('Alphabetical');?></option>
<option value="alpha_desc" <?php   if ($fileOrder == 'alpha_desc') echo 'selected="selected"';?>><?php   echo t('Alphabetical (reversed)');?></option>
<option value="set_order" <?php   if ($fileOrder == 'set_order') echo 'selected="selected"';?>><?php   echo t('Set order');?></option>
<option value="set_order_rev" <?php   if ($fileOrder == 'set_order_rev') echo 'selected="selected"';?>><?php   echo t('Set order (reversed)');?></option>
</select>
</div><div class="ccm-block-field-group">

<h2><?php   echo t('Display options')?></h2>
<input type="checkbox" name="displaySetTitle" value="1" <?php    if ($displaySetTitle == 1) { ?> checked <?php    } ?>   />
<?php   echo t('Display name of set');?><br />

<input type="checkbox" name="replaceUnderscores" value="1" <?php    if ($replaceUnderscores == 1) { ?> checked <?php    } ?>   /> <?php   echo t('Replace underscores in titles with spaces');?><br />  

<input type="checkbox" name="uppercaseFirst" value="1" <?php    if ($uppercaseFirst == 1) { ?> checked <?php    } ?>   /> <?php   echo t('Uppercase first letter of title (lowercase rest)');?><br />  

<input type="checkbox" name="displaySize" value="1" <?php    if ($displaySize == 1) { ?> checked <?php    } ?>   /> <?php   echo t('Display file size');?><br /> 

<input type="checkbox" name="displayDateAdded" value="1" <?php    if ($displayDateAdded == 1) { ?> checked <?php    } ?>   /> <?php   echo t('Display date added');?><br /> 
 

<?php   echo t('File extension:'); ?> 
<select name="extension">
<option value="show" <?php   if ($extension == 'show') echo 'selected="selected"';?>><?php   echo t('Leave in title (if present)');?></option>
<option value="hide" <?php   if ($extension == 'hide') echo 'selected="selected"';?>><?php   echo t('Hide');?></option>
<option value="brackets" <?php   if ($extension == 'brackets') echo 'selected="selected"';?>><?php   echo t('Always show (in brackets / column)');?></option>
</select>

</div><div class="ccm-block-field-group">

<h2><?php   echo t('Empty file set message (optional)')?></h2>
<input id="noFilesMessage" name="noFilesMessage" value="<?php   echo $noFilesMessage?>" maxlength="255" style="width: 302px" type="text" >

</div><div class="ccm-block-field-group">

<h2><?php   echo t('Title Override  (optional)')?></h2>
<input id="titleOverride" name="titleOverride" value="<?php   echo $titleOverride?>" maxlength="255" style="width: 302px" type="text" ><br />
<?php   echo t("(will replace title/filename, e.g. 'latest file')"); ?>

</div>