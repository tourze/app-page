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
                <button class="btn btn-primary" type="submit"><?php echo __('Add Element') ?></button>
                <a class="btn btn-link" href="<?php echo Route::url('page-admin', [
                    'controller' => 'Entry',
                    'action'     => 'edit',
                    'params'     => $page,
                ]) ?>"><?php echo __('cancel') ?></a>
            </p>

        </form>

    </div>
</div>
