    $("add-form-wallpaper-tags-input-btn").click(function () {

    })
    $('#add-form-wallpaper-tags-input').keypress(function (e) {
        var key = e.which;
        if(key == 13)  // the enter key code
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
    $(".modal-title").text("Add Wallpaper");
    $("#add-form-wallpaper-action-input").val("Add");
    $("#add-form-wallpaper-action-input").val("Add");

    $("#addModal .modal-body .form-group").css("display", "block");

    //Remove img tag
    $("#addModal .modal-body img").remove();

    $(document).on("submit","#add-wallpaper-form",function (event) {
        event.preventDefault();
        const formData = new FormData();
        const file = $('#add-form-wallpaper-image-input')[0].files;
        if (file.length > 0) {
            formData.append("title", $("#add-form-wallpaper-title-input").val());
            formData.append("category", $("add-form-wallpaper-category-input").val());
            formData.append("tags", $("#add-form-wallpaper-tags-array-string").val());
            formData.append("image",file[0]);
        }
        $.ajax({
            url: "../api/ajax/add.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response)
                document.getElementById("add-form-wallpaper-tags-list").appendChild(newTagButtonGenerator("title",0))
            }
        });
    });
}

function newTagButtonGenerator(title){
    const button = document.createElement("button");
    button.className = "btn btn-secondary tags";
    const span = document.createElement("span");
    span.className = "badge bg-danger";
    span.innerHTML = '<li class="fa fa-close"></li>';
    span.onclick = function (){
        button.remove();
        const array = $("#add-form-wallpaper-tags-array-string").val().split(",");
        var i;
        for (i = 0; i < array.length;i++){
            if (array[i] == title){
                array.splice(i,0);
            }
        }
        $("#add-form-wallpaper-tags-array-string").val(array);

    };
    button.innerHTML = title;
    button.appendChild(span);
    addTagToArray(title);
    document.getElementById("add-form-wallpaper-tags-list").appendChild(button);
}

function addTagToArray(title){
    const array = $("#add-form-wallpaper-tags-array-string").val().split(",");
    if (array[0] == ""){
        array.splice(0,1);
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

    fetchSingleData(id);

}

function fetchSingleData(id) {
    $.ajax({
        url: "../api/ajax/fetch.php?id=" + id,
        type: "GET",
        contentType: false,
        processData: false,
        success: function (responseJSON) {
            // TODO: Remove Log
            console.log(responseJSON);

            // Remove Previous 'img' tag
            $("#addModal .modal-body img").remove();

            // Append new img tag
            $("#addModal .modal-body").append('<img src="' + responseJSON['data']['wallpaper'] + '" class="embed-responsive" />');
        }
    });
}