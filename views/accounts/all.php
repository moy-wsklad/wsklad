<?php defined('ABSPATH') || exit;?>

<div class="accounts-all">
    <form method="post" action="">
		<?php
		    $list_table = $args['object'];
		    $list_table->prepareItems();
		?>

		<?php $list_table->display(); ?>
    </form>
</div>
