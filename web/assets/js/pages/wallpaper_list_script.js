$('#wallpaper-table').DataTable({
    "language": {
        "emptyTable": "هیچ داده‌ای در جدول وجود ندارد",
        "info": "نمایش _START_ تا _END_ از _TOTAL_ ردیف",
        "infoEmpty": "نمایش 0 تا 0 از 0 ردیف",
        "infoFiltered": "(فیلتر شده از _MAX_ ردیف)",
        "infoThousands": ",",
        "lengthMenu": "نمایش _MENU_ ردیف",
        "loadingRecords": "در حال بارگزاری...",
        "processing": "در حال پردازش...",
        "search": "جستجو:",
        "zeroRecords": "رکوردی با این مشخصات پیدا نشد",
        "paginate": {
            "first": "برگه‌ی نخست",
            "last": "برگه‌ی آخر",
            "next": "بعدی",
            "previous": "قبلی"
        },
        "aria": {
            "sortAscending": ": فعال سازی نمایش به صورت صعودی",
            "sortDescending": ": فعال سازی نمایش به صورت نزولی"
        },
        "autoFill": {
            "cancel": "انصراف",
            "fill": "پر کردن همه سلول ها با ساختار سیستم",
            "fillHorizontal": "پر کردن سلول های افقی",
            "fillVertical": "پرکردن سلول های عمودی",
            "info": "نمونه اطلاعات پرکردن خودکار"
        },
        "buttons": {
            "collection": "مجموعه",
            "colvis": "قابلیت نمایش ستون",
            "colvisRestore": "بازنشانی قابلیت نمایش",
            "copy": "کپی",
            "copySuccess": {
                "1": "یک ردیف داخل حافظه کپی شد",
                "_": "%ds ردیف داخل حافظه کپی شد"
            },
            "copyTitle": "کپی در حافظه",
            "csv": "CSV",
            "excel": "اکسل",
            "pageLength": {
                "-1": "نمایش همه ردیف‌ها",
                "1": "نمایش 1 ردیف",
                "_": "نمایش %d ردیف"
            },
            "pdf": "PDF",
            "print": "چاپ"
        },
        "searchBuilder": {
            "add": "افزودن شرط",
            "button": {
                "0": "جستجو ساز",
                "_": "جستجوساز (%d)"
            },
            "clearAll": "خالی کردن همه",
            "condition": "شرط",
            "conditions": {
                "date": {
                    "after": "بعد از",
                    "before": "بعد از",
                    "between": "میان",
                    "empty": "خالی",
                    "equals": "برابر",
                    "not": "نباشد",
                    "notBetween": "میان نباشد",
                    "notEmpty": "خالی نباشد"
                },
                "moment": {
                    "after": "بعد از",
                    "before": "قبل از",
                    "between": "میان",
                    "empty": "خالی"
                }
            },
            "data": "اطلاعات",
            "deleteTitle": "حذف عنوان",
            "logicAnd": "و",
            "logicOr": "یا",
            "title": {
                "0": "جستجو ساز",
                "_": "جستجوساز (%d)"
            },
            "value": "مقدار"
        },
        "select": {
            "1": "%d ردیف انتخاب شد",
            "_": "%d ردیف انتخاب شد",
            "cells": {
                "1": "1 سلول انتخاب شد",
                "_": "%d سلول انتخاب شد"
            },
            "columns": {
                "1": "یک ستون انتخاب شد",
                "_": "%d ستون انتخاب شد"
            },
            "rows": {
                "0": "%d ردیف انتخاب شد",
                "1": "1ردیف انتخاب شد",
                "_": "%d  انتخاب شد"
            }
        },
        "thousands": ","
    },
    lengthChange: false
});
$(document).ready(function() {
    $('#add-category-2').select2();
});
function showImage(src) {
    const model_body = document.getElementById("model-body");
    model_body.innerHTML = "";
    const img = document.createElement("img");
    img.setAttribute("src", src);
    img.setAttribute("class", "img-fluid");
    model_body.appendChild(img);

    $("#showImage").modal();
}

function showEditModal(id) {
    $("#showEdit").modal();
    const url = "http://localhost/api/ajax/getWallpapers/" + id;

    $.ajax({
        url: url,
        type: "get",
        contentType: false,
        processData: false,
        success: function (response) {
            $("#edit-id").val(response['items'][0]['id']);
            $("#edit-title").val(response['items'][0]['title']);
            $("#edit-dis").val(response['items'][0]['dis']);
            document.getElementById("category-selected").innerHTML = response['items'][0]['category'];
            const length = document.getElementById("edit-category").getElementsByTagName("option").length;
            var i;
            for (i = 0; i < length; i++) {
                const option = document.getElementById("edit-category").getElementsByTagName("option").item(i);
                if (option.value == response['items'][0]['category'] && option.getAttribute("selected") != "selected") {
                    option.remove();
                    break;
                }
            }
            const tag = response['items'][0]['tags'];
            const arr_tag = tag.split(",");
            $("#tag-string").val(arr_tag.toString());
            var i;
            const tags = document.getElementById("edit-tags");
            // const buttom = document.createElement("button");
            // const span = document.createElement("span");
            // span.setAttribute("class","badge bg-secondary");
            // span.innerHTML = "&times;";
            // buttom.setAttribute("class","btn btn-primary");
            // buttom.setAttribute("type","button");

            tags.innerHTML = "";
            for (i = 0; i < arr_tag.length; i++) {
                const string = "'" + arr_tag[i] + "',";
                const string2 = "'" + i + "',";
                const string3 = "'" + id + "'";
                tags.innerHTML = tags.innerHTML +
                    '<button class="btn btn-primary delete-tag" type="button" style="margin-left: 10px;">\n' +
                    arr_tag[i] +
                    '<span class="badge bg-secondary" onclick="removeTag(' + string + string2 + string3 + ')" style="margin-right: 5px;">&times;</span>\n' +
                    '</button>';
            }
        }
    });

    document.getElementById("add-tag-btn").addEventListener("click", addTag);
}

