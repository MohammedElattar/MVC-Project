<!-- **********************************************************************************************************************************************************
    MAIN SIDEBAR MENU
*********************************************************************************************************************************************************** -->
<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">

            <p class="centered"><a href="profile.html"><img src="<?= ASSETS_ADMIN ?>img/ui-sam.jpg" class="img-circle" width="60"></a></p>
            <h5 class="centered"><?= $_SESSION['data']['name'] ?></h5>
            <li class="mt">
                <a href="<?= ROOT ?>admin">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="<?= ROOT ?>admin/products">
                    <i class="fa fa-desktop"></i>
                    <span>Products</span>
                </a>
                <ul class="sub">
                    <li><a href="<?= ROOT ?>admin/products/show">View Products</a></li>
                    <li><a href="<?= ROOT ?>admin/products/add">Add New Product</a></li>
                    <li><a href="<?= ROOT ?>admin/products/edit">Edit Product</a></li>
                    <li><a href="<?= ROOT ?>admin/products/delete">Delete Product</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="<?= ROOT ?>admin/categories">
                    <i class="fa fa-desktop"></i>
                    <span>Categories</span>
                </a>
                <ul class="sub">
                    <li><a href="<?= ROOT ?>admin/categories/">View Categories</a></li>
                    <li><a href="<?= ROOT ?>admin/categories/add">Add New Category</a></li>
                    <li><a href="<?= ROOT ?>admin/categories/edit">Edit Category</a></li>
                    <li><a href="<?= ROOT ?>admin/categories/delete">Delete Category</a></li>
                </ul>
            </li>

            <li class="sub-menu">
                <a href="<?= ROOT ?>admin/orders">
                    <i class="fa fa-desktop"></i>
                    <span>Orders</span>
                </a>
                <ul class="sub">
                    <li><a href="<?= ROOT ?>admin/orders/add">Add</a></li>
                    <li><a href="<?= ROOT ?>admin/orders/edit">Edit</a></li>
                    <li><a href="<?= ROOT ?>admin/orders/delete">Delete</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="<?= ROOT ?>admin/settings">
                    <i class="fa fa-cog"></i>
                    <span>Settings</span>
                </a>
                <ul class="sub">
                    <li><a href="<?= ROOT ?>admin/settings/slider_images">Slider Images</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="<?= ROOT ?>admin/users">
                    <i class="fa fa-user"></i>
                    <span>Users</span>
                </a>
                <ul class="sub">
                    <li><a href="<?= ROOT ?>admin/users/customers">Customers</a></li>
                    <li><a href="<?= ROOT ?>admin/users/admins">Admins</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="<?= ROOT ?>admin/backup">
                    <i class="fa fa-hdd-o"></i>
                    <span>Backup</span>
                </a>
            </li>
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
<!-- **********************************************************************************************************************************************************
    MAIN CONTENT
      *********************************************************************************************************************************************************** -->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">