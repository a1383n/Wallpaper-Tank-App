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