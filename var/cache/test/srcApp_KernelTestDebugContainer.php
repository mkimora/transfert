<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerSd3MCNr\srcApp_KernelTestDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerSd3MCNr/srcApp_KernelTestDebugContainer.php') {
    touch(__DIR__.'/ContainerSd3MCNr.legacy');

    return;
}

if (!\class_exists(srcApp_KernelTestDebugContainer::class, false)) {
    \class_alias(\ContainerSd3MCNr\srcApp_KernelTestDebugContainer::class, srcApp_KernelTestDebugContainer::class, false);
}

return new \ContainerSd3MCNr\srcApp_KernelTestDebugContainer([
    'container.build_hash' => 'Sd3MCNr',
    'container.build_id' => '78421ed4',
    'container.build_time' => 1564475400,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerSd3MCNr');
