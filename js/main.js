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
    });

    $("#submitForm").click(function (event) {
        event.preventDefault();
        var isComplete = true;
        $.each($("#addAbsence").serializeArray(), function (index, valueObject) {
            var value = valueObject['value'];
            if (value == null || value == "") {
                isComplete = false;
            }
        });
        if (isComplete) {
            $.post("_api.php/addabsence", JSON.stringify(getFormData($("#addAbsence"))))
                .done(function (data) {
                    console.log(data);
                    if (data['code'] == 1) {
                        $(location).attr('href', "/");
                    } else {
                        alert("Something went wrong please try again");
                    }
                });

        } else {
            alert("Please fill all the Inputs");
            return;
        }

    });


    $("#absenceTable").DataTable({
        "ajax": '_api.php/dashboard',
        "order": [[0, "desc"]],
        "columnDefs": [
            {
                "targets": 7,
                "render": function (data, type, row, meta) {
                    var style = "";
                    if (data == 0)
                        style = "times"
                    else
                        style = "check";
                    return "<i class='fas fa-" + style + " title='" + data + " '></i>";
                },
                "sType": "title-string",
            },
            {
                "targets": 8,
                "visible": false,
            },
            {
                "targets": 4,
                "render": function (data, type, row, meta) {
                    var style = "";
                    if (data == 0)
                        style = "times"
                    else
                        style = "check";
                    return "<i class='fas fa-" + style + " title='" + data + " '></i>";
                },
                "sType": "title-string",
            }
        ]
    });


    $('#nameInput' + inputCount).autocomplete({
        source: function (request, response) {
            $.post("_api.php/autoname", JSON.stringify({ "data": request.term })
                , function (data) {
                    var suggestions = [];
                    $.each(data, function (index, value) {
                        suggestions.push(value['name']);
                    });
                    response(suggestions);
                });
        },
        minLength: 3
    });

    $("#cancelButton").click(function (event) {
        event.preventDefault();
        $(location).attr('href', "/");
    });

    $("#addInputFieldButton").click(function () {
        inputCount++;
        if (inputCount < 10) {
            $("<div class='control has-icons-left has-icons-right' id='Entry' style='margin-top:10px;'><input class='input studentName' type='text' placeholder='Student name' id='nameInput" + inputCount + "' name=student" + inputCount + "><span class='icon is-small is-right'><i class='fas fa-search'></i></span></div > ").appendTo($("#Entries"))
        }
        var id = '#nameInput' + inputCount;
        $(id).autocomplete({
            source: function (request, response) {
                $.post("_api.php/autoname", JSON.stringify({ "data": request.term })
                    , function (data) {
                        var suggestions = [];
                        $.each(data, function (index, value) {
                            suggestions.push(value['name']);
                        });
                        response(suggestions);
                    });
            },
            minLength: 3
        });
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
            });
        $("#module").on('change', function () {
            $.post("_api.php/getue", JSON.stringify({ "data": $(this).val() })).done(function (data) {
                $.each(data, function (index, value) {
                    $('#ue').val(value[0]);
                });
            });
        });
    });
});