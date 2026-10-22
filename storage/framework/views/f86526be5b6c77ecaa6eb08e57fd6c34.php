<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<title><?php echo e(isset($title) && $title ? $title . ' · TaskNest' : 'TaskNest'); ?></title>
<link rel="icon" type="image/svg+xml" href="<?php echo e(asset('favicon.svg')); ?>">


<script>
    (function () {
        try {
            var tema = localStorage.getItem('tasknest-tema');
            if (tema === 'dark' || tema === 'light') {
                document.documentElement.setAttribute('data-theme', tema);
            }
        } catch (e) {}
    })();
    function tnToggleTheme() {
        var atual = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', atual);
        try { localStorage.setItem('tasknest-tema', atual); } catch (e) {}
    }
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

<?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/tasknest.css')); ?>">
<?php /**PATH /tmp/claude-0/full/tasknest/resources/views/partials/head.blade.php ENDPATH**/ ?>