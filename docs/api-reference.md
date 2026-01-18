# API Reference

Complete API reference for all Infolist components.

## Infolist

The main container component.

### Methods

| Method | Description |
|--------|-------------|
| `make()` | Static factory method |
| `record(mixed $record)` | Set the data record |
| `schema(array $entries)` | Define the entry schema |
| `columns(int $columns)` | Set grid columns (1-4) |

## Entry (Base Class)

All entry types extend the base Entry class.

### Label & Display

| Method | Description |
|--------|-------------|
| `label(string\|Closure\|null $label)` | Set custom label |
| `hiddenLabel(bool $condition)` | Hide the label |
| `placeholder(string\|Closure\|null $placeholder)` | Empty state placeholder |
| `helperText(string\|Closure\|null $text)` | Helper text below content |
| `hint(string\|Closure\|null $hint)` | Hint text next to label |
| `hintIcon(string\|Closure\|null $icon)` | Icon for hint |
| `hintColor(string\|Closure\|null $color)` | Color for hint |
| `tooltip(string\|Closure\|null $tooltip)` | Tooltip on hover |
| `inline(bool $condition)` | Display label and content inline |

### Layout

| Method | Description |
|--------|-------------|
| `columnSpan(int\|string\|null $span)` | Grid column span |
| `columnSpanFull()` | Span full width |
| `columnStart(int\|string\|null $start)` | Grid column start |

### Visibility

| Method | Description |
|--------|-------------|
| `hidden(bool\|Closure $condition)` | Hide entry conditionally |
| `visible(bool\|Closure $condition)` | Show entry conditionally |

### State

| Method | Description |
|--------|-------------|
| `state(mixed $state)` | Override state value |
| `default(mixed $value)` | Default when state is null |
| `formatStateUsing(Closure $callback)` | Format the displayed state |

### Styling

| Method | Description |
|--------|-------------|
| `size(string $size)` | Text size: xs, sm, md, lg, xl, 2xl |
| `weight(string $weight)` | Font weight: thin to black |
| `extraAttributes(array\|Closure $attributes)` | Extra HTML attributes |

## TextEntry

Display text with rich formatting options.

### Formatting

| Method | Description |
|--------|-------------|
| `date(string\|null $format)` | Format as date |
| `dateTime(string\|null $format)` | Format as datetime |
| `time(string\|null $format)` | Format as time |
| `since()` | Relative time (e.g., "2 hours ago") |
| `money(string $currency, string $locale)` | Format as currency |
| `numeric(int $decimalPlaces, string $thousandsSeparator)` | Number formatting |
| `limit(int $length, string $end)` | Limit character length |
| `words(int $count, string $end)` | Limit word count |
| `markdown()` | Render as Markdown |
| `html()` | Render as HTML |

### Lists

| Method | Description |
|--------|-------------|
| `listWithLineBreaks()` | Display array with line breaks |
| `bulleted()` | Display as bulleted list |
| `separator(string $separator)` | Join array with separator |

### Icons

| Method | Description |
|--------|-------------|
| `icon(string\|Closure\|null $icon)` | Display icon |
| `iconPosition(string $position)` | Position: 'before' or 'after' |
| `iconColor(string\|Closure\|null $color)` | Icon color |

### Colors & Badges

| Method | Description |
|--------|-------------|
| `color(string\|Closure\|null $color)` | Text color |
| `badge()` | Display as badge |
| `badgeColor(string\|Closure\|null $color)` | Badge background color |

### Copy & Links

| Method | Description |
|--------|-------------|
| `copyable(bool $condition)` | Enable copy to clipboard |
| `copyMessage(string $message)` | Copy success message |
| `copyMessageDuration(int $ms)` | Message display duration |
| `url(string\|Closure\|null $url)` | Make text a link |
| `openUrlInNewTab(bool $condition)` | Open link in new tab |

## IconEntry

Display icons with optional boolean mode.

| Method | Description |
|--------|-------------|
| `icon(string\|Closure\|null $icon)` | Override icon |
| `size(string $size)` | Icon size: xs, sm, md, lg, xl, 2xl |
| `color(string\|Closure\|null $color)` | Icon color |
| `boolean(bool $condition)` | Enable boolean mode |
| `trueIcon(string $icon)` | Icon for true state |
| `falseIcon(string $icon)` | Icon for false state |
| `trueColor(string $color)` | Color for true state |
| `falseColor(string $color)` | Color for false state |

## ImageEntry

Display single or multiple images.

| Method | Description |
|--------|-------------|
| `size(string $size)` | Image size: xs, sm, md, lg, xl, 2xl |
| `width(int $pixels)` | Custom width |
| `height(int $pixels)` | Custom height |
| `circular()` | Circular shape |
| `square()` | Square shape (no rounding) |
| `stacked()` | Stack multiple images |
| `limit(int $count)` | Limit visible images |
| `remainingCount(int $count)` | Override remaining count |
| `url(string\|Closure\|null $url)` | Link image |
| `openUrlInNewTab(bool $condition)` | Open link in new tab |

## ColorEntry

Display color swatches.

| Method | Description |
|--------|-------------|
| `copyable(bool $condition)` | Enable copy to clipboard |
| `copyMessage(string $message)` | Copy success message |
| `copyMessageDuration(int $ms)` | Message display duration |

## KeyValueEntry

Display key-value pairs in a table.

| Method | Description |
|--------|-------------|
| `keyLabel(string\|null $label)` | Header for key column |
| `valueLabel(string\|null $label)` | Header for value column |

## RepeatableEntry

Display repeated data with nested schema.

| Method | Description |
|--------|-------------|
| `schema(array $entries)` | Nested entry schema |
| `contained(bool $condition)` | Wrap items in container |
| `grid(bool $condition)` | Display as grid |
| `gridColumns(int $columns)` | Grid column count (1-4) |

## Colors

Available color names for `color()`, `badgeColor()`, etc.:

- `primary`
- `secondary`
- `success`
- `warning`
- `danger`
- `info`
- `gray`

## Icons

Icons should use Blade Icons syntax (e.g., Heroicons):

- `heroicon-o-*` - Outline icons
- `heroicon-s-*` - Solid icons
- `heroicon-m-*` - Mini icons
