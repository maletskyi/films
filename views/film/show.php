<?php include dirname(__DIR__) . '/parts/header.php'; ?>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center my-4"><?= htmlspecialchars($film->title) ?></h1>

                <p>ID: <?= $film->id ?></p>
                <p>Title: <?= htmlspecialchars($film->title) ?></p>
                <p>Release year: <?= $film->releaseYear ?></p>
                <p>Format: <?= htmlspecialchars($film->storageFormat->name) ?></p>
                <p>Actors: <?= htmlspecialchars(implode(', ', $film->actors)) ?></p>

            </div>
        </div>
    </div>

<?php include dirname(__DIR__) . '/parts/footer.php';