function removeTag(name, index, id) {
    document.getElementsByClassName("delete-tag").item(index).style.display = "none";
    const input = $("#tag-string").val();
    const tags = input.split(",");
    var i;
    for (i = 0; i < tags.length; i++) {
        if (tags[i] == name) {
            tags[i] = "";
            break;
        }
    }
    $("#tag-string").val(tags.toString());
}

function addTag() {
    const input = $("#add-tag-input");
    const id = $("#edit-id").val();
    if (input.val() != null && input.val() != "") {
        let url = "http://localhost/api/ajax/addTag";
        const formData = new FormData();
        formData.append("id", id);
        formData.append("name", input.val());

        $.ajax({
            url: url,
            type: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
            }
        });

        const tags = document.getElementById("edit-tags");
        const string = "'" + input.val() + "',";
        const string2 = "'" + document.getElementsByClassName("delete-tag").length + 1 + "',";
        const string3 = "'" + id + "'";
        tags.innerHTML = tags.innerHTML +
            '<button class="btn btn-primary delete-tag" type="button" style="margin-left: 10px;">\n' +
            input.val() +
            '<span class="badge bg-secondary" onclick="removeTag(' + string + string2 + string3 + ')" style="margin-right: 5px;">&times;</span>\n' +
            '</button>';
        const input2 = $("#tag-string");
        const tags_arr = input2.val().split(",");
        tags_arr.push(input.val());
        input2.val(tags_arr.toString());
    }
}

function submitEdit() {
    const formData = new FormData();
    formData.append("id", $("#edit-id").val());
    formData.append("title", $("#edit-title").val());
    formData.append("description", $("#edit-dis").val());
    formData.append("category", $("#edit-category").val());
    const array = $("#tag-string").val().split(",");
    var i;
    for (i = 0; i < array.length; i++) {
        if (array[i] == null || array[i] == "") {
            array.splice(i);
        }
    }
    formData.append("tags", array.toString());

    console.log(formData.get("tags"));

    const url = "http://localhost/api/ajax/editWallpaper";


    $.ajax({
        url: url,
        type: "post",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response);
            location.reload();
        }
    });
}

function showDeleteModal(id) {
    $("#deleteItem").modal();
    document.getElementById("confirmDelete").addEventListener("click", function (e) {
        console.log("confirm");
        const url = "http://localhost/api/ajax/deleteWallpaper";
        const formData = new FormData();
        formData.append("id", id);
        $.ajax({
            url: url,
            type: "post",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log(response);
                location.reload();
            }
        });
    })
}

function addTagForNew() {
    const input = $("#add-tag-input-2");
    if (input != null && input.val() != "") {
        const tags = document.getElementById("add-tags");
        const tag_array = $("#tag-string-2").val().split(",");
        tag_array.push(input.val());
        $("#tag-string-2").val(tag_array.toString());
        const string = "'" + input.val() + "',";
        var string2 = "";
        if (document.getElementsByClassName("delete-tag-2").length > 0) {
            string2 = "'" + document.getElementsByClassName("delete-tag-2").length++ + "',";
        } else {
            string2 = "'" + document.getElementsByClassName("delete-tag-2").length + "',";
        }
        tags.innerHTML = tags.innerHTML +
            '<button class="btn btn-primary delete-tag-2" type="button" style="margin-left: 10px;">\n' +
            input.val() +
            '<span class="badge bg-secondary" onclick="removeTagForNew(' + string + string2 + ')" style="margin-right: 5px;">&times;</span>\n' +
            '</button>';

        input.val("");
    }

}

function removeTagForNew(name, index) {
    const tag_array = $("#tag-string-2").val().split(",");
    var i;
    for (i = 0; i < tag_array.length; i++) {
        if (tag_array[i] == "") {
            tag_array.splice(i, 1);
        }
        if (tag_array[i] == name) {
            tag_array.splice(i, 1);
            const tag = document.getElementsByClassName("delete-tag-2").item(i);
            tag.remove();
        }
    }
    console.log(tag_array);
    $("#tag-string-2").val(tag_array.toString());

}

function showAddModal() {
    $("#showAdd").modal();
    $("#add-tag-input-2").keypress(function (e) {
        if (e.which === 13) {
            addTagForNew();
        }
    });
    $("#imageFile").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    var formData = new FormData();
    var file = $('#imageFile')[0].files;
    $("#add-submite").click(function (e) {
        document.getElementById("add-progress").style.display = "block";
        if (file.length > 0) {
            console.log($("#add-category-2").val());
            formData.append("title", $("#add-title").val());
            formData.append("description", $("#add-dis").val());
            formData.append("category", $("#add-category-2").val());
            formData.append("tags", $("#tag-string-2").val());
            formData.append("image", file[0]);
            $.ajax({
                url: "http://localhost/api/ajax/addWallpaper",
                type: "post",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response);
                    document.getElementById("add-progress").style.display = "none";
                    if (response['ok'] == true){
                        location.reload();
                    }else {
                        alert(response['des']);
                    }
                }

            });
        }
    });
}