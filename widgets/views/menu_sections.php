<?php if ($type == 'htmlSelect') { ?>
<div class="dropdown">
    <button class="dropdown-button">Меню</button>
    <div class="dropdown-content">
        <?php foreach ($menuItems as $key => $url): ?>
            <a href="<?= $url ?>"><?= $key ?></a>
        <?php endforeach; ?>
    </div>
</div>
<?php } else { ?>

    <ul>
        <li>
            <?php foreach ($menuItems as $item): ?>
                <p><a href="<?= $item['url'] ?>" onclick="go(this)"><?= $item['label'] ?></a></p>
            <?php endforeach; ?>
        </li>
    </ul>

<?php } ?>