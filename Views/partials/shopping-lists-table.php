<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th scope="col">List #</th>
            <th scope="col">Description</th>
            <th scope="col">Date/Time</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php if (isset($shoppingLists)): ?>
            <?php foreach ($shoppingLists as $list): ?>
                <tr>
                    <td><?= $list['id'] ?></td>
                    <td><?= $list['description'] ?></td>
                    <td class="">
                        <?= \Carbon\Carbon::parse($list['created_at']) ?>
                    </td>
                    <td class="">
                                <span class="badge">
                                </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-primary" href="/shopping-lists/<?= $list['id'] ?>">Edit/Show</a>
                            <form action="/shopping-lists/delete/<?= $list['id'] ?>" method="post">
                                <input class="rounded-0 btn btn-danger"
                                       type="submit" value="Delete">
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php endif ?>
        </tbody>
    </table>
</div>