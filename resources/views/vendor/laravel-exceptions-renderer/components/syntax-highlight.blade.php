@props([
    'code',
    'grammar',
    'lightTheme' => 'light-plus',
    'darkTheme' => 'dark-plus',
    'withGutter' => false,
    'startingLine' => 1,
    'highlightedLine' => null,
    'truncate' => false,
])

@php
    $canHighlight = class_exists(\Phiki\Phiki::class)
        && class_exists(\Phiki\Transformers\Decorations\PreDecoration::class)
        && class_exists(\Phiki\Transformers\Decorations\GutterDecoration::class)
        && class_exists(\Phiki\Transformers\Decorations\LineDecoration::class);

    if ($canHighlight) {
        $highlightedCode = (new \Phiki\Phiki())->codeToHtml($code, $grammar, [
            'light' => $lightTheme,
            'dark' => $darkTheme,
        ])->withGutter($withGutter)
            ->startingLine($startingLine)
            ->decoration(
                \Phiki\Transformers\Decorations\PreDecoration::make()->class('bg-transparent!', $truncate ? ' truncate' : ''),
                \Phiki\Transformers\Decorations\GutterDecoration::make()->class('mr-6 text-neutral-500! dark:text-neutral-600!'),
            );

        if ($highlightedLine !== null) {
            $highlightedCode->decoration(
                \Phiki\Transformers\Decorations\LineDecoration::forLine($highlightedLine)
                    ->class('bg-rose-200! [&_.line-number]:dark:text-white! dark:bg-rose-900!'),
            );
        }
    } else {
        $lines = preg_split("/\r\n|\n|\r/", $code);
        $lineCount = count($lines);
        $lineNumberWidth = strlen((string) ($startingLine + max($lineCount - 1, 0)));

        $preClasses = trim(implode(' ', [
            'bg-slate-900 dark:bg-slate-900',
            'text-slate-100 dark:text-slate-100',
            'text-sm',
            'rounded-lg',
            'p-4',
            'overflow-x-auto',
            $truncate ? 'max-h-72 overflow-y-auto' : '',
        ]));

        $highlightedRows = [];

        foreach ($lines as $offset => $line) {
            $currentLineNumber = $startingLine + $offset;
            $isHighlighted = $highlightedLine !== null && $currentLineNumber === $highlightedLine;
            $lineClasses = $isHighlighted
                ? 'bg-rose-200 text-rose-900 dark:bg-rose-900 dark:text-rose-50'
                : '';

            $gutter = '';

            if ($withGutter) {
                $formattedNumber = str_pad((string) $currentLineNumber, $lineNumberWidth, ' ', STR_PAD_LEFT);
                $gutter = '<span class="inline-block pr-4 text-right text-slate-500 dark:text-slate-400 select-none">'
                    .htmlspecialchars($formattedNumber, ENT_QUOTES, 'UTF-8').'</span>';
            }

            $escapedLine = htmlspecialchars($line === '' ? "\u{00A0}" : $line, ENT_NOQUOTES, 'UTF-8');

            $highlightedRows[] = '<div class="font-mono whitespace-pre '.$lineClasses.'">'
                .$gutter.'<span>'.$escapedLine.'</span></div>';
        }

        $highlightedCode = '<pre class="'.$preClasses.'"><code>'.implode("\n", $highlightedRows).'</code></pre>';
    }
@endphp

<div {{ $attributes }}>
    {!! $highlightedCode ?? '' !!}
</div>
