<!doctype html>
<html lang="en">
<?php echo $__env->make('front.include.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<body>
<?php echo $__env->make('front.include.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="container">
    <?php if (! empty(trim($__env->yieldContent('search_value')))): ?>
    <div class="row">
        <h1>Search result for: <?php echo $__env->yieldContent('search_value'); ?></h1>
    </div>
        <br>
    <?php endif; ?>

    <?php echo $__env->yieldContent('content'); ?>
</div>
<div class="navbar">

</div>
<script src="<?php echo e(asset('js/app.js')); ?>"></script>
<script src="<?php echo e(asset('js/functions.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\Users\AmirSobhan_LP\Documents\GitHub\Wallpaper-Tank-App\web-laravel\resources\views/front/layout.blade.php ENDPATH**/ ?>