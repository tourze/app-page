<div class="grid_16">
    <div class="box">
        <h1><?php echo __('Adding :element', [':element' => __(ucfirst($element->type()))]) ?></h1>

        <?php include Kohana::find_file('views', 'page/error') ?>

        <form method="post">
            <p>
                <label
                    for="which"><?php echo __('Select a :element', [':element' => __(ucfirst($element->type()))]) ?></label>
                <select name="element">
                    <?php foreach ($snippets AS $snippet): ?>
                        <option value="<?php echo $snippet->id ?>"><?php echo $snippet->title ?>
                            ( <?php echo $snippet->name ?> )
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <?php echo Form::submit('submit', __('Add Element'), ['class' => 'submit']) ?>
                <?php echo HTML::anchor(Route::url('page-admin', [
                    'controller' => 'Entry',
                    'action'     => 'edit',
                    'params'     => $page
                ]), __('cancel')); ?>
            </p>

        </form>

    </div>
</div>
