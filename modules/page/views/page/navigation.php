<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 默认使用的bootstrap样式的导航
 * 这里有个BUG，那就是显示的菜单数目小于2时，会有异常。
 */
if (Kohana::$profiling === TRUE)
{
	// Start a new benchmark
	$benchmark = Profiler::start('Page', 'MPTT Crawl');
}
// Change nodes into an array
$nodes = $nodes->as_array();

// Set the defaults
$defaults = array(
	// Options for the header before the nav
	'header'       => FALSE,
	'header_elem'  => 'h3',
	'header_class' => '',
	'header_id'    => '',

	// Options for the list itself
	'class'		=> '',
	'id'		=> '',
	'depth'   	=> 2,
	'sort'		=> 'asc',

	// Options for items
	'current_class' => 'current',
	'first_class' => 'first',
	'last_class'  => 'last',
);
// Merge to create the options
$options = Arr::merge($defaults, $options);
?>
<?php
// Open the ul
/* echo "\n<ul" . ($options['class'] != '' ? " class='{$options['class']}'":'') .
			 ($options['id'] != '' ? " id='{$options['id']}'":'') . ">\n"; */
echo "\n"
	.'<ul'
	.(' class="'.($options['class'] ? $options['class'] : 'nav').'"')
	.($options['id'] ? ' id="'.$options['id'].'"' : '')
	.'>';
$rootlevel = $nodes[1]->{$level_column};
$level = $nodes[1]->{$level_column};
$first = TRUE;
$classes = array('first');

// 是否倒转
//if (isset($options['sort']) AND $options['sort'] == 'desc')
//{
//	$nodes = array_reverse($nodes);
//}

$count = count($nodes);
for ($i=1 ; $i<$count ; $i++)
{
	$attributes = array();
	$next = Arr::get($nodes, $i+1, FALSE);
	$curr = Arr::get($nodes, $i);
	
	// 如果有下级菜单
	if ($options['depth'] > 1 AND $curr->has_children())
	{
		$classes[] = 'dropdown';
		$attributes['data-toggle'] = 'dropdown';
		$attributes['class'] = 'dropdown-toggle';
		$attributes['data-depth'] = $options['depth'];
	}
	if ($options['depth'] > 1 AND $curr->{$level_column} > $level)
	{
		echo '<ul class="dropdown-menu">'."\n";
		$classes[] = $options['first_class'];
	}
	else if ($curr->{$level_column} < $level)
	{
		for( $j=0 ; $j < ($level - $curr->{$level_column}) ; $j++ )
		{
			echo "</li></ul></li>\n";
		}
	}
	else if ( ! $first)
	{
		echo "</li>\n";
	}
	
	for ( $j=0 ; $j < ($curr->{$level_column}) ; $j++ )
	{
		echo "\t";
	}
	
	if ( ! empty($classes))
	{
		$classes = array('class'=>implode(' ', $classes));
	}

	echo "<li" . HTML::attributes($classes). ">" . HTML::anchor($curr->url, $curr->name, $attributes);
	
	$level = $curr->{$level_column};
	$classes = array();
	$first = FALSE;
}

for( $j=0 ; $j < ($curr->{$level_column}) - $rootlevel ; $j++ )
{
	echo "</li></ul>";
}

echo "</li>\n</ul>";

if (isset($benchmark))
{
	// Stop the benchmark
	Profiler::stop($benchmark);
}
?>

