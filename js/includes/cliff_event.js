class CliffEvent {

    constructor() {

        const el = CliffFormFn.els();

        const locale = "de-DE"; //FIXME allow user to change

        const start_date_obj = CliffDateFn.get_valid_date_obj(el.start_date.valueAsDate);
        const start_date_ts = CliffDateFn.get_valid_ts(el.start_date.valueAsNumber);
        const start_date_str = start_date_obj ? start_date_obj.toLocaleString(this.locale, {dateStyle: "medium"}) : "";
        const start_time_obj = CliffDateFn.get_valid_date_obj(el.start_time.valueAsDate);
        const start_time_ts = CliffDateFn.get_valid_ts(el.start_time.valueAsNumber);
        const start_time_str = CliffFormFn.els().start_time.value;
        const end_date_obj = CliffDateFn.get_valid_date_obj(el.end_date.valueAsDate)
        const end_date_ts = CliffDateFn.get_valid_ts(el.end_date.valueAsNumber);
        const end_date_str = end_date_obj ? end_date_obj.toLocaleString(this.locale, {dateStyle: "medium"}) : "";
        const end_time_obj = CliffDateFn.get_valid_date_obj(el.end_time.valueAsDate);
        const end_time_ts = CliffDateFn.get_valid_ts(el.end_time.valueAsNumber);
        const end_time_str = CliffFormFn.els().end_time.value;
        const title = document.querySelector("#title").value;

        this.title = title;

        this.start = {
            'date' : {
                'obj' : start_date_obj,
                'ts' : start_date_ts,
                'str' : start_date_str
            }, 
            'time' : {
                'obj' : start_time_obj,
                'ts' : start_time_ts,
                'str' : start_time_str,
                'h' : start_time_obj ? start_date_obj.getHours() : null,
                'm' : start_time_obj ? start_date_obj.getMinutes() : null,
            },
            'datetime' : {}
        };

        this.start.datetime.obj = CliffDateFn.make_datetime_obj(this.start.date.obj, this.start.time.obj);
        this.start.datetime.ts = (this.start.datetime.obj) ? this.start.datetime.obj.getTime() : null;
        this.start.datetime.str = (this.start.datetime.obj) ? this.start.date.str + " " + this.start.time.str : null;

        this.end = {
            'date' : {
                'obj' : end_date_obj,
                'ts' : end_date_ts,
                'str' : end_date_str,
            }, 
            'time' : {
                'obj' : end_time_obj,
                'ts' : end_time_ts,
                'str' : end_time_str,
                'h' : end_time_obj ? end_date_obj.getHours() : null,
                'm' : end_time_obj ? end_date_obj.getMinutes() : null,
            },
            'datetime' : {}
        };

        this.end.datetime.obj = CliffDateFn.make_datetime_obj(this.end.date.obj, this.end.time.obj);
        this.end.datetime.ts = (this.end.datetime.obj) ? this.end.datetime.obj.getTime() : null;
        this.end.datetime.str = (this.end.datetime.obj) ? this.end.date.str + " " + this.end.time.str : null;

    }

}