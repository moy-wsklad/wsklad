<?php namespace Wsklad\Admin\Accounts;

defined('ABSPATH') || exit;

use Wsklad\Exceptions\Exception;
use Wsklad\Abstracts\FormAbstract;
use Wsklad\Traits\AccountsUtilityTrait;

/**
 * UpdateForm
 *
 * @package Wsklad\Admin\Accounts
 */
class UpdateForm extends FormAbstract
{
    use AccountsUtilityTrait;

	/**
	 * UpdateForm constructor.
	 */
	public function __construct()
	{
		$this->set_id('accounts-update');

		add_filter('wsklad_' . $this->get_id() . '_form_load_fields', [$this, 'init_fields_main'], 3);
		add_action('wsklad_admin_accounts_update_sidebar_show', [$this, 'output_navigation'], 20);

		$this->load_fields();
	}

	/**
	 * Add for Main
	 *
	 * @param $fields
	 *
	 * @return array
	 */
	public function init_fields_main($fields)
	{
		$options =
		[
			'active' => $this->utilityAccountsGetStatusesLabel('active'),
			'inactive' => $this->utilityAccountsGetStatusesLabel('inactive')
		];

		$fields['status'] =
		[
			'title' => __('Account status', 'wsklad'),
			'type' => 'select',
			'description' => __('Current account status.', 'wsklad'),
			'default' => 'inactive',
			'options' => $options
		];

		return $fields;
	}

	/**
	 * Form show
	 */
	public function output_form()
	{
		$args =
		[
			'object' => $this
		];

		wsklad()->views()->getView('accounts/update_form.php', $args);
	}

	/**
	 * Save
	 *
	 * @return array|boolean
	 */
	public function save()
	{
		$post_data = $this->get_posted_data();

		if(!isset($post_data['_wsklad-admin-nonce']))
		{
			return false;
		}

		if(empty($post_data) || !wp_verify_nonce($post_data['_wsklad-admin-nonce'], 'wsklad-admin-accounts-update-save'))
		{
			wsklad()->admin()->notices()->create
			(
				[
					'type' => 'error',
					'data' => __('Update error. Please retry.', 'wsklad')
				]
			);

			return false;
		}

		foreach($this->get_fields() as $key => $field)
		{
			$field_type = $this->get_field_type($field);

			if('title' === $field_type || 'raw' === $field_type)
			{
				continue;
			}

			try
			{
				$this->saved_data[$key] = $this->get_field_value($key, $field, $post_data);
			}
			catch(Exception $e)
			{
				wsklad()->admin()->notices()->create
				(
					[
						'type' => 'error',
						'data' => $e->getMessage()
					]
				);

				return false;
			}
		}

		return $this->get_saved_data();
	}

	/**
	 * Navigation show
	 */
	public function output_navigation()
	{
        $show = false;

		$args =
        [
            'header' => '<h3 class="p-0 m-0">' . __('Fast navigation', 'wsklad') . '</h3>',
            'object' => $this
        ];

		$body = '<div class="wsklad-toc m-0">';

		$form_fields = $this->get_fields();

		foreach($form_fields as $k => $v)
		{
			$type = $this->get_field_type($v);

			if($type !== 'title')
			{
				continue;
			}

			if(method_exists($this, 'generate_navigation_html'))
			{
                $show = true;
				$body .= $this->{'generate_navigation_html'}($k, $v);
			}
		}

		$body .= '</div>';

        if($show)
        {
	        $args['body'] = $body;

	        wsklad()->views()->getView('accounts/update_sidebar_toc.php', $args);
        }
	}

	/**
	 * Generate navigation HTML
	 *
	 * @param string $key - field key
	 * @param array $data - field data
	 *
	 * @return string
	 */
	public function generate_navigation_html($key, $data)
	{
		$field_key = $this->get_prefix_field_key($key);

		$defaults = array
		(
			'title' => '',
			'class' => '',
		);

		$data = wp_parse_args($data, $defaults);

		ob_start();
		?>
		<a class="list-group-item m-0 border-0" href="#<?php echo esc_attr($field_key); ?>"><?php echo wp_kses_post($data['title']); ?></a>
		<?php

		return ob_get_clean();
	}
}