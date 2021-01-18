

<?php $__env->startSection('title','Home'); ?>

<?php if(isset($search_value)): ?>
    <?php $__env->startSection('search_value',$search_value); ?>
<?php endif; ?>

<?php $__env->startSection('content'); ?>
    <div class="row row-cols-1 row-cols-md-3">
<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wallpaper): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="container-style col" onclick="window.open('<?php echo e(route('single_wallpaper',['id'=>$wallpaper->id])); ?>','_parent')">
        <div class="img-container">
            <img src="<?php echo e($wallpaper->temp_url); ?>" alt="<?php echo e($wallpaper->title); ?>">
        </div>
        <ul class="wallpaper-info">
            <li><a href="#" target=""><i class="fa fa-heart"></i><span><?php echo e($wallpaper->likes); ?></span></a></li>
            <li><a href="#"><i class="fa fa-download"></i><span><?php echo e($wallpaper->downloads); ?></span></a></li>
            <li><a href="#"><i class="fa fa-eye"></i><span><?php echo e($wallpaper->views); ?></span></a></li>
        </ul>
        <div class="wallpaper-head">
            <h2><?php echo e($wallpaper->title); ?></h2>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\AmirSobhan_LP\Documents\GitHub\Wallpaper-Tank-App\web-laravel\resources\views/front/home.blade.php ENDPATH**/ ?>