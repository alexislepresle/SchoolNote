function getFormData($form) {
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function (n, i) {
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}

$(function () {
    $("#form-signin").submit(function (event) {
        event.preventDefault();
        // $.post("_api.php/login", JSON.stringify($(this).serializeArray()))
        //     .done(function (data) {
        //         console.log(data);
        //     });
        console.log(getFormData($(this)));
    });

    $("#addAbsence").submit(function (event) {
        event.preventDefault();
        // $.post("_api.php/login", JSON.stringify($(this).serializeArray()))
        //     .done(function (data) {
        //         console.log(data);
        //     });
        console.log(getFormData($(this)));
    });
});