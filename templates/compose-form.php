<form action="" method="POST" class="wlb-compose-plugin-form <?php echo esc_attr( $attr['class'] ?? '' ); ?>">
    <div class="form-group">
        <label class="control-label" for="plugin_name">
            Plugin Name *
        </label>
        <div class="input-group">
            <input name="plugin_name" id="plugin_name" required class="input-control" placeholder="My Plugin">
            <div class="error-message"> <?php echo $error_messages['plugin_name'] ?? ''; ?></div>
        </div>
        </div>

    <div class="form-group">
        <label class="control-label" for="plugin_description">
            Plugin Description
        </label>
        <textarea name="plugin_description" id="plugin_description"  rows="2" class="input-control" placeholder="Plugin desc."></textarea>
    </div>

    <div class="form-group">
        <label class="control-label" for="plugin_license">
            Plugin License
        </label>
        <input name="plugin_license" id="plugin_license" class="input-control" placeholder="License e.i GPL2">
    </div>

    <div class="form-group">
        <label class="control-label" for="plugin_uri">
            Plugin URL
        </label>
        <input name="plugin_uri" id="plugin_uri" type="url" class="input-control" placeholder="https://company.com/my-plugin" value="">
    </div>
    <div class="form-group">
        <label class="control-label" for="plugin_author_name">
            Author Name
        </label>
        <input name="plugin_author_name" id="plugin_author_name"  class="input-control" placeholder="weLabs">
    </div>
    <div class="form-group">
        <label class="control-label" for="plugin_author_email">
            Author Email
        </label>
        <input name="plugin_author_email" id="plugin_author_email" type="email" class="input-control" placeholder="contact@welabs.dev">
    </div>
    <div class="form-group">
        <label class="control-label" for="plugin_author_uri">
            Author URL
        </label>
        <input name="plugin_author_uri" id="plugin_author_uri" type="url"  class="input-control" placeholder="https://author.profile">
    </div>
    <div class="form-group">
        <label class="control-label" for="plugin_dependency_plugins">
            Dependency Plugins
        </label>
        <input name="plugin_dependency_plugins" id="plugin_dependency_plugins" type="text"  class="input-control" placeholder="woocommerce/woocommerce.php, dokan-lite/dokan.php">
    </div>
    <div class="form-group">
        <label class="control-label" for="plugin_dependency_classes">
            Dependency Classes
        </label>
        <input name="plugin_dependency_classes" id="plugin_dependency_classes" type="text"  class="input-control" placeholder="Woocommerce, WeDevs_Dokan">
    </div>
    <div class="form-group">
        <label class="control-label" for="plugin_dependency_functions">
            Dependency Functions
        </label>
        <input name="plugin_dependency_functions" id="plugin_dependency_functions" type="text"  class="input-control" placeholder="dokan_admin_menu_position, dokana_admin_menu_capability">
    </div>

    <?php wp_nonce_field( 'wlb-compose-plugin', 'wlb-compose-plugin' ); ?>

    <div class="form-group"> 
        <input type="submit" value="<?php echo esc_attr( $attr['submit-text'] ); ?>">
    </div>
</form>