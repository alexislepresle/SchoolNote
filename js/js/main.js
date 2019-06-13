function getFormData($form) {
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function (n, i) {
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}

$(function () {

    var inputCount = 0;

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
        var isComplete = true;
        $.each($(this).serializeArray(), function (index, valueObject) {
            var value = valueObject['value'];
            if (value == null || value == "") {
                isComplete = false;
            }
        });
        if (isComplete) {
            $.post("_api.php/addabsence", JSON.stringify(getFormData($(this))))
                .done(function (data) {
                    console.log(data);
                });

        } else {
            alert("Please fill all the Inputs");
            return;
        }

    });

    $("#absenceTable").DataTable({
        "ajax": '_api.php/dashboard',
    });


    $("#button").click(function () {
        inputCount++;
        if (inputCount < 10) {
            $("<div class='control has-icons-left has-icons-right' id='Entry' style='margin-top:10px;'><input class='input studentName' type='text' placeholder='Student name' id='nameInput' name=student" + inputCount + "><span class='icon is-small is-right'><i class='fas fa-search'></i></span></div > ").appendTo($("#Entries"))
        }
    });

    $("#addAbsence").ready(function () {
        $.get("_api.php/getmodule")
            .done(function (data) {
                $.each(data, function (index, value) {
                    var option = $("<option/>", {
                        value: value[0],
                        text: value[1]
                    });
                    $('#module').append(option);
                });
                $.each(["eins", "zwei"], function (value) {
                    var option = $("<option/>", {
                        value: value,
                        text: value
                    });
                    $("#class").append(option);
                });
            });
        $("#module").on('change', function () {
            $.post("_api.php/getue", JSON.stringify({ "data": $(this).val() })).done(function (data) {
                console.log(data);
                $.each(data, function (index, value) {
                    var option = $("<option/>", {
                        value: value[0],
                        text: value[1]
                    });
                    $('#ue').append(option);
                });
            });
        });

        $("#nameInput").autocomplete({
            source: function (request, response) {
                $.post("_api.php/autoname", JSON.stringify({ "data": request.term })
                    , function (data) {
                        console.log(data);
                        var suggestions = [];
                        $.each(data, function (index, value) {
                            suggestions.push(value['name']);
                        });
                        console.log(suggestions);
                        response(suggestions);
                    });
            },
            minLength: 4
        });



    });
});