    <ul>
      <li>
          <h2><?=$thread->title;?></h2>
          <?=$thread->body;?>
      </li>
    <?php if(!empty($posts)):?>

    <?php foreach($posts as $post):?>
      <li>
        <h3><?=$post->title;?></h3>
        <div><?=$post->body;?></div>
      </li>
      
    <?php endforeach;?>
    <?php else:?>
      No Posts Found here
    <?php endif;?>
    </ul>
