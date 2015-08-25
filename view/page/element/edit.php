<div class="row-fluid">
    <div class="span9">
        <form class="form-horizontal" method="post">
            <legend><?php echo __('Editing :element', [':element' => __(ucfirst($element->type()))]) ?></legend>

            <?php include Kohana::find_file('views', 'page/error') ?>

            <?php foreach ($element->inputs() AS $label => $input): ?>
                <div class="control-group">
                    <label class="control-label"><?php echo __($label) ?></label>

                    <div class="controls">
                        <?php echo $input ?>
                    </div>
                </div>
            <?php endforeach ?>

            <div class="control-group">
                <div class="controls">
                    <button class="btn btn-primary" type="submit"><?php echo __('Save Changes') ?></button>
                    <?php echo HTML::anchor(Route::url('page-admin', [
                        'controller' => 'Entry',
                        'action'     => 'edit',
                        'params'     => $page
                    ]), __('cancel')); ?>
                </div>
            </div>
        </form>
    </div>
</div>
