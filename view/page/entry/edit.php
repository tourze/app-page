<div class="row-fluid">
    <div class="span9">
        <form class="form-horizontal" method="post">
            <legend><?php echo __('Editing Base:') ?> <strong><?php echo $page->name ?></strong></legend>
            <?php include Kohana::find_file('views', 'page/error') ?>

            <?php if ($page->is_link): ?>
                <div
                    class="alert alert-warning"><?php echo __('This is an external link, meaning it is not actually a page managed by this system, but rather it links to a page somewhere else.  To change it to a page that you can control here, uncheck "External Link" below.') ?></div>
            <?php else: ?>
                <h4>
                    <strong><?php echo __('Edit Base Content') ?></strong>
                    <small class="pull-right"><?php echo HTML::anchor(Route::url('page-admin', [
                            'controller' => 'Entry',
                            'action'     => 'edit',
                            'params'     => $page->id
                        ]), __('Click to edit this page\'s content'), ['class' => 'button']) ?></small>
                </h4>
                <hr/>
            <?php endif; ?>

            <div class="control-group">
                <label class="control-label" for="name"><?php echo __('Navigation Name') ?></label>

                <div class="controls">
                    <input name="name" type="text" id="name" class="span12" value="<?php echo $page->name ?>"/>
					<span
                        class="help-block"><?php echo __('This is the name that shows up in the navigation.') ?></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="url"><?php echo __('URL') ?></label>

                <div class="controls">
                    <input name="url" type="text" id="url" class="span12" value="<?php echo $page->url ?>"/>
					<span
                        class="help-block"><?php echo __('This is the "link" to the page, or whats in the address bar.') ?></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="is_link"><?php echo __('External Link') ?></label>

                <div class="controls">
                    <label for="is_link" class="checkbox">
                        <input type="checkbox" class="check" id="is_link" name="is_link"<?php if ($page->is_link)
                        {
                            echo ' checked';
                        } ?> />
                        <?php echo __('Checking this will mean you can\'t edit this page here, it simply links to the URL above.') ?>
                    </label>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="show_nav"><?php echo __('Show in Navigation') ?></label>

                <div class="controls">
                    <label for="show_nav" class="checkbox">
                        <input type="checkbox" class="check" id="show_nav" name="show_nav"<?php if ($page->show_nav)
                        {
                            echo ' checked';
                        } ?> />
                        <?php echo __('Check this to have this page show in the navigation menus.') ?>
                    </label>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="show_map"><?php echo __('Show in Site Map') ?></label>

                <div class="controls">
                    <label for="show_map" class="checkbox">
                        <input type="checkbox" class="check" id="show_map" name="show_map"<?php if ($page->show_map)
                        {
                            echo ' checked';
                        } ?> />
                        <?php echo __('Check this to have this page show in the site map.') ?>
                    </label>
                </div>
            </div>

            <?php if ( ! $page->is_link): ?>
                <hr/>
                <h3><?php echo __('Base Meta Data') ?></h3>

                <div class="control-group">
                    <label class="control-label" for="title"><?php echo __('Title') ?></label>

                    <div class="controls">
                        <input name="title" id="title" type="text" class="span12" value="<?php echo $page->title ?>"/>
						<span
                            class="help-block"><?php echo __('This is what shows up at the top of the window or tab.') ?></span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="metakw"><?php echo __('Meta Keywords') ?></label>

                    <div class="controls">
						<textarea style="height:60px;" id="metakw" class="span12"
                                  name="metakw"><?php echo $page->metakw ?></textarea>
						<span
                            class="help-block"><?php echo __('Keywords are used by search engines to find and rank your page.') ?></span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="metadesc"><?php echo __('Meta Description') ?></label>

                    <div class="controls">
						<textarea style="height:60px;" id="metadesc" class="span12"
                                  name="metadesc"><?php echo $page->metadesc ?></textarea>
						<span
                            class="help-block"><?php echo __('This is used by search engines to summarize your page for visitors.') ?></span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="layout_id"><?php echo __('Layout') ?></label>

                    <div class="controls">
                        <select id="layout_id" name="layout_id">
                            <?php foreach ($layouts AS $layout): ?>
                                <option value="<?php echo $layout->id ?>"<?php if ($layout->id == $page->layout_id)
                                {
                                    echo ' selected';
                                } ?>><?php echo $layout->name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="help-block"><?php echo __('Which layout this page should use.') ?></span>
                    </div>
                </div>
            <?php endif; ?>
            <div class="control-group">
                <div class="controls">
                    <button class="btn btn-primary" type="submit"><?php echo __('Save Changes') ?></button>
                    <a class="btn"
                       href="<?php echo Route::url('page-admin', ['controller' => 'Entry']) ?>"><?php echo __('Cancel') ?></a>
                </div>
            </div>
        </form>
    </div>

    <div class="span3">
        <div class="well">
            <h2><?php echo __('Help') ?></h2>
            <hr/>
            <strong><?php echo __('Edit Base Content') ?></strong>

            <p><?php echo __('Base content in this form only contains the url, navaigation name and other basic settings.') ?></p>
            <hr/>
            <strong><?php echo __('Base Meta Data') ?></strong>

            <p><?php echo __('Base meta can set the meta tags about html when displaying, you can set the keywords and description about the page here.') ?></p>
        </div>
    </div>
</div>
