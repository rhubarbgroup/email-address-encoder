=== Email Address Encoder ===
Contributors: tillkruess
Donate link: https://www.paypal.me/tillkruss
Tags: antispam, anti spam, spam, email, e-mail, mail, spider, crawler, harvester, robots, spambot, block, obfuscate, obfuscation, encode, encoder, encoding, encrypt, encryption, protect, protection
Requires at least: 2.0
Tested up to: 4.9
Requires PHP: 5.3
Stable tag: 1.0.7
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

A lightweight plugin to protect email addresses from email-harvesting robots by encoding them into decimal and hexadecimal entities.


== Description ==

A lightweight plugin to protect plain email addresses and mailto links from email-harvesting robots by encoding them into decimal and hexadecimal entities. Has effect on the posts, pages, comments, excerpts and text widgets. No UI, no JavaScript — just simple spam protection.


== Installation ==

For detailed installation instructions, please read the [standard installation procedure for WordPress plugins](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins).

1. Upload the `/email-address-encoder/` directory and its contents to `/wp-content/plugins/`.
2. Login to your WordPress installation and activate the plugin through the _Plugins_ menu.
3. Done. This plugin has no user interface or configuration options.


== Frequently Asked Questions ==

= What does this plugin do? =

This plugin hooks into the WordPress filters like `the_content`, `widget_text` and others (additional filters can be added). On each filter a quick (disableable) search for an @-sign is performed. If an @-sign is found, a (overridable) regular expression looks for plain text email addresses. Found email addresses are replaced with the return value of `eae_encode_str()` (changeable), which obfuscates the email addresses to protect it from being read by email-harvesting robots. This function is slightly faster than WP's built-in `antispambot()` and uses additional hexadecimal entities.

Alternatively, you can use the `[encode]` shortcode: `[encode]+1 (234) 567-8900[/encode]`

= How can I make sure the plugin works? =

You cannot use Firebug, Web Inspector or Dragonfly, because they decode decimal/hexadecimal entities into plain text. To make sure email addresses are encoded, right-/secondary-click the page, click "View Source", "View Page Source" or "Source" and search for any plain text email addresses. In Firefox, be sure to test with "View Source" not "View Selection Source".

= How can I use WP's built-in `antispambot()` function instead? =

You specify any valid callback function with the `eae_method` filter to apply to found email addresses: `add_filter('eae_method', function() { return 'antispambot'; });`

= How can I filter other parts of my site? =

* If the content supports WordPress filters, register the `eae_encode_emails()` function to it: `add_filter( $tag, 'eae_encode_emails' );`
* If the content is a PHP string, run it through the `eae_encode_emails()` function: `$text = eae_encode_emails( $text );`
* If you want to encode a single email address, use the `eae_encode_str()` function: `<?php echo eae_encode_str( 'name@domain.com' ); ?>`

This plugin doesn't encode the entire website for performance reasons, it encodes only the content of the following WordPress filters `the_content`, `the_excerpt`, `widget_text`, `comment_text`, `comment_excerpt`.

= How can I change the regular expression pattern? =

You can override [the pattern](http://fightingforalostcause.net/misc/2006/compare-email-regex.php "Comparing E-mail Address Validating Regular Expressions") with the `eae_regexp` filter: `add_filter( 'eae_regexp', function () { return '/^pattern$/'; } );`

= How can I change the priority of the default filters? =

The default filter priority is `1000` and you can adjust it by defining the `EAE_FILTER_PRIORITY` constant: `define( 'EAE_FILTER_PRIORITY', 99999 );`. The constant has to be defined before this plugin is loaded, e.g. in your `wp-config.php` or in Must-use plugin (a.k.a. mu-plugin).

= How can I disable the @-sign check? =

Like this: `add_filter( 'eae_at_sign_check', '__return_false' );`


== Changelog ==

= 1.0.7 =

* Prevent potential compatibility issue with other plugins or themes

= 1.0.6 =

* Added `[encode]` shortcode
* Require PHP 5.3 to fix deprecation warning

= 1.0.5 =

* Prevented error when `eae_encode_emails()` doesn't receive a `string`

= 1.0.4 =

* Added `EAE_FILTER_PRIORITY` constant to adjust default filter priority

= 1.0.3 =

* Added filter to override the encoding function
* Improved randomness of encode-function
* Improved speed by doing fast @-sign existence check

= 1.0.2 =

* Added filter to override the regular expression.

= 1.0.1 =

* Effects now also page, post and comment excerpts

= 1.0 =

* Initial release


== Upgrade Notice ==

= 1.0.7 =

This release prevents potential compatibility issues.

= 1.0.6 =

This release adds PHP 7.2 compatibility and a new shortcode.

= 1.0.5 =

This update includes a minor bug fix.

= 1.0.4 =

Added constant to adjust default filter priority.

= 1.0.3 =

Speed and "randomness" improvements.

= 1.0.2 =

Added filter to override the regular expression.

= 1.0.1 =

Effects now also page, post and comment excerpts.
