# WP Butler
Contributors: japh, jordesign  
License: GPLv2 or later  
License URI: http://www.gnu.org/licenses/gpl-2.0.html  
Tags: admin, actions, butler, autocomplete, automate  
Requires at least: 3.1  
Tested up to: 3.5  
Stable tag: 1.8

Provides a text field in the WP Admin allowing you to jump to common WP Actions.

## Description

### Streamline the way you use the WordPress Admin

WP Butler adds a simple text field to your WordPress Admin, that puts everything at your fingertips. Simply start typing the action you wish to perform, and it will show you all the possible options. You're always a single click away.

### Butler Search

You can now even search your posts from WP Butler. Just type 'search', followed by a keyword from one of your posts, then select the post you were after.

### Internationalisation

WP Butler now supports internationalisation. Most of this is provided by WordPress itself, however the few parts exclusive to WP Butler that need translating could use some help. If you can translate WP Butler to a language other than English, please get in touch!

## Installation

1. Upload the 'wp-butler' folder to the '/wp-content/plugins/' directory
2. Activate the WP Butler plugin through the 'Plugins' menu in WordPress
3. Press `shift+alt+b` on any admin page to launch WP Butler.
4. Work Smarter and Faster!

## Frequently Asked Questions

### Why are the translations a little hinky?

Unfortunately, I don't speak / write any languages besides English well enough to translate, so I used Google Translate to get things started. Hopefully others are willing to contribute further translations, and corrections for the ones Google Translate didn't quite get right.

If you want to contribute a translation, please get in touch with me: https://github.com/Japh/wp-butler/issues?state=open

## Screenshots

1. WP Butler in action

## Changelog

### 1.8

* Adds a filter which allows you to modify the term and actions allowing users to similuate the behavoir of "keyword" actions (ie "search", "edit" and "view"). Props @spivurno.

### 1.7

* Implemented 'edit' alternative keyword for 'search' (more purposeful), also implemented new 'view' keyword. Props @stephenh1988.
* Keywords are now translatable
* Updated keyword translations for Russian, Swedish, Hindi, and Chinese (not reliable, used Google Translate :()
* Added German translations. Props @bueltge.
* Adds settings for Multisite networks. Props @bueltge.
* Implemented capability checks

### 1.6

* Implemented localization, including translations for Russian, Swedish, Hindi, and Chinese

### 1.5

* Added support for the remainder the of admin menu items
* Added support for taxonomies, including custom taxonomies
* Added support for search (core post types only) with keyword 'search'
* Surprise me!

### 1.4

* Added support for custom post types
* No longer shows irrelevant actions in Network Admin

### 1.3

* Plugin description now shows the keyboard shortcut to call your butler.
* Bug fixed where butler input field appear below menu in certain circumstances.

### 1.2

* Changed structure to object-oriented.
* Implemented jQuery UI CSS, props Helen Hou-Sandi ( https://github.com/helenhousandi/wp-admin-jquery-ui )

### 1.1

* Updated to move the functionality to a keyboard shortcut and modal arrangement. Now accessible from any admin screen.

### 1.0

* This is the first initial release to test the concept. Would love to know what you think.
