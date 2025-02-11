function fetchExhibitors() {
    $("#search").val("");
    $.get("/api/exhibitors", function (data) {
        let rows = "";
        let countries = new Set(),
            categories = new Set();

        if (data.length === 0) {
            rows = `<tr><td colspan="5" class="text-center">No exhibitors found.</td></tr>`;
        } else {
            data.forEach((e) => {
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
        }

        $("#exhibitors-list").html(rows);
        $("#filterCountry").html(
            `<option value="">Filter by country</option>` +
                [...countries]
                    .map((c) => `<option value="${c}">${c}</option>`)
                    .join("")
        );
        $("#filterCategory").html(
            `<option value="">Filter by category</option>` +
                [...categories]
                    .map((c) => `<option value="${c}">${c}</option>`)
                    .join("")
        );
    });
}
function openAddModal() {
    $("#exhibitorId").val("");
    $(
        "#exhibitorName, #exhibitorCountry, #exhibitorCategory, #exhibitorWebsite"
    ).val("");
    $("#exhibitorModal").modal("show");
}

function editExhibitor(id) {
    $.get(`/api/exhibitors/${id}`, function (data) {
        $("#exhibitorId").val(data.id);
        $("#exhibitorName").val(data.name);
        $("#exhibitorCountry").val(data.country);
        $("#exhibitorCategory").val(data.category);
        $("#exhibitorWebsite").val(data.website);
        $("#exhibitorModal").modal("show");
    }).fail(function (xhr) {
        alert("Failed to fetch exhibitor details.");
        console.error(xhr.responseText);
    });
}

function saveExhibitor() {
    let id = $("#exhibitorId").val();
    let exhibitor = {
        name: $("#exhibitorName").val(),
        country: $("#exhibitorCountry").val(),
        category: $("#exhibitorCategory").val(),
        website: $("#exhibitorWebsite").val(),
    };

    if (!exhibitor.name || !exhibitor.country || !exhibitor.category) {
        alert("Please fill in all required fields.");
        return;
    }

    let url = id ? `/api/exhibitors/${id}` : "/api/exhibitors"; //  PATCH for edit, POST for add
    let method = id ? "PATCH" : "POST";

    $.ajax({
        url: url,
        type: method,
        data: exhibitor,
        success: function (response) {
            console.log(`${method} successful:`, response);
            fetchExhibitors();
            $("#exhibitorModal").modal("hide");
        },
        error: function (xhr) {
            console.error(`${method} failed:`, xhr.responseText);
            alert(`Failed to ${id ? "update" : "add"} exhibitor.`);
        },
    });
}

let deleteExhibitorId = null;

function deleteExhibitor(id) {
    $.get(`/api/exhibitors/${id}`, function (data) {
        deleteExhibitorId = id; // Store the ID
        $("#deleteExhibitorName").text(data.name);
        $("#deleteExhibitorCountry").text(data.country);
        $("#deleteExhibitorCategory").text(data.category);
        $("#deleteModal").modal("show");
    }).fail(function (xhr) {
        alert("Failed to fetch exhibitor details.");
        console.error(xhr.responseText);
    });
}

$("#confirmDelete").click(function () {
    if (deleteExhibitorId) {
        $.ajax({
            url: `/api/exhibitors/${deleteExhibitorId}`,
            type: "DELETE",
            success: function () {
                $("#deleteModal").modal("hide");
                fetchExhibitors();
            },
            error: function (xhr) {
                console.error("Delete failed:", xhr.responseText);
                alert("Failed to delete exhibitor.");
            },
        });
    }
});

$("#search").on("keyup", function () {
    let search = $(this).val();
    $.get(`/api/exhibitors/search?name=${search}`, function (data) {
        let rows = "";
        if (data.length === 0) {
            rows = `<tr><td colspan="5" class="text-center">No exhibitors found.</td></tr>`;
        } else {
            data.forEach((e) => {
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
        }
        $("#exhibitors-list").html(rows);
    });
});

$("#filterCountry, #filterCategory").on("change", function () {
    let country = $("#filterCountry").val();
    let category = $("#filterCategory").val();

    let query = [];
    if (country) query.push(`country=${country}`);
    if (category) query.push(`category=${category}`);

    let url =
        "/api/exhibitors/search" + (query.length ? "?" + query.join("&") : "");

    $.get(url, function (data) {
        let rows = "";
        if (data.length === 0) {
            rows = `<tr><td colspan="5" class="text-center">No exhibitors found.</td></tr>`;
        } else {
            data.forEach((e) => {
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
        }
        $("#exhibitors-list").html(rows);
    });
});
$(document).ready(fetchExhibitors);
