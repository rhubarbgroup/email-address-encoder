# Email Address Encoder for WordPress

A lightweight plugin that protects plain email addresses and mailto links from email-harvesting robots by encoding them into decimal and hexadecimal entities. Has effect on the posts, pages, comments, excerpts, text widgets and other filtered content. Works without JavaScript — just simple spam protection.

To see whether all your email addresses are properly protected, use the free [page scanner](https://encoder.till.im/scanner?utm_source=wp-plugin&amp;utm_medium=readme) tool.

Other content (like phone numbers) can be protected using `[encode]` shortcode:

```
[encode]+1 (555) 123-4567[/encode]
```

= Premium Features =

* **Full-page protection** that catches all email addresses
* **Hardened protection** using JavaScript and CSS techniques
* Built-in plugin support for **ACF**, **WooCommerce** and many others

Check out the [Premium](https://encoder.till.im/download?utm_source=wp-plugin&amp;utm_medium=readme) version of Email Address Encoder.

## Installation

For detailed installation instructions, please read the [standard installation procedure for WordPress plugins](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins).

1. Upload the `/email-address-encoder/` directory and its contents to `/wp-content/plugins/`.
2. Login to your WordPress installation and activate the plugin through the _Plugins_ menu.
3. Use the "Page Scanner" under _Settings -> Email Encoder_ to test if your email addresses are protected.

### Installing via Composer

Instead of downloading ZIP files, you may also install this plugin using [Composer](https://getcomposer.org/).

```
composer require tillkruss/email-encoder
```
