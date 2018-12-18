<?php include dirname(__DIR__).'/parts/header.php'; ?>

    <div class="container">
        <div class="row">
            <div class="col-12">

                <h1 class="text-center my-4">Search result</h1>

                <?php if (empty($films)): ?>
                    <h2 class="text-center my-5">Nothing to show</h2>
                <?php else: ?>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Title</th>
                            <th scope="col">Release year</th>
                            <th scope="col">Format</th>
                            <th scope="col">Actors</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($films as $film) : ?>
                            <tr>
                                <td><?= $film->id ?></td>
                                <td><?= $film->title ?></td>
                                <td><?= $film->releaseYear ?></td>
                                <td><?= $film->storageFormat->name ?></td>
                                <td><?= implode(', ', $film->actors) ?></td>
                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php include dirname(__DIR__).'/parts/footer.php';