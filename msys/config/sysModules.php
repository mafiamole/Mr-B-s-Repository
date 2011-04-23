<?php
/**
 *  sysModules
 * 
 * This includes a list of system modules.
 */
$modules[] = array(
  'name'        => "Admin",
  'dir'         => "system/admin/admin.php",
  'instances'         => "/admin/"
  );
$modules[] = array(
  'name'        => "User",
  'dir'         => "system/user/user.php",
  'instances'         => "/user/"  
  )
?>