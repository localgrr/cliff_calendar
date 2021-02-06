class CliffDateFn {

    static make_datetime_obj = (_date_obj, _time_obj) => {

        if(!this.is_valid_date_obj(_date_obj) || !this.is_valid_date_obj(_time_obj)) return null;

        const datetime = new Date(_date_obj.getFullYear(), _date_obj.getMonth(), _date_obj.getDate(), _time_obj.getHours(), _time_obj.getMinutes());

        //adjust for timezone
        datetime.setHours(datetime.getHours() + (datetime.getTimezoneOffset() / 60));

        return datetime;

    }

    static is_valid_date_obj = _obj => _obj && Object.prototype.toString.call(_obj) === "[object Date]" && !isNaN(_obj);

    static get_valid_date_obj = _obj => this.is_valid_date_obj(_obj) ? _obj : null;

    static get_valid_ts = _ts => this.is_valid_ts(_ts) ? _ts : null;

    static is_valid_ts = _ts => {

        let newTimestamp = new Date(_ts).getTime();
        return this.is_numeric(newTimestamp);

    }

    static is_numeric = _num => !isNaN(parseFloat(_num)) && isFinite(_num);

    static ts_to_duration_obj = _timestamp => {

        if(isNaN(_timestamp)) return null;

        var ms = _timestamp % 1000;
        _timestamp = (_timestamp - ms) / 1000;
        var secs = _timestamp % 60;
        _timestamp = (_timestamp - secs) / 60;
        var mins = _timestamp % 60;
        var hrs = (_timestamp - mins) / 60;

        return {
            'string' : CliffDateFn.get_hhmm(hrs,mins),
            'h' : hrs,
            'm' : mins
        }
    }

    static get_diff_obj = (_start_datetime_ts, _end_datetime_ts) => {

        let diff = _end_datetime_ts - _start_datetime_ts; //this gives us ms
        return CliffDateFn.ts_to_duration_obj(diff);

    }

    static get_hhmm(h,m) {

        return h.toString().padStart(2, '0') + ":" + m.toString().padStart(2, '0');

    }
}