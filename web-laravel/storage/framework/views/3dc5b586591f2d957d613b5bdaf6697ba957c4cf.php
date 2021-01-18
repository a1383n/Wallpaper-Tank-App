

<?php $__env->startSection('title',$wallpaper->title); ?>

<?php $__env->startSection('content'); ?>
    <div class="box">
        <div class="box-image">
            <img src="<?php echo e($wallpaper->temp_url); ?>" alt="<?php echo e($wallpaper->title); ?>">
        </div>
        <div class="box-body">
            <div class="box-title">
                <h1 class="h1 d-inline-block">
                    <?php echo e($wallpaper->title); ?>

                </h1>
                <button class="btn btn-danger d-inline-block float-right m-2" id="like-btn"
                        onclick="Like(<?php echo e($wallpaper->id); ?>)"><span><?php echo e($wallpaper->likes); ?></span>&nbsp;<li
                        class="<?php echo e((\App\Models\WallpaperLikes::isUserLiked($wallpaper->id)) ? 'fa fa-heart' : 'fa fa-heart-o'); ?>"></li>
                </button>
                <button class="btn btn-primary d-inline-block float-right m-2" onclick="Download()">
                    Download&nbsp;<li
                        class="fa fa-download"></li>
                </button>
            </div>
            <div class="box-info">
                <?php
                    $category = \App\Models\Category::find($wallpaper->category_id);
                ?>
                <h4>Category: <a href="/search?q=category:<?php echo e($category->name); ?>"><?php echo e($category->name); ?></a></h4>
                <h4>Author: <?php echo e(\App\Models\User::find($wallpaper->user_id)->name); ?></h4>
                <h4>Tags:</h4>
                <div class="tags-list">
                    <?php $__currentLoopData = explode(",",$wallpaper->tags); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button class="btn btn-secondary tags"><?php echo e($tag); ?></button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <div class="box-footer">
                <div class="d-inline-block">
                    <span class="badge">
                    Create at: <?php echo e($wallpaper->created_at); ?>

                    </span>
                    <br>
                    <span class="badge">
                    Last update at: <?php echo e($wallpaper->updated_at); ?>

                    </span>
                </div>
                <div class="d-inline-block float-right">
                    <br>
                    <p class="badge badge-dark"><?php echo e($wallpaper->views); ?>&nbsp;Views</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        function Like(id) {
            const likeBtn = document.getElementById('like-btn');
            const value = likeBtn.getElementsByTagName('span')[0];
            const formData = new FormData();
            formData.append('id', id);
            if (likeBtn.getElementsByTagName('li')[0].classList[1] == 'fa-heart-o') {
                formData.append('action', 'INCREASE');
            } else {
                formData.append('action', 'DECREASE');
            }
            $.ajax({
                url: '/like',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                data: formData,
                type: "POST",
                contentType: false,
                processData: false,
                success: function (responseJSON) {
                    if (responseJSON['ok']) {
                        value.innerHTML = responseJSON['count'];
                        if (likeBtn.getElementsByTagName('li')[0].classList[1] == 'fa-heart-o') {
                            likeBtn.getElementsByTagName('li')[0].classList.remove('fa-heart-o');
                            likeBtn.getElementsByTagName('li')[0].classList.add('fa-heart');
                        } else {
                            likeBtn.getElementsByTagName('li')[0].classList.remove('fa-heart');
                            likeBtn.getElementsByTagName('li')[0].classList.add('fa-heart-o');
                        }
                    }
                }
            });
        }

        function Download() {
            const formData = new FormData();
            formData.append('id',<?php echo e($wallpaper->id); ?>);
            formData.append('action','DOWNLOAD');

            $.ajax({
                url: "/download",
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                data: formData,
                type: "POST",
                contentType: false,
                processData: false,
                success: function (responseJSON) {

                }
            });
            var a = document.createElement('a');
            a.href = "<?php echo e($wallpaper->wallpaper_url); ?>";
            a.download = "<?php echo e($wallpaper->id."-".basename($wallpaper->wallpaper_url)); ?>";
            a.target = "_blank";
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }


    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\AmirSobhan_LP\Documents\GitHub\Wallpaper-Tank-App\web-laravel\resources\views/front/wallpaper.blade.php ENDPATH**/ ?>