# TYPO3 Extension `univie_rte_abbr`

Independent **TYPO3 13** / **CKEditor 5** fork of [studiomitte/rte-ckeditor-abbr](https://github.com/studiomitte/rte_ckeditor_abbr).

The plugin lets editors insert `<abbr>` tags with a title in the rich-text editor. The editor UI is based on the [CKEditor 5 abbreviation tutorial](https://github.com/ckeditor/ckeditor5-tutorials-examples/tree/main/abbreviation-plugin/part-1).

## License

GNU General Public License, version 2 or later (`GPL-2.0-or-later`).

Original work Copyright (c) Studio Mitte / Georg Ringer, Wolfgang Höller.

See `LICENSE.txt`.

## Installation

```bash
ddev composer req univie/rte-ckeditor-abbr
```

Flush TYPO3 caches afterwards.

## Usage

After install, the CKEditor toolbar shows a text button **Abbreviation**. No extra RTE YAML is required.

## Credits

Original extension: Georg Ringer and Wolfgang Höller for [Studio Mitte, Linz](https://studiomitte.com).  
Maintainer: Markus.
