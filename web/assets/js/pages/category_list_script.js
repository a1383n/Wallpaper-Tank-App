function editCategory(id){
    $("#editCategory").modal();
    const url = "http://localhost/api/ajax/getCategory";
    const formData = new FormData();
    formData.append("id",id);
    $.ajax({
        url: url,
        type : 'post',
        data: formData,
        processData : false,
        contentType : false,
        success: function (response) {
            console.log(response);
            $("#edit-id").val(response['items'][0]['id']);
            $("#edit-name").val(response['items'][0]['name']);
            $("#edit-title").val(response['items'][0]['title']);
        }
    });

    document.getElementById("save-edit").addEventListener("click",SaveData);

}

function SaveData() {
    const url = "http://localhost/api/ajax/editCategory";
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            $("#showEdit").modal('hide');
            location.reload();
        }
    };
    xhttp.open("POST", url, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id="+$("#edit-id").val()+"&name="+$("#edit-name").val()+"&title="+$("#edit-title").val());

    console.log();
}

function ShowdeleteCategory(id) {
    $("#removeCategory").modal();
    $("#delete-id").val(id);
}

function deleteCategory() {
    const id = $("#delete-id").val();
    const url = "http://localhost/api/ajax/deleteCategory";
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $("#removeCategory").modal('hide');
            location.reload();
        }
    };
    xhttp.open("POST", url, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id="+id);
}