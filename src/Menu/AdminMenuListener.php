<?php

namespace App\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $newSubmenu = $menu
            ->addChild('client')
            ->setLabel('Client')
        ;

        $newSubmenu
            ->addChild('faq', ['route' => 'app_admin_faq_index'])
            ->setLabel('FAQs')
        ;
        $newSubmenu
            ->addChild('banner_image', ['route' => 'app_admin_banner_image_index'])
            ->setLabel('Banner Image')
        ;
    }
}