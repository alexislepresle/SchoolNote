function getFormData($form) {
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function (n, i) {
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}

$(function () {
    $("#datepickerend").datepicker({
        dateFormat: 'dd-mm-yy',
        currentText: "Now"
    });
    $.datepicker.setDefaults($.datepicker.regional["fr"]);
    $('#timepicker').timepicker({
        timeFormat: 'HH:mm',
        interval: '30',
        minTime: '8:00',
        maxTime: '18:00',
        defaultTime: '8:00',
        startTime: '8:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });
    $('#timepickerend').timepicker({
        timeFormat: 'HH:mm',
        interval: '30',
        minTime: '8:00',
        maxTime: '18:00',
        defaultTime: '8:00',
        startTime: '8:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });


    $("#form-signin").submit(function (event) {
        event.preventDefault();
        console.log(getFormData($(this)));
        $.post("_api.php/login", JSON.stringify(getFormData($(this))))
            .done(function (data) {
                var responseCode = data['code'];
                if (responseCode == 2 || responseCode == 3) {
                    alert(data['data']);
                } else {
                    location.reload();
                }
            });
    });


    $("#addAbsence").submit(function (event) {
        event.preventDefault();
        // $.post("_api.php/login", JSON.stringify($(this).serializeArray()))
        //     .done(function (data) {
        //         console.log(data);
        //     });
        console.log(getFormData($(this)));
    });

    $("#absenceTable").DataTable(
        // $.ajax({
        //     url: "",
        // })
        { "data": [["13\/06\/2019", "M1101", "UE 1", "Estelle Gertner"], ["13\/06\/2019", "M2204", "UE 4", "Estelle Gertner"], ["13\/06\/2019", "M1104", "UE 1", "Ronan Poinsignon"], ["29\/06\/2019", "M1101", "UE 1", "Arthur Cuiller"], ["12\/06\/2019", "M1104", "UE 1", "Estelle Gertner"], ["13\/06\/2019", "M1204", "UE 2", "Pierre Noisette"], ["17\/04\/2019", "M1201", "UE 2", "Pierre Noisette"], ["13\/05\/2019", "M4301", "UE 10", "Pierre Noisette"]] }
    );

});