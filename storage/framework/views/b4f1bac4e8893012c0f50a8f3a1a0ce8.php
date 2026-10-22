<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'code',
    'grammar',
    'lightTheme' => 'light-plus',
    'darkTheme' => 'dark-plus',
    'withGutter' => false,
    'startingLine' => 1,
    'highlightedLine' => null,
    'truncate' => false,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'code',
    'grammar',
    'lightTheme' => 'light-plus',
    'darkTheme' => 'dark-plus',
    'withGutter' => false,
    'startingLine' => 1,
    'highlightedLine' => null,
    'truncate' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
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
?>

<div <?php echo e($attributes); ?>>
    <?php echo $highlightedCode ?? ''; ?>

</div>
<?php /**PATH C:\Users\senaj\OneDrive\Documentos\GitHub\tasknest\resources\views/vendor/laravel-exceptions-renderer/components/syntax-highlight.blade.php ENDPATH**/ ?>