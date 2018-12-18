<?php include dirname(__DIR__).'/parts/header.php'; ?>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center my-4">New film</h1>

                <form action="/films/save" method="post">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter title">
                    </div>

                    <div class="form-group">
                        <label for="release_year">Release year</label>
                        <input type="number" min="1900" max="<?= date('Y'); ?>" class="form-control" id="release_year"
                               name="release_year" placeholder="Enter year">
                    </div>

                    <div class="form-group">
                        <label for="storage_format_id">Storage format</label>
                        <select class="form-control" id="storage_format_id" name="storage_format_id">
                            <?php foreach ($formats as $format): ?>
                                <option value="<?= $format->id ?>"><?= $format->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="actors">Actor</label>
                        <input type="text" class="form-control" id="actors" name="actors" placeholder="Enter actors">
                        <small id="passwordHelpBlock" class="form-text text-muted">
                            Example: Tom Cruise, Johny Depp, Jessica Alba
                        </small>
                    </div>

                    <button type="submit" class="btn btn-small btn-success">Create</button>

                </form>

            </div>
        </div>
    </div>

<?php include dirname(__DIR__).'/parts/footer.php';