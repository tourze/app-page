<div class="page-element-control">
    <p class="title"><?php echo $title ?></p>
    <ul class="page-element-actions">
        <li class="edit">
            <a href="<?php echo Route::url('page-admin', [
                'controller' => 'Element',
                'action'     => 'edit',
                'params'     => $block->id,
            ]) ?>">
                <?php echo __('Edit') ?>
            </a>
        </li>
        <li class="moveup">
            <a href="<?php echo Route::url('page-admin', [
                'controller' => 'Element',
                'action'     => 'moveup',
                'params'     => $block->id,
            ]) ?>">
                <?php echo __('Move Up') ?>
            </a>
        </li>
        <li class="movedown">
            <a href="<?php echo Route::url('page-admin', [
                'controller' => 'Element',
                'action'     => 'movedown',
                'params'     => $block->id,
            ]) ?>">
                <?php echo __('Move Down') ?>
            </a>
        </li>
        <li class="delete">
            <a href="<?php echo Route::url('page-admin', [
                'controller' => 'Element',
                'action'     => 'delete',
                'params'     => $block->id,
            ]) ?>">
                <?php echo __('Delete') ?>
            </a>
        </li>
    </ul>
</div>
