<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <!-- <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div> -->

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Main Menu', 'options' => ['class' => 'header']],
                    ['label' => 'Clients', 'icon' => 'users', 'url' => ['/clients']],
                    [
                        'label' => 'HR Management',
                        'icon' => 'sitemap',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Employees', 'icon' => 'users', 'url' => ['/employees'],],
                        ],
                    ],
                    [
                        'label' => 'Trip Management',
                        'icon' => 'truck',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Trips', 'icon' => 'road', 'url' => ['/trips'],],
                        ],
                    ],
                    [
                        'label' => 'Vehicle Management',
                        'icon' => 'car',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Vehicles', 'icon' => 'car', 'url' => ['/vehicles'],],
                        ],
                    ],
                    [
                        'label' => 'Maintenance',
                        'icon' => 'wrench',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => 'Employees',
                                'icon' => 'users',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                            [
                                'label' => 'Trips',
                                'icon' => 'truck',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Destinations', 'icon' => 'map-marker', 'url' => ['/destinations'],],
                                    ['label' => 'Expense Lists', 'icon' => 'list-ul', 'url' => ['/expense-lists'],],
                                    ['label' => 'Tax Percentage Lists', 'icon' => 'list-ul', 'url' => ['/tax-percentage-lists'],],
                                ],
                            ],
                            [
                                'label' => 'Others',
                                'icon' => 'gears',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                ],
                            ],
                        ],
                    ],
                    ['label' => 'User', 'icon' => 'user', 'url' => ['/user']],
                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Some tools',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
