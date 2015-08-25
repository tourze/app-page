<?php

//echo "\n<!-- Bread Crumbs -->\n<ul>";
echo "\n<ul>";
$first = true;
foreach ($nodes AS $node)
{
    echo '<li' . ($first ? ' class="first"' : '') . '>';
    echo HTML::anchor($node->url, $node->name);
    echo '</li>';
    $first = false;
}

echo '<li class="last ' . ($first ? ' first' : '') . '">' . $page . "</li></ul>\n<!-- End Bread Crumbs -->";
