
    <?php if(!empty($forumList)):?>
    <ul>
    <?php foreach($forumList as $forum):?>
      <li>
        <a href="/boards/forum/<?=$forum->id;?>"><?=$forum->name;?></a>
      </li>
      
    <?php endforeach;?>
    </ul>
    <?php else:?>
      No forums Found here
    <?php endif;?>