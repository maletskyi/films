<?php include 'parts/header.php'; ?>

    <div class="container">
        <div class="row">
            <div class="col-12">

                <h1 class="text-center my-4">Films</h1>

                <?php if (isset($messages)):
                    if (isset($messages['error'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $messages['error'] ?>
                        </div>
                    <?php endif;
                    if (isset($messages['success'])): ?>
                        <div class="alert alert-success" role="alert">
                            <?= $messages['success'] ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="my-4">
                    <a href="/films/create" class="btn btn-small btn-outline-success">New film</a>
                    <a href="/films/import" class="btn btn-small btn-outline-success">Import from file</a>
                </div>

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
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($films as $film) : ?>
                            <tr>
                                <td><?= $film->id ?></td>
                                <td><?= $film->title ?></td>
                                <td><?= $film->releaseYear ?></td>
                                <td><?= $film->storageFormat->name ?></td>
                                <td>
                                    <form action="/films/<?= $film->id ?>/delete" method="post">
                                        <a href="/films/<?= $film->id ?>" class="btn btn-small btn-info">View</a>
                                        <button type="submit" class="btn btn-small btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php include 'parts/footer.php';