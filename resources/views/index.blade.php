<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trade Fair Exhibitors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Trade Fair Exhibitors</h2>

        <!-- Search & Filter -->
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" id="search" class="form-control" placeholder="Search by name...">
            </div>
            <div class="col-md-3">
                <select id="filterCountry" class="form-control">
                    <option value="">Filter by country</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="filterCategory" class="form-control">
                    <option value="">Filter by category</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100" onclick="fetchExhibitors()">Reset</button>
            </div>
        </div>

        <!-- Exhibitor Table -->
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

        <!-- Add Exhibitor Button -->
        <button class="btn btn-success" onclick="openAddModal()">Add Exhibitor</button>
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
                        <label>Name</label>
                        <input type="text" id="exhibitorName" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Country</label>
                        <input type="text" id="exhibitorCountry" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Category</label>
                        <input type="text" id="exhibitorCategory" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Website</label>
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

    <script>





    function fetchExhibitors() {
        $('#search').val('');
    $.get('/api/exhibitors', function(data) {
        let rows = '';
        let countries = new Set(), categories = new Set();
        data.forEach(e => {
            rows += `<tr>
                <td>${e.name}</td>
                <td>${e.country}</td>
                <td>${e.category}</td>
                <td><a href="${e.website}" target="_blank">Visit</a></td>
                <td>
                    <button class="btn btn-sm btn-warning" onclick="editExhibitor(${e.id})">Edit</button>
                    <button class="btn btn-sm btn-danger" onclick="deleteExhibitor(${e.id})">Delete</button>
                </td>
            </tr>`;
            countries.add(e.country);
            categories.add(e.category);
        });
        $('#exhibitors-list').html(rows);
        $('#filterCountry').html(`<option value="">Filter by country</option>` + [...countries].map(c => `<option value="${c}">${c}</option>`).join(''));
        $('#filterCategory').html(`<option value="">Filter by category</option>` + [...categories].map(c => `<option value="${c}">${c}</option>`).join(''));
    });
}


        function openAddModal() {
            $('#exhibitorId').val('');
            $('#exhibitorName, #exhibitorCountry, #exhibitorCategory, #exhibitorWebsite').val('');
            $('#exhibitorModal').modal('show');
        }

        function editExhibitor(id) {
    $.get(`/api/exhibitors/${id}`, function (data) {
        $('#exhibitorId').val(data.id);
        $('#exhibitorName').val(data.name);
        $('#exhibitorCountry').val(data.country);
        $('#exhibitorCategory').val(data.category);
        $('#exhibitorWebsite').val(data.website);
        $('#exhibitorModal').modal('show');
    }).fail(function (xhr) {
        alert("Failed to fetch exhibitor details.");
        console.error(xhr.responseText);
    });
}

    function saveExhibitor() {
    let id = $('#exhibitorId').val();
    let exhibitor = {
        name: $('#exhibitorName').val(),
        country: $('#exhibitorCountry').val(),
        category: $('#exhibitorCategory').val(),
        website: $('#exhibitorWebsite').val()
    };

    if (!exhibitor.name || !exhibitor.country || !exhibitor.category) {
        alert("Please fill in all required fields.");
        return;
    }

    $.ajax({
        url: `/api/exhibitors/${id}`,
        type: 'PATCH',
        data: exhibitor, // Don't use JSON.stringify()
        success: function(response) {
            console.log("Update successful:", response);
            fetchExhibitors();
            $('#exhibitorModal').modal('hide');
        },
        error: function(xhr) {
            console.error("Update failed:", xhr.responseText);
            alert("Failed to update exhibitor.");
        }
    });
}


let deleteExhibitorId = null;

function deleteExhibitor(id) {
    $.get(`/api/exhibitors/${id}`, function(data) {
        deleteExhibitorId = id; // Store the ID for deletion
        $('#deleteExhibitorName').text(data.name);
        $('#deleteExhibitorCountry').text(data.country);
        $('#deleteExhibitorCategory').text(data.category);
        $('#deleteModal').modal('show'); // Show the modal
    }).fail(function(xhr) {
        alert("Failed to fetch exhibitor details.");
        console.error(xhr.responseText);
    });
}

$('#confirmDelete').click(function() {
    if (deleteExhibitorId) {
        $.ajax({
            url: `/api/exhibitors/${deleteExhibitorId}`,
            type: 'DELETE',
            success: function() {
                $('#deleteModal').modal('hide'); // Close modal
                fetchExhibitors(); // Refresh the list
            },
            error: function(xhr) {
                console.error("Delete failed:", xhr.responseText);
                alert("Failed to delete exhibitor.");
            }
        });
    }
});


        $('#search').on('keyup', function() {
            let search = $(this).val();
            $.get(`/api/exhibitors/search?name=${search}`, function(data) {
                let rows = '';
                data.forEach(e => {
                    rows += `<tr>
                        <td>${e.name}</td>
                        <td>${e.country}</td>
                        <td>${e.category}</td>
                        <td><a href="${e.website}" target="_blank">Visit</a></td>
                        <td>
                            <button class="btn btn-sm btn-warning" onclick="editExhibitor(${e.id})">Edit</button>
                            <button class="btn btn-sm btn-danger" onclick="deleteExhibitor(${e.id})">Delete</button>
                        </td>
                    </tr>`;
                });
                $('#exhibitors-list').html(rows);
            });
        });


        $('#filterCountry, #filterCategory').on('change', function () {
    let country = $('#filterCountry').val();
    let category = $('#filterCategory').val();

    let query = [];
    if (country) query.push(`country=${country}`);
    if (category) query.push(`category=${category}`);

    let url = '/api/exhibitors/search' + (query.length ? '?' + query.join('&') : '');

    $.get(url, function (data) {
        let rows = '';
        data.forEach(e => {
            rows += `<tr>
                <td>${e.name}</td>
                <td>${e.country}</td>
                <td>${e.category}</td>
                <td><a href="${e.website}" target="_blank">Visit</a></td>
                <td>
                    <button class="btn btn-sm btn-warning" onclick="editExhibitor(${e.id})">Edit</button>
                    <button class="btn btn-sm btn-danger" onclick="deleteExhibitor(${e.id})">Delete</button>
                </td>
            </tr>`;
        });
        $('#exhibitors-list').html(rows);
    });
});


        $(document).ready(fetchExhibitors);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
