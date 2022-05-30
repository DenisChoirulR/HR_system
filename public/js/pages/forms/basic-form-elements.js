$(function () {
    //Textarea auto growth
    autosize($('textarea.auto-growth'));

    //Datetimepicker plugin
    $('.datetimepicker').bootstrapMaterialDatePicker({
        format: 'dddd DD MMMM YYYY - HH:mm',
        clearButton: true,
        weekStart: 1
    });

    $('.datepicker').bootstrapMaterialDatePicker({
        format: 'dddd DD MMMM YYYY',
        clearButton: true,
        weekStart: 1,
        time: false
    });

    $('.timepicker').bootstrapMaterialDatePicker({
        format: 'HH:mm',
        clearButton: true,
        date: false
    });

    //Bootstrap datepicker plugin
    $('#bs_datepicker_container input').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
        container: '#bs_datepicker_container'
    });

    $('#bs_datepicker_component_container').datepicker({
        autoclose: true,
        container: '#bs_datepicker_component_container'
    });
    //
    $('#bs_datepicker_range_container').datepicker({
        autoclose: true,
        container: '#bs_datepicker_range_container'
    });

    $('#bs_datepicker_container_timeoff_form').datepicker('show', {

    });

    $('#bs_datepicker_container_timeoff_form').on('changeDate', function(event) {

        const selectedDate = event.format();
        const selectedDateId = selectedDate.replace(/\//g,'');
        
        // reject if element exists already
        if ( $("#tag-" + selectedDateId.toString()).length ) return;

        const chosenDateTag = "<label id=tag-" + selectedDateId.toString() + " class='label label-info' style='margin-right:5px;margin-top:10px;padding:2%;border-radius:5px;background-color:#f3f3f3;color:#a1a1a1;box-shadow:1px 1px #e5e5e5;float:left;'>" + selectedDate + "<span style='top:-1px;margin-left:5px;position:relative;' name=" + selectedDate + " id='removetag-" + selectedDateId.toString() + "'>x</span>";
        $('#chosen_date_container').append(chosenDateTag);

        const currLeaveDates = $('#leave_dates').val() == "" ? selectedDate.toString() : $('#leave_dates').val() + "," + selectedDate.toString();
        $('#leave_dates').val( currLeaveDates );
    });

    if (window.location.pathname.indexOf('/leave-form') > -1) {
        $("#chosen_date_container").on('click', "[id^=removetag-]", function() {
            const ids = (this.id).split("-");
            const chosenDate = ids[1];
            const date = this.getAttribute("name");

            // remove chosen date from UI
            $("#tag-" + chosenDate).remove();  
            
            // remove chosen date from input form
            let currLeaveDatesArr = $('#leave_dates').val().split(",");
            
            const idx = currLeaveDatesArr.indexOf(date);
            if (idx > -1) {
              currLeaveDatesArr.splice(idx, 1);
            }
            $('#leave_dates').val( currLeaveDatesArr );      
        });
    }
});