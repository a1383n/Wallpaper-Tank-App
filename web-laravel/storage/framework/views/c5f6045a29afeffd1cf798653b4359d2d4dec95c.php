
<?php $__env->startSection('title','Home'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row col-">
            <div class="panel-box col-md-3 col-sm-6 col-xs-12">
        <span class="panel-box-icon bg-success">
            <li class="fa fa-picture-o" style="color: white"></li>
        </span>
                <div class="panel-box-content">
                    <span style="text-transform: uppercase">Wallpapers</span>
                    <span style="display: block;font-weight: bold;font-size: 18px;"><?php echo e($wallpaper->count()); ?></span>
                </div>
            </div>
            <div class="panel-box col-md-3 col-sm-6 col-xs-12">
        <span class="panel-box-icon bg-danger">
            <li class="fa fa-tags" style="color: white"></li>
        </span>
                <div class="panel-box-content">
                    <span style="text-transform: uppercase">Categories</span>
                    <span style="display: block;font-weight: bold;font-size: 18px;"><?php echo e($category->count()); ?></span>
                </div>
            </div>
        <div class="panel-box col-md-3 col-sm-6 col-xs-12">
        <span class="panel-box-icon bg-info">
            <li class="fa fa-android" style="color: white"></li>
        </span>
            <div class="panel-box-content">
                <span style="text-transform: uppercase">Android</span>
                <span style="display: block;font-weight: bold;font-size: 18px;">4</span>
            </div>
        </div>
        <div class="panel-box col-md-3 col-sm-6 col-xs-12">
        <span class="panel-box-icon bg-secondary">
            <li class="fa fa-eye" style="color: white"></li>
        </span>
            <div class="panel-box-content">
                <span style="text-transform: uppercase">Today Views</span>
                <span style="display: block;font-weight: bold;font-size: 18px;"><?php echo e($views->count()); ?></span>
            </div>
        </div>
    </div>

    <canvas id="myChart"></canvas>

    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['<?php echo e($chart_days[4]); ?>','<?php echo e($chart_days[3]); ?>','<?php echo e($chart_days[2]); ?>','<?php echo e($chart_days[1]); ?>','<?php echo e($chart_days[0]); ?>'],
                datasets: [{
                    label: '# of Views',
                    data: ['<?php echo e($chart_values[4]); ?>',<?php echo e($chart_values[3]); ?>,<?php echo e($chart_values[2]); ?>,<?php echo e($chart_values[1]); ?>,<?php echo e($chart_values[0]); ?>]
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\AmirSobhan_LP\Documents\GitHub\Wallpaper-Tank-App\web-laravel\resources\views/admin/home.blade.php ENDPATH**/ ?>