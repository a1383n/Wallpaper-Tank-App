$("#add-form-wallpaper-tags-input-btn").click(function () {
    const text = $("#add-form-wallpaper-tags-input").val();
    console.log(text);
    newTagButtonGenerator($("#add-form-wallpaper-tags-input").val());
    $("#add-form-wallpaper-tags-input").val("");
})
$('#add-form-wallpaper-tags-input').keypress(function (e) {
    var key = e.which;
    if (key == 13)  // the enter key code
    {
        const text = $("#add-form-wallpaper-tags-input").val();
        console.log(text);
        newTagButtonGenerator($("#add-form-wallpaper-tags-input").val());
        $("#add-form-wallpaper-tags-input").val("");
        return false;
    }
});

function resetForm(formID) {
    const inputs = document.getElementById(formID).getElementsByTagName("input");
    var i;
    for (i = 0; i < inputs.length; i++) {
        if (inputs[i].getAttribute("type") == "text") {
            inputs[i].value = "";
        }
    }
    document.getElementById(formID).getElementsByTagName("select")[0].value = "";

    // Reset File input
    $(".custom-file-label").removeClass("selected").html("Choose file");

}

function addButton() {
    resetForm("add-wallpaper-form");

    $("#add-form-wallpaper-action-input").show();
    $("#add-form-wallpaper-reset-input").show();

    $(".modal-title").text("Add Wallpaper");
    $("#add-form-wallpaper-action-input").val("Add");
    $("#add-form-wallpaper-action-input").val("Add");

    $("#addModal .modal-body .form-group").css("display", "block");

    //Add select2
    $("#add-form-wallpaper-category-input").select2({
        placeholder: "Select category"
    });

    //Remove img tag
    $("#addModal .modal-body img").remove();

    $(document).on("submit", "#add-wallpaper-form", function (event) {
        event.preventDefault();
        const formData = new FormData();
        const file = $('#add-form-wallpaper-image-input')[0].files;
        if (!$("#add-form-wallpaper-tags-array-string").val()) {
            $("#add-form-wallpaper-tags-input-error").show();
            return;
        }
        if (file.length > 0) {
            formData.append("title", $("#add-form-wallpaper-title-input").val());
            formData.append("category_id", $("#add-form-wallpaper-category-input").val());
            formData.append("tags", $("#add-form-wallpaper-tags-array-string").val());
            formData.append("image", file[0]);
        }

        document.getElementById("add-form-wallpaper-action-input").disabled = true;

        formData.append('action','PUT');

        $.ajax({
            url: "",
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: false,
            processData: false,
            success: function (responseJSON) {
                console.log("ok");
                if (responseJSON['ok'] == true) {
                    $("#addModal").modal("hide");
                    reloadTable();
                }
            }
        });
    });
}

function newTagButtonGenerator(title) {

    if (title == "" || title == null || title == " ") {
        return;
    } else if (title.includes(",")) {
        return
    }

    // hide error message
    $("#add-form-wallpaper-tags-input-error").hide();

    const button = document.createElement("button");
    button.className = "btn btn-secondary tags";
    const span = document.createElement("span");
    span.className = "badge bg-danger";
    span.innerHTML = '<li class="fa fa-close"></li>';
    span.onclick = function () {
        button.remove();
        const array = $("#add-form-wallpaper-tags-array-string").val().split(",");
        var i;
        for (i = 0; i < array.length; i++) {
            if (array[i] == title) {
                array.splice(i, 1);
            }
        }
        $("#add-form-wallpaper-tags-array-string").val(array);

    };
    button.innerHTML = title;
    button.appendChild(span);
    addTagToArray(title);
    document.getElementById("add-form-wallpaper-tags-list").appendChild(button);
}

function addTagToArray(title) {
    const array = $("#add-form-wallpaper-tags-array-string").val().split(",");
    if (array[0] == "") {
        array.splice(0, 1);
    }
    array.push(title);
    $("#add-form-wallpaper-tags-array-string").val(array);
    console.log(array);
}

function viewButton(id) {
    console.log("log");
    $("#addModal").modal();
    resetForm("add-wallpaper-form");
    $(".modal-title").text("View Wallpaper");
    $("#add-form-wallpaper-action-input").val("View");
    $("#add-form-wallpaper-action-input").val("View");

    $("#addModal .modal-body .form-group").css("display", "none");

    $("#add-form-wallpaper-action-input").hide();
    $("#add-form-wallpaper-reset-input").hide();

    fetchWallpaperImage(id);
}

function fetchWallpaperImage(id) {
    $.ajax({
        url: "/api/wallpapers/"+id,
        type: "GET",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        contentType: false,
        processData: false,
        success: function (responseJSON) {
            // Remove Previous 'img' tag
            $("#addModal .modal-body img").remove();

            // Append new img tag
            $("#addModal .modal-body").append('<img src="' + responseJSON['wallpaper_url'] + '" class="embed-responsive" />');
        }
    });
}

