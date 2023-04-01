<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Shopping Lists</h1>
    <a href="/shopping-lists/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-user fa-sm text-white-50"></i> Create Shopping Lists</a>
</div>

<!-- Content Row -->

<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">

            <!-- Card Body -->
            <div class="card-body">
                <?php include VIEW_PATH . '/errors/' . 'messages' . '.php'; ?>

                <?php include VIEW_PATH . '/partials/shopping-lists-table.php'; ?>

            </div>
        </div>
    </div>
</div>