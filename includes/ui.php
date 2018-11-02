
<div class="wrap">

    <h1><?php _e( 'Email Address Encoder', 'email-address-encoder' ); ?></h1>

    <form method="POST" action="options.php">

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
                            <label><input type="radio" name="eae_search_in" value="filters" checked> <?php _e( 'WordPress filters', 'email-address-encoder' ); ?></label><br>
                            <label><input type="radio" name="eae_search_in" value="fullpage"> <?php _e( 'Full page scan', 'email-address-encoder' ); ?> (<a target="_blank" rel="noopener" href="https://encoder.till.im/?utm_source=wp-plugin&utm_medium=setting"><?php _e( 'PRO only', 'email-address-encoder' ); ?></a>)</label>
                        </fieldset>

                        <p class="description" style="max-width: 50em;">
                            <?php _e( 'WordPress filters are slightly faster, but full page scans will find and protect your email addresses in unfiltered sections of your site, such as your footer, custom fields, theme components, etc.', 'email-address-encoder' ); ?>
                        </p>
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
                                <input type="radio" name="eae_technique" value="entities" checked> <?php _e( 'HTML entities', 'email-address-encoder' ); ?>
                                <p class="description">
                                    <small><?php _e( 'Offer good protection and work in most scenarios.', 'email-address-encoder' ); ?></small>
                                </p>
                            </label>
                            <br>

                            <label>
                                <input type="radio" name="eae_technique" value="css-direction"> <?php _e( 'CSS direction', 'email-address-encoder' ); ?> (<a target="_blank" rel="noopener" href="https://encoder.till.im/?utm_source=wp-plugin&utm_medium=setting"><?php _e( 'PRO only', 'email-address-encoder' ); ?></a>)
                                <p class="description">
                                    <small><?php _e( 'Protects against smart robots without the need for JavaScript.', 'email-address-encoder' ); ?></small>
                                </p>
                            </label>
                            <br>

                            <label>
                                <input type="radio" name="eae_technique" value="rot13"> <?php _e( 'ROT13 encoding', 'email-address-encoder' ); ?> (<a target="_blank" rel="noopener" href="https://encoder.till.im/?utm_source=wp-plugin&utm_medium=setting"><?php _e( 'PRO only', 'email-address-encoder' ); ?></a>)
                                <p class="description">
                                    <small><?php _e( 'Offers the best protection, but requires JavaScript.', 'email-address-encoder' ); ?></small>
                                </p>
                            </label>

                        </fieldset>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <?php _e( 'Filter priority', 'email-address-encoder' ); ?>
                    </th>
                    <td>
                        <input name="eae_filter_priority" type="number" min="1" value="<?php echo EAE_FILTER_PRIORITY; ?>" class="small-text">
                        <p class="description" style="max-width: 40em;">
                            <?php _e( 'The filter priority specifies when the plugin searches for and encodes email addresses. The default value of <code>1000</code> ensures that all other plugins have finished their execution and no emails are missed.', 'email-address-encoder' ); ?>
                        </p>
                    </td>
                </tr>

            </tbody>
        </table>

        <p class="submit">
			<?php submit_button( null, 'primary large', 'submit', false ); ?>
		</p>

    </form>

    <div class="card">
        <h2 class="title">
            <?php _e( 'Page Scanner', 'email-address-encoder' ); ?>
        </h2>
        <p>
            <?php _e( 'For your peace of mind and a spam-free inbox, test whether email addresses are encoded on your site.', 'email-address-encoder' ); ?>
        </p>
        <p>
            <a class="button button-secondary" target="_blank" rel="noopener" href="https://encoder.till.im/?utm_source=wp-plugin&amp;utm_medium=banner&amp;domain=<?php echo urlencode( get_home_url() ) ?>">
                <?php _e( 'Open Page Scanner', 'email-address-encoder' ); ?>
            </a>
        </p>
    </div>

</div>
