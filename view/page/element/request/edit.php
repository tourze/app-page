<div class="row-fluid">
    <div class="span9">
        <form class="form-horizontal" method="post">
            <legend><?php echo __('Editing :element', [':element' => __(ucfirst($element->type()))]) ?></legend>

            <?php include Kohana::find_file('views', 'page/error') ?>

            <div class="control-group">
                <label class="control-label" for="name"><?php echo __('Name') ?></label>

                <div class="controls">
                    <input type="text" name="name" class="span12" id="name" value="<?php echo $element->name ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="title"><?php echo __('Title') ?></label>

                <div class="controls">
                    <input type="text" name="title" class="span12" id="title" value="<?php echo $element->title ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="url"><?php echo __('URL') ?></label>

                <div class="controls">
                    <input type="text" name="url" class="span12" id="url" value="<?php echo $element->url ?>"/>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <button class="btn btn-primary" type="submit"><?php echo __('Edit Element') ?></button>
                    <a class="btn" href="<?php echo Route::url('page-admin', [
                        'controller' => 'Entry',
                        'action'     => 'edit',
                        'params'     => $page,
                    ]) ?>"><?php echo __('Cancel') ?></a>
                </div>
            </div>
        </form>
    </div>
</div>
