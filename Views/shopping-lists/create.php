<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Create shopping list</h1>
    <a href="/shopping lists" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-user fa-sm text-white-50"></i> Back to shopping list lists</a>
</div>

<!-- Content Row -->

<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">

            <!-- Card Body -->
            <div class="card-body">

                <?php include VIEW_PATH . '/errors/' . 'messages' . '.php'; ?>

                <form action="/shopping lists/store" method="post">
                    <div class="container">
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover" id="list_table">
                                    <thead>
                                    <tr>
                                        <th class="text-center"> #</th>
                                        <th class="text-center"> Product</th>
                                        <th class="text-center"> Qty</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr id='addr0'>
                                        <td>1</td>
                                        <td><input type="text" name='product[]' placeholder='Enter Product Name'
                                                   class="form-control" required/></td>
                                        <td><input type="number" name='line_quantity[]' placeholder='Enter Qty'
                                                   class="form-control quantity" step="0" min="0" required/></td>
                                        <td><input type="text" name='line_price[]' placeholder='Enter Unit Price'
                                                   class="form-control price" step="0.00" min="0"  required/></td>
                                    </tr>
                                    <tr id='addr1'></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <button id="add_row" class="btn btn-outline-success float-left">Add Row</button>
                                <button id='delete_row' class="float-right btn btn-outline-danger">Delete Row</button>
                            </div>
                        </div>
                        <div class="row clearfix mt-2">
                            <div class="col-md-12">
                                <label for="description">Notes</label>
                                <textarea class="form-control" name="description" id="description" required></textarea>
                            </div>
                        </div>
                        <div class="row clearfix mt-5">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary float-right">Create shopping list</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
