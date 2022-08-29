/*========================================================== Categories ===============================================================*/

// Add Category
function addCategory() {
    let addCategory = document.querySelector(".add-category-form");

    //getting sub_categories

    let sub_categories = $("#sub_category");
    $.ajax({
        type: "POST",
        url: sub_categories.attr("link"),
        success: function (res) {
            sub_categories.html(res);
        },
    });

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
                url: addCategory.getAttribute("action"),
                data: formdata,
                dataType: "json",
                success: function (res) {
                    if ("success" in res) {
                        $(".table-body").html(res["category"]);
                    }
                },
                error: function (XHRStatus, b, c) {
                    console.log(XHRStatus);
                },
            });
        });
    }
}

// Delete Category
function deleteCategory(ev) {
    ev.preventDefault();
    let element = ev.currentTarget;
    if (confirm("Deletion Confirm ? ")) {
        let formdata = new FormData();
        formdata.append("id", element.getAttribute("id"));
        formdata = JSON.stringify(Object.fromEntries(formdata.entries()));
        $.ajax({
            type: "POST",
            url: element.getAttribute("href"),
            data: formdata,
            dataType: "json",
            success: function (res) {
                if ("success" in res) $(".table-body").html(res["data"]);
            },
        });
    }
}

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
        info.classList.remove("hide");

        let element = linkEvent.currentTarget;
        let id = element.getAttribute("id");
        let form = document.querySelector(".form-inline");
        // Getting info to fill 
        let sub_categories = $("#edit_sub_category")
        $.ajax({
            type: "POST",
            url: "/E_Commerce/public/ajax/categories/get_content",
            data: `{"id":${id}}`,
            success: function (res) {
                res = JSON.parse(res);
                if ('name' in res) $("#categoryName").val(res['name']);
                if ("sub_category" in res) sub_categories.html(res['sub_category'])
            },
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
                dataType: "json",
                success: function (res) {
                    res = JSON.parse(res);
                    if ("success" in res) {
                        // Change the value of input filed to the current element name
                        $("#categoryName").html(res["data"]);

                        // update the table content after update

                        $(".table-body").html(res["data"]);
                    }
                },
                error: function (a, b, c) {
                    console.log(a, b, c);
                },
            });
        });
    } else info.classList.add("hide");
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
            $(".table-body").html(res["data"]);
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        },
    });
}

/*================================================================== Products ========================================================================*/

// add Product
function addProduct() {
    let addProduct = document.querySelector(".add-product-form");
    // get categories
    $.ajax({
        type: "POST",
        url: "/E_Commerce/public/ajax/categories/get_contents_for_products",
        success: function (res) {
            res = JSON.parse(res);
            $("#category_name").html(res);
        },
    });
    addProduct.addEventListener("submit", (e) => {
        e.preventDefault();
        let btn = $("#add-product-send");
        btn.disabled = true;
        btn.textContent = "Please Wait...";
        let formdata = new FormData(addProduct);
        let photos = document.querySelectorAll("[type='file']");
        if (photos.length > 1) {
            photos = photos[1].files;
            let cnt = 1;
            Object.keys(photos).forEach((e) => {
                if (cnt < 4) formdata.append(`photo_${cnt}`, photos[e]);
                cnt++;
            });
        }
        $.ajax({
            type: "POST",
            url: "/E_Commerce/public/ajax/products/add",
            data: formdata,
            //! These Lines Added to be able to send files using query Ajax or we can use XMLHttpRequest object instead

            processData: false,
            contentType: false,
            cache: false,
            success: function (res) {
                console.log(res)
                res = JSON.parse(res);
                if ("success" in res) {
                    $(".table-body").html(res["product"]);
                }
            }, error: function (XHRStatus) { console.log(XHRStatus) }
        });
        // * we use XMLHttpRequest Object instead
    });
}

// Delete Category
function deleteProduct(ev) {
    ev.preventDefault();
    let element = ev.currentTarget;
    if (confirm("Deletion Confirm ? ")) {
        let formdata = new FormData();
        formdata.append("id", element.getAttribute("data-id"));
        formdata = JSON.stringify(Object.fromEntries(formdata.entries()));
        $.ajax({
            type: "POST",
            url: element.getAttribute("href"),
            data: formdata,
            dataType: "json",
            success: function (res) {
                console.log(res)
                if ("success" in res) $(".table-body").html(res["data"]);
            },
            error: function (XHRStatus) { console.log(XHRStatus.responseText) }
        });
    }

}
function editProductInfo(event) {
    event.preventDefault();
    let info = document.querySelector(".edit_product");
    if (info.classList.contains("hide")) {
        info.classList.remove("hide");
        let editProductForm = document.querySelector(".edit-product-form");
        let id = event.currentTarget.getAttribute("data-id");
        let formdata = new FormData();
        formdata.append("id", event.currentTarget.getAttribute("data-id"));
        //get contents from db
        let resutls = []
        $.ajax({
            type: "POST",
            url: "/E_Commerce/public/ajax/products/edit_info/get_contents",
            data: JSON.stringify(Object.fromEntries(formdata.entries())),
            success: function (res) {
                res = JSON.parse(res);
                [...$(".edit-product-form :input")].forEach((e) => {
                    if (e.attributes['name']) {
                        let val = e.attributes['name'].value;
                        if (val == 'category_id') e.innerHTML = res[val];
                        else if (val == 'description') e.textContent = res['description'];
                        else e.setAttribute("value", res[val])
                    }
                })

            },
            error: function (XHRStatus) {
                console.log(XHRStatus)
            }
        });


        editProductForm.addEventListener("submit", (e) => {
            e.preventDefault();
            let formdata = new FormData(editProductForm);
            formdata.append("id", id);
            formdata = JSON.stringify(Object.fromEntries(formdata.entries()))
            $.ajax({
                type: "POST",
                url: editProductForm.getAttribute("action"),
                data: formdata,
                success: function (res) {
                    res = JSON.parse(res)
                    if ("success" in res) {
                        $(".table-body").html(res['product']);
                    }
                }
            });
        })

    }
    else info.classList.add("hide");
}