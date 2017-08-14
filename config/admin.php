<?php

return [
    'prefix' => 'admin',
    'database' => [
        // 后台用户表和模型
        'users_table' => 'admin_users',
        'users_model' => App\Models\Admin::class,
        // 后台角色表和模型
        'roles_table' => 'admin_roles',
        'roles_model' => App\Models\Role::class,
        // 后台权限表和模型
        'permissions_table' => 'admin_permissions',
        'permissions_model' => App\Models\Permission::class,
        // 后台菜单表和模型
        'menu_table' => 'admin_menu',
        'menu_model' => App\Models\Menu::class,
        'user_permissions_table' => 'admin_user_permissions',
        'role_users_table' => 'admin_role_users',
        'role_permissions_table' => 'admin_role_permissions',
        'role_menu_table' => 'admin_role_menu',
    ],
];
