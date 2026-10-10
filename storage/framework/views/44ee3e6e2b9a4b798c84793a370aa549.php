<?php if($paginator->hasPages()): ?>
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center mt-6">
        <ul class="inline-flex items-center space-x-2">
            
            <?php if($paginator->onFirstPage()): ?>
                <li class="px-3 py-2 text-gray-400 bg-gray-200 rounded-md cursor-not-allowed">
                    &laquo; Précédent
                </li>
            <?php else: ?>
                <li>
                    <a href="<?php echo e($paginator->previousPageUrl()); ?>" class="px-3 py-2 text-white bg-[#45C4EB] rounded-md hover:bg-[#F7881B]">
                        &laquo; Précédent
                    </a>
                </li>
            <?php endif; ?>

            
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(is_string($element)): ?>
                    <li class="px-3 py-2 text-gray-400">...</li>
                <?php endif; ?>

                <?php if(is_array($element)): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <li class="px-3 py-2 text-white bg-[#45C4EB] rounded-md"><?php echo e($page); ?></li>
                        <?php else: ?>
                            <li>
                                <a href="<?php echo e($url); ?>" class="px-3 py-2 text-blue-500 bg-gray-100 rounded-md hover:bg-gray-200">
                                    <?php echo e($page); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <li>
                    <a href="<?php echo e($paginator->nextPageUrl()); ?>" class="px-3 py-2 text-white bg-[#45C4EB] rounded-md hover:bg-[#F7881B]">
                        Suivant &raquo;
                    </a>
                </li>
            <?php else: ?>
                <li class="px-3 py-2 text-gray-400 bg-gray-200 rounded-md cursor-not-allowed">
                    Suivant &raquo;
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>
<?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/vendor/pagination/tailwind.blade.php ENDPATH**/ ?>