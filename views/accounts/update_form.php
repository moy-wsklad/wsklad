<?php defined('ABSPATH') || exit;?>

<?php do_action('wsklad_admin_accounts_update_form_before_show'); ?>

<div class="row g-0">
    <div class="col-24 col-lg-17 p-0">
        <div class="pe-0 pe-lg-2">
            <form method="post" action="<?php echo esc_url(add_query_arg('form', $args['object']->getId())); ?>">
                <?php wp_nonce_field('wsklad-admin-accounts-update-save', '_wsklad-admin-nonce'); ?>
                <div class="bg-white p-2 pt-0 rounded-3 wsklad-toc-container section-border">
                    <table class="form-table wsklad-admin-form-table">
                        <?php $args['object']->generateHtml($args['object']->getFields(), true); ?>
                    </table>
                </div>
                <p class="submit mt-0">
                    <input type="submit" name="submit" id="submit" class="button button-primary p-1 fs-6 px-3" value="<?php _e('Save account', 'wsklad'); ?>">
                </p>
            </form>
        </div>
    </div>
    <div class="col-24 col-lg-7 p-0">
        <?php do_action('wsklad_admin_accounts_update_sidebar_show'); ?>
    </div>
</div>

<?php do_action('wsklad_admin_accounts_update_form_after_show'); ?>
