

<?php $__env->startSection('title','Categories'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row row-cols-md-5">
    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="card col-" style="width: 15rem; cursor: pointer"onclick="window.open('/search?q=category:<?php echo e($category->name); ?>','_parent')">
            <div class="card-img" style="background: <?php echo e($category->color); ?>; border-bottom-right-radius: 0;border-bottom-left-radius: 0"><br><br><br><br></div>
        <div class="card-body">
            <h4 class="card-text"><?php echo e($category->name); ?></h4>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\AmirSobhan_LP\Documents\GitHub\Wallpaper-Tank-App\web-laravel\resources\views/front/category.blade.php ENDPATH**/ ?>