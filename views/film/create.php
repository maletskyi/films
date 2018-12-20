<?php include dirname(__DIR__).'/parts/header.php'; ?>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center my-4">New film</h1>

                <form action="/films/save" method="post">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control <?= !isset($validation['title']['errorMessages']) ?: 'is-invalid' ?>"
                               id="title" name="title" placeholder="Enter title" value="<?= $validation['title']['old'] ?? '' ?>">
                        <div class="invalid-feedback"><?= $validation['title']['errorMessages'][0] ?? '' ?></div>
                    </div>

                    <div class="form-group">
                        <label for="release_year">Release year</label>
                        <input type="number" min="1900" max="<?= date('Y'); ?>"
                               class="form-control <?= !isset($validation['release_year']['errorMessages']) ?: 'is-invalid' ?>" id="release_year"
                               name="release_year" placeholder="Enter year" value="<?= $validation['release_year']['old'] ?? '' ?>">
                        <div class="invalid-feedback"><?= $validation['release_year']['errorMessages'][0] ?? '' ?></div>
                    </div>

                    <div class="form-group">
                        <label for="storage_format_id">Storage format</label>
                        <select class="form-control <?= !isset($validation['storage_format_id']['errorMessages']) ?: 'is-invalid' ?>" id="storage_format_id" name="storage_format_id">
                            <?php foreach ($formats as $format): ?>
                                <option <?= isset($validation['storage_format_id']['old']) && $validation['storage_format_id']['old'] == $format->id ? 'selected ' : '' ?>value="<?= $format->id ?>">
                                    <?= $format->name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback"><?= $validation['storage_format_id']['errorMessages'][0] ?? '' ?></div>
                    </div>

                    <div class="form-group">
                        <label for="actors">Actor</label>
                        <input type="text" class="form-control <?= !isset($validation['actors']['errorMessages']) ?: 'is-invalid' ?>" value="<?= $validation['actors']['old'] ?? '' ?>" id="actors" name="actors" placeholder="Enter actors">
                        <small id="passwordHelpBlock" class="form-text text-muted">
                            Example: Tom Cruise, Johny Depp, Jessica Alba
                        </small>
                        <div class="invalid-feedback"><?= $validation['actors']['errorMessages'][0] ?? '' ?></div>
                    </div>

                    <button type="submit" class="btn btn-small btn-success">Create</button>

                </form>

            </div>
        </div>
    </div>

<?php include dirname(__DIR__).'/parts/footer.php';