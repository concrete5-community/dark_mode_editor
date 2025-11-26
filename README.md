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

## Credits

This ConcreteCMS package was originally developed by [blinkbox](https://www.blink.ch/).
