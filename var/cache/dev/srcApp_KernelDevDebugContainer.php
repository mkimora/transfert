<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerYl1EcWN\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerYl1EcWN/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerYl1EcWN.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerYl1EcWN\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerYl1EcWN\srcApp_KernelDevDebugContainer([
    'container.build_hash' => 'Yl1EcWN',
    'container.build_id' => 'a20f9dbb',
    'container.build_time' => 1564488978,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerYl1EcWN');
