
<div class="wrap">

    <h1><?php _e( 'Email Address Encoder', 'email-address-encoder' ); ?></h1>

    <?php if ( get_option( 'eae_notices', '0' ) != '1' && ( ! defined( 'EAE_DISABLE_NOTICES' ) || ! EAE_DISABLE_NOTICES ) ) : ?>

        <div class="card" style="float: left; margin-bottom: 0; margin-right: 1.25rem;">
            <h2 class="title">
                <?php _e( 'Signup for automatic warnings', 'email-address-encoder' ); ?>
            </h2>
            <p>
                <?php printf(
                    __( 'Receive an email notification when any page on <strong>%s</strong> contains unprotected email addresses.', 'email-address-encoder' ),
                    parse_url( get_home_url(), PHP_URL_HOST )
                ); ?>
            </p>
            <form method="post" action="<?php echo admin_url( 'options-general.php?page=eae' ); ?>">
                <?php wp_nonce_field('subscribe'); ?>
                <input type="hidden" name="action" value="subscribe" />
                <p>
                    <input name="eae_notify_email" type="email" placeholder="<?php _e( 'Your email address...', 'email-address-encoder' ); ?>" class="regular-text" style="min-height: 28px;" required>
                    <?php submit_button( __( 'Notify me', 'email-address-encoder' ), 'primary', 'submit', false ); ?>
                </p>
            </form>
        </div>

        <div class="card" style="float: left; min-height: 146px; margin-bottom: 1.5rem;">
            <h2 class="title">
                <?php _e( 'Scan your pages', 'email-address-encoder' ); ?>
            </h2>
            <p>
                <?php _e( 'Don’t want automatic warnings? Use the page scanner to see whether all your email addresses are protected.', 'email-address-encoder' ); ?>
            </p>
            <p>
                <a class="button button-secondary" target="_blank" rel="noopener" href="https://encoder.till.im/scanner?utm_source=wp-plugin&amp;utm_medium=banner&amp;domain=<?php echo urlencode( get_home_url() ) ?>">
                    <?php _e( 'Open Page Scanner', 'email-address-encoder' ); ?>
                </a>
            </p>
        </div>

    <?php endif; ?>

    <form method="post" action="options.php">

        <?php settings_fields( 'email-address-encoder' ); ?>

        <table class="form-table">
            <tbody>

                <tr>
                    <th scope="row">
                        <?php _e( 'Search for emails using', 'email-address-encoder' ); ?>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">
                                <span><?php _e( 'Search for emails using', 'email-address-encoder' ); ?></span>
                            </legend>
                            <label>
                                <input type="radio" name="eae_search_in" value="filters" <?php checked( 'filters', get_option( 'eae_search_in' ) ); ?>>
                                <?php _e( 'WordPress filters', 'email-address-encoder' ); ?>
                                <p class="description">
                                    <small><?php _e( 'Protects email addresses in filtered sections only.', 'email-address-encoder' ); ?></small>
                                </p>
                            </label>
                            <br>
                            <label>
                                <input type="radio" name="eae_search_in" value="filters" disabled>
                                <?php _e( 'Full-page scanner', 'email-address-encoder' ); ?>
                                (<a target="_blank" rel="noopener" href="https://encoder.till.im/download?utm_source=wp-plugin&utm_medium=setting"><?php _e( 'Premium only', 'email-address-encoder' ); ?></a>)
                                <p class="description">
                                    <small><?php _e( 'Protects all email addresses on your site.', 'email-address-encoder' ); ?></small>
                                </p>
                            </label>
                            <br>
                            <label>
                                <input type="radio" name="eae_search_in" value="void" <?php checked( 'void', get_option( 'eae_search_in' ) ); ?>>
                                <?php _e( 'Nothing, don’t do anything', 'email-address-encoder' ); ?>
                                <p class="description">
                                    <small><?php _e( 'Turns off email protection.', 'email-address-encoder' ); ?></small>
                                </p>
                            </label>
                        </fieldset>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <?php _e( 'Protect emails using', 'email-address-encoder' ); ?>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">
                                <span><?php _e( 'Protect emails using', 'email-address-encoder' ); ?></span>
                            </legend>

                            <label>
                                <input type="radio" name="eae_technique" value="entities" checked>
                                <?php _e( 'HTML entities', 'email-address-encoder' ); ?>
                                <p class="description">
                                    <small><?php _e( 'Offers good protection and works in most scenarios.', 'email-address-encoder' ); ?></small>
                                </p>
                            </label>
                            <br>

                            <label>
                                <input type="radio" name="eae_technique" value="css-direction" disabled>
                                <?php _e( 'CSS direction', 'email-address-encoder' ); ?>
                                (<a target="_blank" rel="noopener" href="https://encoder.till.im/download?utm_source=wp-plugin&utm_medium=setting"><?php _e( 'Premium only', 'email-address-encoder' ); ?></a>)
                                <p class="description">
                                    <small><?php _e( 'Protects against smart robots without the need for JavaScript.', 'email-address-encoder' ); ?></small>
                                </p>
                            </label>
                            <br>

                            <label>
                                <input type="radio" name="eae_technique" value="rot13" disabled>
                                <?php _e( 'ROT13 encoding', 'email-address-encoder' ); ?>
                                (<a target="_blank" rel="noopener" href="https://encoder.till.im/download?utm_source=wp-plugin&utm_medium=setting"><?php _e( 'Premium only', 'email-address-encoder' ); ?></a>)
                                <p class="description">
                                    <small><?php _e( 'Offers the best protection, but requires JavaScript.', 'email-address-encoder' ); ?></small>
                                </p>
                            </label>
                            <br>

                            <label>
                                <input type="radio" name="eae_technique" value="rot47" disabled>
                                <?php _e( 'Polymorphous ROT47/CSS', 'email-address-encoder' ); ?>
                                (<a target="_blank" rel="noopener" href="https://encoder.till.im/download?utm_source=wp-plugin&utm_medium=setting"><?php _e( 'Premium only', 'email-address-encoder' ); ?></a>)
                                <p class="description">
                                    <small><?php _e( 'State-of-the-art protection against smart robots, but requires JavaScript.', 'email-address-encoder' ); ?></small>
                                </p>
                            </label>

                        </fieldset>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <?php _e( 'Buffer priority', 'email-address-encoder' ); ?>
                    </th>
                    <td>
                        <label>
                            <input type="checkbox" name="eae_buffer_priority" value="early" disabled>
                            <?php _e( 'Register the output buffer early' ); ?>
                        </label>

                        (<a target="_blank" rel="noopener" href="https://encoder.till.im/download?utm_source=wp-plugin&utm_medium=setting"><?php _e( 'Premium only', 'email-address-encoder' ); ?></a>)

                        <p class="description" style="max-width: 40em;">
                            <?php _e( 'Enable this setting if your theme doesn’t adhere to best practices and the full-page isn’t working.', 'email-address-encoder' ); ?><br>
                        </p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <?php _e( 'Filter priority', 'email-address-encoder' ); ?>
                    </th>
                    <td>
                        <input name="eae_filter_priority" type="number" min="1" value="<?php echo esc_attr( EAE_FILTER_PRIORITY ); ?>" class="small-text">
                        <p class="description" style="max-width: 40em;">
                            <?php _e( 'The filter priority specifies when the plugin searches for and encodes email addresses. The default value of <code>1000</code> ensures that all other plugins have finished their execution and no emails are missed.', 'email-address-encoder' ); ?>
                        </p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <?php _e( 'Notices and promotions', 'email-address-encoder' ); ?>
                    </th>
                    <td>
                        <label for="eae_notices">
                            <?php if ( defined( 'EAE_DISABLE_NOTICES' ) && EAE_DISABLE_NOTICES ) : ?>
                                <input type="checkbox" name="eae_notices" id="eae_notices" value="1" checked disabled>
                            <?php else : ?>
                                <input type="checkbox" name="eae_notices" id="eae_notices" value="1" <?php checked( '1', get_option( 'eae_notices' ) ); ?>>
                            <?php endif; ?>
                            <?php _e( 'Hide notices and promotions for all users', 'email-address-encoder' ); ?>
                        </label>
                    </td>
                </tr>

            </tbody>
        </table>

        <p class="submit">
            <?php submit_button( null, 'primary large', 'submit', false ); ?>
        </p>

    </form>

</div>
