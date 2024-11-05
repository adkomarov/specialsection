<div class="dropdown">
    <button class="dropdown-button">Меню</button>
    <div class="dropdown-content">
        <?php foreach ($menuItems as $item): ?>
            <a href="<?= $item['url'] ?>"><?= $item['label'] ?></a>
        <?php endforeach; ?>
    </div>
</div>