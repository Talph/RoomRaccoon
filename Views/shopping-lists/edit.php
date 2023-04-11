<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <?php if (isset($shoppingList)): ?>
        <h1 class="h3 mb-0 text-gray-800">Edit shopping list : <?= $shoppingList["title"] ?></h1>
    <?php endif ?>
    <a href="/shopping-lists" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-user fa-sm text-white-50"></i> Back to shopping lists</a>
</div>

<!-- Content Row -->

<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">

            <!-- Card Body -->
            <div class="card-body">

                <?php include VIEW_PATH . '/errors/' . 'messages' . '.php'; ?>

                <form action="/shopping-lists/update/<?=$shoppingList['id']?>" method="post">
                    <div class="container">
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover" id="invoice_table">
                                    <thead>
                                    <tr>
                                        <th class="text-center"> #</th>
                                        <th class="text-center"> Item Name</th>
                                        <th class="text-center"> Qty</th>
                                        <th class="text-center"> Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr id='addr0'>
                                        <?php if (isset($shoppingListItems)): ?>
                                        <?php foreach ($shoppingListItems as $line): ?>
                                        <td>1</td>
                                        <td><input type="text" name='item_name[]' placeholder='Enter Product Name'
                                                   class="form-control" value="<?= $line['name'] ?>" required/></td>
                                        <td><input type="number" name='item_quantity[]' value="<?= $line['quantity'] ?>"
                                                   placeholder='Enter Qty'
                                                   class="form-control quantity" step="0" min="0" required/></td>
                                        <td><input type="text" name='item_price[]' value="<?= $line['price'] ?>"
                                                   placeholder='Enter Item Price'
                                                   class="form-control price" step="0.00" min="0" required/></td>
                                    </tr>
                                    <tr id='addr1'></tr>
                                    <?php endforeach ?>
                                    <?php endif ?>
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
                        <?php if (isset($shoppingList)): ?>
                            <div class="row clearfix mt-2">
                                <div class="col-md-12">
                                    <label for="description">Notes</label>
                                    <textarea class="form-control" name="description" id="description"
                                              required><?= $shoppingList['description'] ?>
                                </textarea>
                                </div>
                            </div>
                            <div class="row clearfix mt-3">
                                <div class="float-right col-md-4">
                                    <table class="table table-bordered table-hover" id="invoice_table_total">
                                        <tbody>
                                        <tr>
                                            <th class="text-center">Total</th>
                                            <td class="text-center">
                                                <input type="number" name='total' placeholder='0.00'
                                                       class="form-control" id="total"
                                                       value="<?php if(isset($total)): echo $total; endif ?>" readonly/>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endif ?>
                        <div class="row clearfix">
                            <div class="col-md-12 mt-4">
                                    <button type="submit" class="btn btn-primary float-right">Update shopping list</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>