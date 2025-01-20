=== Email Address Encoder ===
Contributors: tillkruess
Donate link: https://github.com/sponsors/tillkruss
Tags: spam, protection, crawler, block, encryption
Requires at least: 2.0
Tested up to: 6.7
Requires PHP: 5.3
Stable tag: 1.0.24
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

A lightweight plugin that protects email addresses from email-harvesting robots, by encoding them into decimal and hexadecimal entities.


== Description ==

A lightweight plugin that protects plain email addresses and mailto links from email-harvesting robots, by encoding them into decimal and hexadecimal entities. Has an effect on the posts, pages, comments, excerpts, text widgets and other filtered content. Works without JavaScript — just simple spam protection.

To see whether all your email addresses are properly protected, use the free [page scanner](https://encoder.till.im/scanner?utm_source=wp-plugin&amp;utm_medium=readme) tool.

Other content (like phone numbers) can be protected using `[encode]` shortcode:

`
[encode]+1 (555) 123-4567[/encode]
[encode link="tel:+15551234567"]+1 (555) 123-4567[/encode]
`

= Premium Features =

* **Full-page protection** that catches all email addresses
* **Hardened protection** using JavaScript and CSS techniques
* Improved **phone number** protection
* Built-in plugin support for **ACF**, **Jetpack**, **WooCommerce** and many others

Check out the [Premium](https://encoder.till.im/download?utm_source=wp-plugin&amp;utm_medium=readme) version of Email Address Encoder.

[](http://coderisk.com/wp/plugin/email-address-encoder/RIPS-r0bJqKvBws)

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

You can use the "Page Scanner" found under _Settings -> Email Encoder_ to see whether all your email addresses are protected. Alternatively, you can manually look at the "page source" of your site.

**Please note:** Chrome’s Developer Tools, Safari’s Web Inspector and others automatically decode decimal and hexadecimal entities. You need to look at the "plain HTML source code".

= How can I filter other parts of my site? =

[This guide](https://encoder.till.im/guide?utm_source=wp-plugin&amp;utm_medium=readme) will help you encode all email addresses that aren’t caught.

== Screenshots ==

1. Settings: Configure the plugin to your needs.
2. Protection: This is how email addresses will look like under the hood.
3. [Premium] Hardened protection: A preview of JavaScript and CSS based techniques
4. [Premium] Phone number protection using polymorphous ROT47/CSS

== Changelog ==

= 1.0.24 =

* Added `class` attribute to `[encode]` shortcode
* Prevent CSRF to flush page caches

= 1.0.23 =

* Fixed potential XSS vulnerability when using `link` shortcode attribute

= 1.0.22 =

* Added `link` attribute to `[encode]` shortcode

= 1.0.21 =

* Changed page slug to avoid issues with the `encode` keyword
* Only search for unprotected emails on public pages
* Show warning when page couldn't be fetched

= 1.0.20 =

* Encode emails in navigation menus

= 1.0.19 =

* Defer loading of email detector script
* Use plugin version as cache buster
* Add "Polymorphous ROT47/CSS" to techniques

= 1.0.18 =

* Show warning when incompatible plugins are installed
* Fixed saving of dismissed notices

= 1.0.17 =

* Offload email detection to web worker
* Flush WP Super Cache and Cachify when saving settings
* Ignore emails in admin bar, debug bar and query monitor

= 1.0.16 =

* Avoid fatal error when using PHP 5.5 or lesser

= 1.0.15 =

* Added `EAE_REGEXP` constant
* Added `eae_email_callback` filter
* Added unprotected email detector to admin bar
* Respect `eae_method` filter in shortcode
* Fixed issue with notices not hiding in some cases
* Flush page cache when saving settings (W3 Total Cache; WP Rocket; LiteSpeed Cache; JCH Optimize)

= 1.0.14 =

* Fixed Dashboard JavaScript issue
* Blocked signup for more non-production domains

= 1.0.13 =

* Resolved issue with WordPress 4.7 and older
* Blocked signup for local domains and IP addresses

= 1.0.12 =

* Avoid fatal error when using PHP 5.3 or lesser

= 1.0.11 =

* Added the ability to get notified when your site contains unprotected email addresses
* Made `EAE_DISABLE_NOTICES` check stricter
* Removed cross-promotion

= 1.0.10 =

* Added option to disable notices and promotions
* Added activation and uninstall callbacks
* Added `$hex` parameter to `eae_encode_str()` method
* Added ability to turn off email encoding
* Various code and UI improvements

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

* Prevented error when `eae_encode_emails()` doesn’t receive a `string`

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

= 1.0.11 =

This release adds the ability to get notified when your site contains unprotected email addresses.

= 1.0.10 =

This release includes several improvements and new features.

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