function editButton(id) {
    $("#addModal").modal("show");

    $("#add-form-wallpaper-action-input").show();
    $("#add-form-wallpaper-reset-input").show();

    resetForm("add-wallpaper-form");
    $(".modal-title").text("Edit Wallpaper");
    $("#add-form-wallpaper-action-input").val("Edit");
    $("#add-form-wallpaper-action-input").val("Edit");

    $("#addModal .modal-body .form-group").css("display", "block");

    //Remove img tag
    $("#addModal .modal-body img").remove();

    $.ajax({
        url: "/api/wallpapers/" + id,
        type: "GET",
        contentType: false,
        processData: false,
        success: function (responseJSON) {
            //set inputs values
            $("#add-form-wallpaper-title-input").val(responseJSON['title']);
            $("#add-form-wallpaper-id-input").val(responseJSON['id']);

            // show tags
            document.getElementById("add-form-wallpaper-tags-list").innerHTML = "";
            $("#add-form-wallpaper-tags-array-string").val("");
            const array = responseJSON['tags'].toString().split(",");
            var i;
            for (i = 0; i < array.length; i++) {
                newTagButtonGenerator(array[i]);
            }
            // Hide file input
            $(".custom-file").hide();

            // Set selected category
            const options = document.getElementById("add-form-wallpaper-category-input").getElementsByTagName("option");
            var i;
            for (i = 0; i < options.length; i++) {
                if (options[i].value == responseJSON['category_id']) {
                    options[i].selected = true;
                }
            }
            //Add select2
            $("#add-form-wallpaper-category-input").select2({
                placeholder: "Select category"
            });
        }
    });

    document.getElementById("add-form-wallpaper-action-input").addEventListener("click", function () {
        document.getElementById("add-form-wallpaper-action-input").disabled = true;
        const formData = new FormData();
        formData.append("id", $("#add-form-wallpaper-id-input").val());
        formData.append("title", $("#add-form-wallpaper-title-input").val());
        formData.append("category_id", $("#add-form-wallpaper-category-input").val());
        formData.append("tags", $("#add-form-wallpaper-tags-array-string").val());

        formData.append('action','EDIT');

        $.ajax({
            url: "",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function (responseJSON) {
                if (responseJSON['ok']) {
                    document.getElementById("add-form-wallpaper-action-input").disabled = false;
                    $("#addModal").modal("hide");
                    reloadTable();
                }
            }
        });
    })
}

function deleteButton(id) {
    if (confirm("Are you sure you want to delete this row?")) {

        const formData = new FormData();
        formData.append('id',id);
        formData.append('action','DELETE');

        $.ajax({
            url: "",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function (){
                reloadTable();
            }
        });
    }
}

// ***************************************** CATEGORY ********************************
function addCategory(){
    $("#add-category-action").val("Add");
    $("#add-category-name-input").val("");
    $("#add-category-color-input").val("#333333");

    $(document).off("submit","#add-category-form");
    $(document).on("submit","#add-category-form",function (event) {
        if($("#add-category-action").val() == "Add") {
            event.preventDefault();

            const formData = new FormData();
            formData.append("name", $("#add-category-name-input").val());
            formData.append('title', $("#add-category-name-input").val().toUpperCase())
            formData.append("color", $("#add-category-color-input").val());

            formData.append('action','PUT');

            $.ajax({
                url: "",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                contentType: false,
                processData: false,
                success: function (responseJSON) {
                    if (responseJSON['ok']) {
                        $("#categoryModal").modal('toggle');
                        reloadTable();
                    }
                }
            });
        }
    })
}

function editCategory(id){
    $("#categoryModal").modal("show");
    $("#add-category-action").val("Edit");
    $.ajax({
        url: "/api/categories/"+id,
        type: "GET",
        contentType:false,
        processData: false,
        success: function (responseJSON) {
            $("#add-category-name-input").val(responseJSON["name"]);
            $("#add-category-color-input").val(responseJSON["color"]);
        }
    });

    $(document).off("submit","#add-category-form");
    $(document).on("submit","#add-category-form",function (event) {
        event.preventDefault();
        if ($("#add-category-action").val() == "Edit"){
            const formData = new FormData();
            formData.append("id",id);
            formData.append("name",$("#add-category-name-input").val());
            formData.append('title',$('#add-category-name-input').val().toUpperCase());
            formData.append("color",$("#add-category-color-input").val());
            formData.append('action','EDIT');

            $.ajax({
                url: "",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                contentType:false,
                processData: false,
                success: function (responseJSON){
                    if (responseJSON["ok"] == true) {
                        $("#categoryModal").modal("hide");
                        reloadTable();
                    }
                }
            });
        }
    })
}

function deleteCategory(id){
    if (confirm("Are you sure you want delete this row?")){
        const formData = new FormData();
        formData.append('id',id);
        formData.append('action','DELETE');
        $.ajax({
            url: "",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (responseJSON) {
                reloadTable();
            }
        });
    }
}
