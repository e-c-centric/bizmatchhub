<?php
// filepath: /c:/xampp/htdocs/bizmatchhub/views/common.php

$menuItems = [
    [
        'label' => 'BizMatch Hub Business',
        'link' => 'business.php',
        'visible' => true,
    ],
    [
        'label' => 'Browse Categories',
        'link' => 'hire.php',
        'visible' => true,
    ],

    [
        'label'=> 'Chat',
        'link' => 'chat.php',
        'visible' => true,
    ],

    [
        'label' => 'Payments',
        'link' => 'payment.php',
        'visible' => true,
    ],
    // [
    //     'label' => 'Payments',
    //     'link' => 'payment.php',
    //     'visible' => true,
    // ],
    // [
    //     'label' => 'Payments',
    //     'subItems' => [
    //         [
    //             'label' => 'English',
    //             'link' => '#',
    //         ],
    //         [
    //             'label' => 'French',
    //             'link' => '#',
    //         ],
    //     ],
    //     'visible' => true,
    // ],
];

function renderMenu($menuItems, $isMobile = false)
{
    foreach ($menuItems as $item) {
        if (!$item['visible']) {
            continue; // Skip items that shouldn't be visible
        }

        // Check if the item has sub-items (dropdown)
        if (isset($item['subItems']) && is_array($item['subItems'])) {
            // Dropdown menu
            echo '<li class="nav-item dropdown col-auto">';
            echo '<a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">';
            echo htmlspecialchars($item['label']);
            echo '</a>';
            echo '<ul class="dropdown-menu">';

            foreach ($item['subItems'] as $subItem) {
                echo '<li><a class="dropdown-item" href="' . htmlspecialchars($subItem['link']) . '">';
                echo htmlspecialchars($subItem['label']);
                echo '</a></li>';
            }

            echo '</ul>';
            echo '</li>';
        } else {
            // Single link
            echo '<li class="nav-item col-auto">';
            echo '<a class="nav-link" href="' . htmlspecialchars($item['link']) . '">';
            echo htmlspecialchars($item['label']);
            echo '</a>';
            echo '</li>';
        }
    }
}
?>