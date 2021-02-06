class CliffFormFn {

    static change = _el => {
        //FIXME: should we rebuild this whole object every form change?
        cliff_event = new CliffEvent();

        let id = _el.getAttribute('id');

        if(id == "cliff_all_day") CliffFormFn.check_all_day();

        if((id == "cliff_end_time") || (id == "cliff_end_date")) CliffFormFn.validate_end_time();

        if(id == "cliff_duration") CliffFormFn.validate_duration_input();

        CliffRepeating.update_parent_event();
    }

    static validate_duration_input = _ => {

        const el = CliffFormFn.els().duration;

        if(el.value == "") { 

            CliffFormFn.hide_validation_error("#cliff_duration");
            return false;

        }

        if(!cliff_event.start.datetime.obj) {

            CliffFormFn.show_validation_error("#cliff_duration", ".fill-start-date");

            return false;

        }

        var duration_field_arr = el.value.split(":");

        var h = parseInt(duration_field_arr[0]);

        var m = duration_field_arr[1] ? parseInt(duration_field_arr[1]) : 0;

        if(isNaN(h) || isNaN(m)) {

            CliffFormFn.show_validation_error("#cliff_duration", ".format");

            return false;

        }

        if( (h < 0) || (m < 0) ) {

            CliffFormFn.show_validation_error("#cliff_duration", ".negative");

            return false;

        } 

        CliffFormFn.hide_validation_error("#cliff_duration");

        CliffFormFn.set_duration_field_value({
            'string' : CliffDateFn.get_hhmm(h,m),
            'h' : h,
            'm' : m
        });

        CliffFormFn.set_datetime_by_duration(h, m);

    } 

    static set_datetime_by_duration(h, m) {

        const start_datetime = cliff_event.start.datetime.obj;

        let end_datetime = new Date(start_datetime.setHours(start_datetime.getHours() + h));

        end_datetime = new Date(end_datetime.setMinutes(end_datetime.getMinutes() + m));

        CliffFormFn.els().end_date.valueAsDate = end_datetime;
        CliffFormFn.els().end_time.value = end_datetime.toLocaleString(cliff_event.locale, {
            hour: "2-digit",
            minute: "2-digit"
        });

        cliff_event = new CliffEvent();
    }

    static check_all_day = _ => {

        const el = CliffFormFn.els().all_day;

        let time_fields = CliffFormFn.els().container.querySelectorAll(".cliff-time");

        if(el.checked) {

            CliffQ.set_attrs(time_fields, "disabled", "disabled");
            CliffFormFn.hide_validation_error("#cliff_duration, #cliff_end_time");
            

        } else {

            CliffQ.remove_attrs(time_fields, "disabled");
            CliffFormFn.validate_end_time();
            CliffFormFn.validate_duration_input();

        }

    }

    static els = _ => {

        let container = document.querySelector(".cliff-calendar-admin-wrapper");

        return {
            container : container,
            start_date : container.querySelector("#cliff_start_date"),
            start_time : container.querySelector("#cliff_start_time"),
            end_date : container.querySelector("#cliff_end_date"),
            end_time : container.querySelector("#cliff_end_time"),
            duration : container.querySelector("#cliff_duration"),
            all_day : container.querySelector("#cliff_all_day")
        }
    }

    static validate_end_time = _ => {

        let els = CliffFormFn.els();

        //make sure end date is not before start date
        if(isNaN(cliff_event.end.date.ts) || (cliff_event.end.date.ts < cliff_event.start.date.ts)) {

            CliffFormFn.equalize_start_and_end_dates();

        }

        //Make sure end datetime is not before start datetime
        if(cliff_event.start.datetime.obj && cliff_event.end.datetime.obj) {

            if(!isNaN(cliff_event.end.date.ts) && (cliff_event.end.time.ts < cliff_event.start.time.ts)) {

                //CliffFormFn end time isn't before start time and if it is reset it
                CliffFormFn.equalize_start_and_end_dates();

            }

            CliffFormFn.update_duration_field();

        }

    }

    static equalize_start_and_end_dates = _ => {

        let els = CliffFormFn.els();

        els.end_date.valueAsNumber = cliff_event.start.date.ts;

        cliff_event.end.date.ts = cliff_event.start.date.ts;
        cliff_event.end.date.obj = cliff_event.start.date.obj;

        if(cliff_event.start.datetime.obj && cliff_event.end.datetime.obj) {

            els.end_time.valueAsNumber = cliff_event.start.time.ts;

            cliff_event.end.time.ts = cliff_event.start.time.ts;
            cliff_event.end.time.date = cliff_event.start.time.date;
            cliff_event.end.datetime.ts = cliff_event.start.datetime.ts;
            cliff_event.end.datetime.date = cliff_event.start.datetime.date;

        }

    }

    static update_duration_field = _ => {

        const diff_obj = CliffDateFn.get_diff_obj(cliff_event.start.datetime.ts, cliff_event.end.datetime.ts);
        CliffFormFn.set_duration_field_value(diff_obj);

    }

    static set_duration_field_value = _diff_obj => {

        if(!_diff_obj) return false;

        const duration = CliffFormFn.els().duration;

        duration.value = (_diff_obj ? _diff_obj.string : null);
        duration.setAttribute("h", _diff_obj.h);
        duration.setAttribute("m", _diff_obj.m);

        CliffFormFn.validate_duration_field(_diff_obj);

    }


    static validate_duration_field = _duration_obj => {

        const warning_el = this.els().container.querySelector(".duration-warning");

        if(_duration_obj.h > 10) {

            warning_el.classList.remove("d-none");

        } else {

            warning_el.classList.add("d-none");

        }

        if((_duration_obj.h == 0) && (_duration_obj.m == 0 )) {

            CliffFormFn.show_validation_error("#cliff_duration, #cliff_end_time", ".negative");

        } else {

            CliffFormFn.hide_validation_error("#cliff_duration, #cliff_end_time");

        }

    }

    static show_validation_error = (_input_selectors, _nested_selector_show = false) => {

        const els = this.els().container.querySelectorAll(_input_selectors);
        
        for(const el of els) {

            el.classList.add("is-invalid");
            const sibling = CliffQ.next_sibling(el, ".invalid-feedback");
            CliffQ.show(sibling);

            const elem_show = sibling.querySelectorAll(_nested_selector_show);
            if(elem_show.length) {

                const nested_selectors = sibling.querySelectorAll(".invalid-feedback-child");
                CliffQ.hide(nested_selectors);
                CliffQ.show(elem_show);

            }

        }
            
    }

    static hide_validation_error = (_input_selectors) => {

        const els = this.els().container.querySelectorAll(_input_selectors);

        for(const el of els) {

            el.classList.remove("is-invalid");
            const sibling = CliffQ.next_sibling(el, ".invalid-feedback");
            CliffQ.hide(sibling);
        }

    }

}