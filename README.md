# Email Address Encoder for WordPress

A lightweight plugin to protect plain email addresses and mailto links from email-harvesting robots by encoding them into decimal and hexadecimal entities. Has effect on the posts, pages, comments, excerpts and text widgets. No UI, no shortcode, no JavaScript — just simple spam protection.


## Installation

For detailed installation instructions, please read the [standard installation procedure for WordPress plugins](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins).

1. Upload the `/email-address-encoder/` directory and its contents to `/wp-content/plugins/`.
2. Login to your WordPress installation and activate the plugin through the _Plugins_ menu.
3. Done. This plugin has no user interface or configuration options.


## Frequently Asked Questions

#### What does this plugin do?

This plugin hooks into the WordPress filters like `the_content`, `widget_text` and others (additional filters can be added). On each filter a quick (disableable) search for an @-sign is performed. If an @-sign is found, a (overridable) regular expression looks for plain text email addresses. Found email addresses are replaced with the return value of `eae_encode_str()` (changeable), which obfuscates the email addresses to protect it from being read by email-harvesting robots. This function is slightly faster than WP's built-in `antispambot()` and uses additional hexadecimal entities.

Alternatively, you can use the `[encode]` shortcode: `[encode]+1 (234) 567-8900[/encode]`

#### How can I make sure the plugin works?

You cannot use Firebug, Web Inspector or Dragonfly, because they decode decimal/hexadecimal entities into plain text. To make sure email addresses are encoded, right-/secondary-click the page, click "View Source", "View Page Source" or "Source" and search for any plain text email addresses. In Firefox, be sure to test with "View Source" not "View Selection Source".

#### How can I use WP's built-in `antispambot()` function instead?

You specify any valid callback function with the `eae_method` filter to apply to found email addresses: `add_filter('eae_method', function() { return 'antispambot'; });`

#### How can I filter other parts of my site?

- If the content supports WordPress filters, register the `eae_encode_emails()` function to it: `add_filter( $tag, 'eae_encode_emails' );`.
- If the content is a PHP string, run it through the `eae_encode_emails()` function: `$text = eae_encode_emails( $text );`.
- If you want to encode a single email address, use the `eae_encode_str()` function: `<?php echo eae_encode_str( 'name@domain.com' ); ?>`

This plugin doesn't encode the entire website for performance reasons, it encodes only the content of the following WordPress filters `the_content`, `the_excerpt`, `widget_text`, `comment_text`, `comment_excerpt`.

#### How can I change the regular expression pattern?

You can override [the pattern](http://fightingforalostcause.net/misc/2006/compare-email-regex.php "Comparing E-mail Address Validating Regular Expressions") with the `eae_regexp` filter: `add_filter( 'eae_regexp', function () { return '/^pattern$/'; } );`

#### How can I change the priority of the default filters?

The default filter priority is `1000` and you can adjust it by defining the `EAE_FILTER_PRIORITY` constant: `define( 'EAE_FILTER_PRIORITY', 99999 );`. The constant has to be defined before this plugin is loaded, e.g. in your `wp-config.php` or in Must-use plugin (a.k.a. mu-plugin).

#### How can I disable the @-sign check?

Like this: `add_filter( 'eae_at_sign_check', '__return_false' );`
