=== ISW Product Question and Answer for WooCommerce ===
Contributors: isw-team
Tags: woocommerce, product questions, q&a, customer questions, product support
Requires at least: 5.0
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 1.2.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Adds Q&A functionality to WooCommerce products that allows customers to ask questions about products.

== Description ==

ISW Product Question and Answer plugin allows customers to ask questions about WooCommerce products directly on the product page. Administrators can answer questions through an intuitive admin panel.

**Key Features:**

* **Q&A tab on product pages** - Automatically integrates with WooCommerce products
* **Admin panel for management** - Centralized management of all questions and answers
* **Fully customizable design** - Advanced styling options
* **Security and safety** - Implemented WordPress security practices
* **HPOS compatibility** - Supports WooCommerce High-Performance Order Storage
* **Responsive design** - Works on all devices

**Admin Features:**

* View all questions by products
* Filter questions (all/answered/unanswered)
* Approve questions before publishing
* Quick reply through admin interface
* Detailed styling options

**Styling Options:**

* Typography (font, size, color, text transformation)
* Backgrounds and containers (colors, borders, padding, margin)
* Buttons (colors, hover effects, padding, border radius, text transform)
* Customizable button texts
* Live preview in admin panel

**Security:**

* WordPress nonce verification
* Complete sanitization of all input data
* wp_kses validation for HTML output
* User permission checks
* Escape output data
* Input value validation and limiting

== Installation ==

1. Upload plugin files to `/wp-content/plugins/isw-product-question-answer-for-woocommerce/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress admin
3. Go to Products → ISW Product Q&A → Settings for configuration
4. The plugin will automatically add Q&A tab to all WooCommerce products

== Frequently Asked Questions ==

= Is WooCommerce required? =

Yes, this plugin requires WooCommerce plugin to be installed and activated.

= How can I change the appearance of Q&A section? =

Go to Products → ISW Product Q&A → Settings where you can customize typography, colors, buttons and other visual elements.

= Can I moderate questions before publishing? =

Yes, all new questions can be set to "pending" status and manually approved through admin panel.

= Does the plugin work with any theme? =

Yes, the plugin is designed to work with any WordPress/WooCommerce theme. Styling options allow complete customization of appearance.

== Screenshots ==

1. Q&A tab on product page
2. Admin panel for question management
3. Styling options in admin panel
4. Live button preview

== Changelog ==

= 1.2.0 =
* Added advanced styling options
* Live preview functionality for buttons
* Text transform options for buttons
* Customizable button texts
* Enhanced security and sanitization of all input/output data
* Implemented complete sanitization for all settings options
* Added wp_kses validation for HTML output
* Removed debug code
* Added internationalization support
* Added HPOS (High-Performance Order Storage) compatibility
* Changed default language from Serbian to English

= 1.1.0 =
* Added admin panel for question management
* Options for approving/deleting questions
* Improved UI/UX
* Basic styling options

= 1.0.0 =
* Initial version
* Basic Q&A functionality
* WooCommerce integration

== Upgrade Notice ==

= 1.2.0 =
This version adds advanced styling options and improves security. Upgrade recommended.

== Support ==

For support and questions contact ISW team.

== License ==

This plugin is licensed under GPLv2 or later.
