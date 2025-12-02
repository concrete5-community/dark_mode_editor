[![Tests](https://github.com/concrete5-community/dark_mode_editor/actions/workflows/tests.yml/badge.svg)](https://github.com/concrete5-community/dark_mode_editor/actions/workflows/tests.yml)

# CKEditor Dark Mode Toggle

This package enhances the experience of the Rich Text Editor used by ConcreteCMS (CKEditor) by adding a dedicated toolbar button that allows editors to toggle the background of the editable content area between the default and a dark appearance.

- **Instant Toggling**: easily switch the Rich Text Editor background between default mode and dark mode with a single click of the new toolbar button
- **Improved Readability**: edit light contents using a dark background
- **Toolbar & UI Unchanged**: this toggle only affects the editable area. The surrounding editor toolbar and the ConcreteCMS interface remain in their standard mode, ensuring consistent application navigation.

## Installation

* From the [ConcreteCMS Marketplace](https://market.concretecms.com/products/ckeditor-dark-mode-toggle/5dc7c5ad-ca20-11f0-b970-0affd5227f07)
* For composer-based Concrete instances, simply run:
   ```sh
   composer require concrete5-community/dark_mode_editor
   ```
* Manual installation:
  1. download a `dark_mode_editor-v….zip` file from the [releases page](https://github.com/concrete5-community/dark_mode_editor/releases/latest)
  2. extract the zip file in your `packages` directory

Then, you have to log in to your ConcreteCMS website, go to the *Extend Concrete* > *Add Functionality* dashboard page, and install the package.

## Usage

Once the package is installed, you can activate/deactivate the "Dark Mode Toggle" plugin in the *System & Settings* > *Basics* > *Rich Text Editor* dashboard page.

When the plugin is activated, you'll see a new icon (a circle split vertically into a white half and a black half) in the editor toolbar that, if clicked, lets you toggle the dark background.

## Configuration

Bu default, the plugin will change the background color to black and the text color to white.

If you need to change these colors, you can create the file `application/config/dark_mode_editor/options.php` with some contents like this:

```php
<?php
return [
  // Your custom background color
  'backgroundColor' => '#d0d0d0',
  // Your custom background color
  'textColor' => '#0f0',
];
```

If you don't want to set the color of the text, you can write `'textColor' => '',`

## Credits

This ConcreteCMS package was originally developed by [blinkbox](https://www.blink.ch/).
