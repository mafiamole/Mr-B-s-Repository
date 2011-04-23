

  <ul>
    <?php foreach( $menu as $link ):?>
      <li>
        <a href="<?=$link['href'];?>"><?=$link['name'];?></a>
      </li>
    <?php endforeach;?>

</ul>