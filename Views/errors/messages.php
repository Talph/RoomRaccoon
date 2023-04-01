<?php if (isset($_SESSION['error_messages'])): ?>
    <div class="<?php if (isset($_SESSION["error_messages"])) echo 'alert-danger py-2 mb-3 rounded text-danger'; ?>">
        <ul>
            <?php if(is_array($_SESSION['error_messages'])): ?>
            <?php foreach ($_SESSION['error_messages'] as $message): ?>
                <?php if(is_array($message)): ?>
                    <?php foreach ($message as $error): ?>
                        <li class="text-danger"><?= ($error) ?></li>
                    <?php endforeach ?>
                <?php else: ?>
                    <li class="text-danger"><?= $message ?></li>
                <?php endif; ?>
            <?php endforeach ?>
            <?php else: ?>
                <li class="text-danger"><?= $_SESSION['error_messages'] ?></li>
            <?php endif; ?>
        </ul>
    </div>
    <?php unset($_SESSION['error_messages']); ?>
<?php endif ?>

<?php if (isset($_SESSION['success_messages'])): ?>
    <div class="<?php if (isset($_SESSION["success_messages"]) && $_SESSION["success_messages"]) echo 'alert-success py-2 mb-3 rounded text-success'; ?>">
        <ul>
            <?php if(is_array($_SESSION['success_messages'])): ?>
            <?php foreach ($_SESSION['success_messages'] as $message): ?>
                <?php if(is_array($message)): ?>
                    <?php foreach ($message as $success): ?>
                        <li class="text-success"><?= $success ?></li>
                    <?php endforeach ?>
                <?php else: ?>
                    <li class="text-success"><?= $message ?></li>
                <?php endif; ?>
            <?php endforeach ?>
            <?php else: ?>
                <li class="text-success"><?= $_SESSION['success_messages'] ?></li>
            <?php endif; ?>
        </ul>
    </div>
    <?php unset($_SESSION['success_messages']); ?>
<?php endif ?>
