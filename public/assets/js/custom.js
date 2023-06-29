$('#course').on('change', function () {
    if ($(this).val() != '') {
        var CourseID = $(this).val();
        try {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: site_url + "/get-semesters",
                dataType: "json",
                data: { CourseID: CourseID },
                beforeSend: function () {
                    $('body').css('opacity', '0.5');
                },
                success: function (data) {
                    $('body').css('opacity', '1');
                    $('#semester').html('<option value="">Please Select Semester</option>');
                    $('#group').html('<option value="">Please Select Group</option>');
                    if (data.data && data.data != '') {
                        $.each(data.data, function (key, value) {
                            $('#semester').append('<option value="' + value.semester_id + '">' + value.semester_name + '</option>');
                        });
                    }
                }
            });
        }
        catch (e) {
            console.log(e);
        }
    }
    else {
        $('#semester').html('<option value="">Please Select Semester</option>');
        $('#group').html('<option value="">Please Select Group</option>');
    }
});
$('#semester').on('change', function () {
    if ($(this).val() != '') {
        var SemesterID = $(this).val();
        var CourseID = $('#course').val();
        try {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: site_url + "/get-groups",
                dataType: "json",
                data: { CourseID: CourseID, SemesterID: SemesterID },
                beforeSend: function () {
                    $('body').css('opacity', '0.5');
                },
                success: function (data) {
                    $('body').css('opacity', '1');
                    $('#group').html('<option value="">Please Select Group</option>');
                    if (data.data && data.data != '') {
                        $.each(data.data, function (key, value) {
                            $('#group').append('<option value="' + value.group_id + '">' + value.group_name + '</option>');
                        });
                    }
                }
            });
        }
        catch (e) {
            console.log(e);
        }
    }
    else {
        $('#group').html('<option value="">Please Select Group</option>');
    }
});
// $('#from_date').on('change', function () {
//     console.log($(this).value)
//     $("#to_date").setAttribute("min", new Date($(this).value).toISOString().split("T")[0]);
// })