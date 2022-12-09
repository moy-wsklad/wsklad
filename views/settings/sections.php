<?php defined('ABSPATH') || exit;

$admins = \Wsklad\Admin\Settings::instance();

$views = [];

foreach($admins->getSections() as $tab_key => $tab_name)
{
	if(!isset($tab_name['visible']) && $tab_name['title'] !== true)
	{
		continue;
	}

	$class = $admins->getCurrentSection() === $tab_key ? ' class="current"' :'';
	$sold_url = esc_url(add_query_arg('do_settings', $tab_key));

	$views[$tab_key] = sprintf
	(
		'<a href="%s" %s>%s </a>',
		$sold_url,
		$class,
		$tab_name['title']
	);
}

if(count($views) < 2)
{
	return;
}

echo "<ul class='subsubsub'>";
foreach($views as $class => $view)
{
	$views[$class] = "<li class='$class'>$view";
}
echo implode(" |</li>", $views) . "</li>";
echo '</ul>';