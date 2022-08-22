
// Configure Categories

// Add Category
function addCategory() {
    let addCategory = document.querySelector(".add-category-form");
    if (addCategory) {
        addCategory.addEventListener("submit", (e) => {
            e.preventDefault();
            let btn = $("#add-categoty-send");
            btn.disabled = true;
            btn.textContent = "Please Wait...";
            let formdata = new FormData(addCategory);
            formdata = JSON.stringify(Object.fromEntries(formdata.entries()));
            $.ajax({
                type: "POST",
                url: "/E_Commerce/public/ajax/categories/add",
                data: formdata,
                dataType: "json",
                success: function (res) {
                    if ("success" in res) {
                        $(".table-body").html(res['category']);
                    }
                }
            });
        })

    }
}

/* Edit Category */

// Edit Name

// Edit Status

// Delete Category
function deleteCategory(ev) {
    ev.preventDefault();
    let element = ev.currentTarget;
    if (confirm("Deletion Confirm ? ")) {
        let formdata = new FormData();
        formdata.append("id", element.getAttribute("id"))
        formdata = JSON.stringify(Object.fromEntries(formdata.entries()));
        $.ajax({
            type: "POST",
            url: element.getAttribute("href"),
            data: formdata,
            dataType: "json",
            success: function (res) {
                if ("success" in res) $(".table-body").html(res['data'])
            }
        });
    }

}
// Show Categories
// * In showTables.js File 
//
function editCategoryStatus(ev) {
    ev.preventDefault();
    let element = ev.currentTarget;
    let id = element.getAttribute("data-id");
    let status = element.classList.contains("btn-danger") ? 0 : 1;
    let formdata = new FormData();
    formdata.append("id", id);
    formdata.append("status", status);
    formdata = JSON.stringify(Object.fromEntries(formdata.entries()));
    $.ajax({
        type: "POST",
        url: element.getAttribute("href"),
        data: formdata,
        success: function (res) {
            res = JSON.parse(res);
            $(".table-body").html(res['data'])
        },
        error: function (a, b, c) {
            console.log(a, b, c)
        }
    });
}

