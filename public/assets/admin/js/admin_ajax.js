
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

/* Edit Category */

// Edit Name

function editCategoryName(linkEvent) {
    /**
     * Edit Category Name
     * @param event ev The event passed to control the HTML Element
     */
    linkEvent.preventDefault();
    let info = document.querySelector(".edit_category");

    if (info.classList.contains("hide")) {
        info.classList.remove('hide');

        let element = linkEvent.currentTarget;
        let id = element.getAttribute("id");
        console.log(id)
        let form = document.querySelector(".form-inline");
        // Getting Name filed info to show 
        $.ajax({
            type: "POST",
            url: "/E_Commerce/public/ajax/categories/get_content",
            data: `{"id":${id}}`,
            success: function (res) {
                res = JSON.parse(res);
                if (res) $("#categoryName").val(res);
            }
        });
        form.setAttribute("id", id);
        form.addEventListener("submit", (formEvent) => {
            formEvent.preventDefault();
            let formdata = new FormData(form);
            formdata.append("id", form.getAttribute("id"));
            formdata = JSON.stringify(Object.fromEntries(formdata.entries()));
            $.ajax({
                type: "POST",
                data: formdata,
                url: element.getAttribute("href"),
                dataType: 'json',
                success: function (res) {
                    res = JSON.parse(res);
                    if ("success" in res) {
                        // Change the value of input filed to the current element name
                        $("#categoryName").html(res['data']);

                        // update the table content after update

                        $(".table-body").html(res['data'])
                    }
                },
                error: function (a, b, c) {
                    console.log(a, b, c)
                }
            });
        })
    }
    else info.classList.add("hide")
}

// Edit Status
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

