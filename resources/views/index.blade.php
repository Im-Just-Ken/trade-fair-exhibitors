<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trade Fair Exhibitors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>

        .table-responsive {
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Trade Fair Exhibitors</h2>

        <!-- Search & Filter -->
        <div class="row g-2 mb-3">
            <div class="col-12 col-md-4">
                <input type="text" id="search" class="form-control" placeholder="Search by name...">
            </div>
            <div class="col-12 col-md-3">
                <select id="filterCountry" class="form-select">
                    <option value="">Filter by country</option>
                </select>
            </div>
            <div class="col-12 col-md-3">
                <select id="filterCategory" class="form-select">
                    <option value="">Filter by category</option>
                </select>
            </div>
            <div class="col-12 col-md-2">
                <button class="btn btn-primary w-100" onclick="fetchExhibitors()">Reset</button>
            </div>
        </div>

        <!-- Exhibitor Table -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Country</th>
                        <th>Category</th>
                        <th>Website</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="exhibitors-list"></tbody>
            </table>
        </div>

        <!-- Add Exhibitor Button -->
        <div class="d-grid d-md-flex justify-content-md-start">
            <button class="btn btn-success mt-3" onclick="openAddModal()">Add Exhibitor</button>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this exhibitor?</p>
                    <ul>
                        <li><strong>Name:</strong> <span id="deleteExhibitorName"></span></li>
                        <li><strong>Country:</strong> <span id="deleteExhibitorCountry"></span></li>
                        <li><strong>Category:</strong> <span id="deleteExhibitorCategory"></span></li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Exhibitor Modal -->
    <div class="modal fade" id="exhibitorModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Exhibitor Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="exhibitorId">
                    <div class="mb-2">
                        <label class="form-label">Name</label>
                        <input type="text" id="exhibitorName" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Country</label>
                        <input type="text" id="exhibitorCountry" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Category</label>
                        <input type="text" id="exhibitorCategory" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Website</label>
                        <input type="text" id="exhibitorWebsite" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="saveExhibitor()">Save</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script defer src="{{ asset('js/index.js') }}"></script>
</body>
</html>
