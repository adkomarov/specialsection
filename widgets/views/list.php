<ul>
    <li>
        <?php foreach ($menuItems as $item): ?>
            <p><a href="<?= $item['url'] ?>" onclick="go(this)">
                    <?= $item['label'] ?>
                </a></p>
        <?php endforeach; ?>
    </li>
</ul>