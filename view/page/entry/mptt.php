<?php

use page\Page;

// 加载额外的媒体文件
Page::script('jquery.treeview/jquery.treeview.js');
Page::script('jquery.treeview/jquery.treeview.async.js');
Page::script('page/js/page.js');

$level = $nodes->current()->lvl;
$first = true;
echo '<div id="pagetree-loading"><div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div></div>';
echo "<ul id='pagetree'><div class='clear'></div>";
foreach ($nodes AS $node)
{
// current item is deeper than the item before it, it is a child of the previous item
if ($node->{$level_column} > $level)
{
    echo "<ul>";
}
// current item is less deep than the item before it, how many generations up we did we go?
else if ($node->{$level_column} < $level)
{
    echo "</li>";
    for ($i = 0; $i < ($level - $node->{$level_column}); $i++)
    {
        // close a list and item for each generation that just ended
        echo "</ul></li>";
    }
}
// not starting on ending generations, just close the previous node.
else if ( ! $first)
{
    echo "</li>";
}
?>

<li <?php if ($node->lvl == 0) echo "class='open'" ?>>
    <div class="pageinfo">
        <?php if ($node->is_link)
        {
            echo '<div class="fam-arrow"></div>';
        } ?>
        <div style="float:left">
            <p class='pagename'><?php echo $node->name ?></p>
            <?php
            // echo <p class="pageurl[ is_link]">
            echo "<p class='pageurl" . ($node->is_link ? ' is_link' : '') . "'>";
            // if the link does not have :// in it, echo the url base (like http://example.com/ ) in a span, so its gray
            echo(strpos($node->url, '://') === false ? "<span>" . URL::base(false, true) . "</span>" : '');
            // echo the url, and if its a link, put (Link) after it
            echo $node->url . ($node->is_link ? ' ' . __('(Link)') : '');
            // close pageurl
            echo "</p>";
            ?>
        </div>
        <div class="actions">
            <?php
            echo HTML::anchor($node->url,
                '<i class="icon-ok"></i> ' . __('View'), [
                    'title'  => __('Click to view page'),
                    'target' => '_blank',
                ]);
            echo HTML::anchor(Route::url('page-admin', [
                'controller' => 'Entry',
                'action'     => 'edit',
                'params'     => $node->id
            ]),
                '<i class="icon-edit"></i> ' . __('Edit'), ['title' => __('Click to edit page')]);
            echo HTML::anchor(Route::url('page-admin', [
                'controller' => 'Entry',
                'action'     => 'move',
                'params'     => $node->id,
            ]),
                '<i class="icon-move"></i> ' . __('Move'), ['title' => __('Click to move page')]);
            echo HTML::anchor(Route::url('page-admin', [
                'controller' => 'Entry',
                'action'     => 'add',
                'params'     => $node->id,
            ]),
                '<i class="icon-plus"></i> ' . __('Add'), ['title' => __('Click to add sub-page')]);
            echo HTML::anchor(Route::url('page-admin', [
                'controller' => 'Entry',
                'action'     => 'delete',
                'params'     => $node->id,
            ]),
                '<i class="icon-trash"></i> ' . __('Delete'), ['title' => __('Click to delete page')]);
            ?>

        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>

    <?php
    // set level to this nodes level
    $level = $node->{$level_column};
    $first = false;
    }
    // close a li and ul for each level deep that the very last node was
    for ($i = 0; $i < $level; $i++)
    {
        echo "</li></ul>";
    }
    ?>
