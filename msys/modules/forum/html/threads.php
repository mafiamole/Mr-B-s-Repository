
    <?php if(!empty($threads)):?>
    <ul>
    <?php foreach($threads as $thread):?>
      <li>
        <a href="/boards/thread/<?=$thread->id;?>"><?=$thread->title;?></a>
      </li>
      
    <?php endforeach;?>
    </ul>
    <?php else:?>
      No Threads Found here
    <?php endif;?>