<h1>Avaiable modules</h1>
<p>This lists all avaiable modules for you to set across your site</p>
<h2>System Modules</h2>
<?php
if (isset($modules)):
  foreach ($modules as $module):
  ?>
  
  <div>
    <?=$module['name'];?>
    <?=$module['dir'];?>
  </div>
  <hr />
  
<?php
  endforeach;
endif;
?>

<h2>Site Modules</h2>

<?php if (isset($moduleList) or $moduleList == false):?>
  <ul>
<?php  foreach ($moduleList as $module):?>
  
  
  <li>
      <div><?=$module->name;?></div>
      <div><?=$module->dir;?></div>      
  </li>
  
<?php endforeach;?>
  <ul>
<?php endif;?>
