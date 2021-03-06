<h2>Site Configuration</h2>
<?php
Use html\form;

$moduleOptions = form::optionList();
foreach ($moduleList as $module):
  $moduleOptions->add($module->name,$module->mId);
endforeach;

?>
<?php if (!empty($pages)):?>

  <?php foreach($pages as $pg):?>
  
      <?=form::form_open("/admin/site/change");?>
      
        <label for="title">Title</label>
        
        <input type="text" name="title" value="<?=$pg->title;?>" />
        
        <label for="url">Site URL (relative to site root)</label>
        
        <input type="text" name="url" value="<?=$pg->url;?>" />

        <?=form::select("module",$moduleOptions,$pg->mId);?>
        
        <?=form::hidden("m2Id",$pg->m2Id);?>
        
        <button name="action" value="update">update</button>
        <button name="action" value="remove">remove</button>

      </form>
  <?php endforeach;?>
  
<?php endif;?>

    <h2>Add</h2>
      <form method="post" action="/admin/site/add">
        <label for="title">Title</label>
        
        <input type="text" name="title" />
        
        <label for="url">Site URL (relative to site root)</label>
        
        <input type="text" name="url" />
        <?=form::select("module",$moduleOptions);?>

        <button >Add section</button>
        
      </form>
