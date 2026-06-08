# Aform

MediaWiki parser hook extension that provides parser functions for generating HTML form markup.

[![Total Downloads](https://poser.pugx.org/mediawiki/aform/d/total.png)](https://packagist.org/packages/mediawiki/aform)

## Installation

1. Copy the extension directory to `extensions/Aform/`.
2. Add to `LocalSettings.php`:
   ```php
   wfLoadExtension( 'Aform' );
   ```

Requires PHP ≥ 7.2 and MediaWiki with `wfLoadExtension` support.

## Parser Functions

### `#aform` — open a form

```
{{#aform: action=PageName | method=get }}
```

| Parameter | Description |
|---|---|
| `action` | Wiki page name (converted to URL automatically) or absolute URL (`https://`, `http://`, `ftp://`) |
| `method` | `get` or `post` |
| common attrs | `class`, `id`, `style`, `rel`, `itemprop`, `content`, `data-*` |

### `#aformend` — close the form

```
{{#aformend:}}
```

### `#ainput` — single input field

```
{{#ainput: type=text | name=q | value=default | size=20 }}
```

| Parameter | Description |
|---|---|
| `type` | Input type (`text`, `hidden`, `submit`, `checkbox`, etc.) |
| `name` | Field name |
| `value` | Field value |
| `size` | Field width |
| `readonly`, `disabled`, `checked`, `alt` | Standard HTML attributes |
| common attrs | `class`, `id`, `style`, `rel`, `itemprop`, `content`, `data-*` |

### `#ainput_multi` — multiple hidden inputs from a list

```
{{#ainput_multi: type=hidden | list=field1=value1&field2=value2 }}
```

The `list` parameter is an `&`-separated list of `name=value` pairs. Each pair generates one `<input>` element. Other attributes (`type`, `size`, `readonly`, `disabled`, `checked`, `alt`, common attrs) are applied to all generated inputs.

### `#aselect` — select dropdown

```
{{#aselect: name=animal | values=Dog,Cat,Mouse | selected=Dog }}
```

| Parameter | Description |
|---|---|
| `name` | Field name (use `name=field[]` for multi-select) |
| `values` | Comma-separated option values |
| `names` | Comma-separated display labels (parallel to `values`; defaults to value if omitted) |
| `selected` | Comma-separated values to pre-select |
| `sep` | Custom separator character instead of `,` |
| `size` | Visible row count |
| `multiple` | Set to `multiple` to allow multiple selections |
| common attrs | `class`, `id`, `style`, `rel`, `itemprop`, `content`, `data-*` |

### `#alabel` — label element

```
{{#alabel: My Label | for=fieldid | class=form-label }}
```

The first positional argument is the label text. Supports common attrs (`class`, `id`, `style`, `rel`, `itemprop`, `content`, `data-*`).

## Example

```
{{#aform: action={{FULLPAGENAME}} | method=get }}

{{#alabel: Animal | for=animal-select }}

{{#aselect: name=animal[] | multiple=multiple | values=Dog,Cat,Mouse | selected=Dog }}

{{#ainput: type=text | size=4 | name=offset }}

{{#ainput_multi: type=hidden | list=text=House&size=100 }}

{{#aformend:}}
```

## Development

```bash
composer test   # lint (parallel-lint + minus-x)
composer fix    # fix file permissions/line endings
```
