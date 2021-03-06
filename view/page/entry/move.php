<div class="row-fluid">
    <div class="span9">
        <form class="form-horizontal" method="post">
            <legend><?php echo __('Move Base') ?></legend>
            <div class="control-group">
                <label class="control-label"><?php echo __('Move ":page" to', [':page' => $page->name]) ?></label>

                <div class="controls">
                    <?php
                    echo Form::select('target', $page->select_list('id', 'name', '&nbsp;&nbsp;&nbsp;'));
                    echo Form::select('action', [
                        'before' => __('before'),
                        'after'  => __('after'),
                        'first'  => __('first child of'),
                        'last'   => __('last child of'),
                    ]);
                    ?>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <button class="btn btn-primary" type="submit"><?php echo __('Move Base') ?></button>
                    <a class="btn"
                       href="<?php echo Route::url('page-admin', ['controller' => 'Entry']) ?>"><?php echo __('Cancel') ?></a>
                </div>
            </div>

        </form>

    </div>

    <div class="span3">

        <div class="box">
            <h1><?php echo __('Help') ?></h1>

            <div class="content">

                <p><?php echo __('To move this page to a new location, use the drop downs to choose the new location for the page.<br/><br/>This will move the page, and all of its children to the new location.<br/><br/>Example: If you selected "before" and "Products" the page would be moved to before Products.') ?></p>

            </div>
        </div>

    </div>
</div>
