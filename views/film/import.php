<?php include dirname(__DIR__).'/parts/header.php'; ?>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center my-4">Import films</h1>

                <form action="/films/load" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="films-file">Choose text file</label>
                        <input type="file" class="form-control-file" id="films-file" name="films-file" accept=".txt">
                    </div>

                    <button type="submit" class="btn btn-small btn-success mt-4">Import</button>
                </form>

            </div>
        </div>
    </div>

<?php include dirname(__DIR__).'/parts/footer.php';