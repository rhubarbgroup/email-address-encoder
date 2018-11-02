=== Email Address Encoder ===
Contributors: tillkruess
Donate link: https://www.paypal.me/tillkruss
Tags: antispam, anti spam, spam, email, e-mail, mail, spider, crawler, harvester, robots, spambot, block, obfuscate, obfuscation, encode, encoder, encoding, encrypt, encryption, protect, protection
Requires at least: 2.0
Tested up to: 5.0
Requires PHP: 5.3
Stable tag: 1.0.8
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

A lightweight plugin to protect email addresses from email-harvesting robots by encoding them into decimal and hexadecimal entities.


== Description ==

A lightweight plugin to protect plain email addresses and mailto links from email-harvesting robots by encoding them into decimal and hexadecimal entities. Has effect on the posts, pages, comments, excerpts, text widgets and other filtered content. Works without JavaScript — just simple spam protection.


== Installation ==

For detailed installation instructions, please read the [standard installation procedure for WordPress plugins](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins).

1. Upload the `/email-address-encoder/` directory and its contents to `/wp-content/plugins/`.
2. Login to your WordPress installation and activate the plugin through the _Plugins_ menu.
3. Use the "Page Scanner" under _Settings -> Email Encoder_ to test if your email addresses are protected.


== Frequently Asked Questions ==

= What does this plugin do? =

This plugin searches for email addresses using WordPress filters like `the_content`, `widget_text` and others. Found email addresses are encoded using decimal and hexadecimal HTML entities, which obfuscates the email addresses to protect it from being read by most email-harvesting robots.

Alternatively, you can use the `[encode]` shortcode: `[encode]+1 (555) 123-4567[/encode]`

= How can I make sure the plugin works? =

You can use the "Page Scanner" found under _Settings -> Email Encoder_ to test if your email addresses are protected. Alternatively, you can look at the "page source" if your site. **Please note Chrome's Developer Tools, Safari's Web Inspector and others, because they decode decimal and hexadecimal entities into plain text.**

= How can I filter other parts of my site? =

[This guide](https://encoder.till.im/guide) will help you encode all email addresses that aren’t caught.


== Changelog ==

= 1.0.9 =

* Made page scanner notice dismissable
* Only show page scanner notice on Dashboard
* Added setting for filter priority
* Added `EAE_DISABLE_NOTICES` constant to disable all notices and promotions
* Pass site URL along to page scanner
* Moved cross-promotion to plugin screen

= 1.0.8 =

* Added user interface
* Added links to page scanner

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

= 1.0.9 =

This release includes several improvements related to admin notices.

= 1.0.8 =

This release adds a minimal user interface and page scanner.

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
