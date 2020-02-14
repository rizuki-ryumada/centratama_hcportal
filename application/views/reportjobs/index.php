<div class="container-fluid">
    <h1 class="h3 mb-auto text-gray-800"><?= $title; ?></h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row mt-3">
                <div class="col-6">
                    <div class="form-group">
                        <label for="divisi">Divisi :</label>
                        <select class="form-control form-control-sm" id="divisi">
                        <option value="">All</option>
                            <?php foreach($divisi as $div): ?>
                                <option value="<?= $div['division']; ?>"><?= $div['division']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="departemen">Department :</label>
                        <select class="form-control form-control-sm" id="departemen">
                            <option value="">All</option>
                            <?php foreach($dept as $dept): ?>
                                <option value="<?= $dept['nama_departemen']; ?>"><?= $dept['nama_departemen']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-boredered" id="myTable" width="100%">
                    <thead>
                        <tr>
                            <th>Division</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th>Employee Name</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Division</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th>Employee Name</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>