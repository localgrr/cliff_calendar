class CliffRepeating {

    constructor() {

                        
    }

    static update_parent_event = _ => {

        const title = cliff_event.title;
        const start_date = cliff_event.start.date.str ? "<br>" + cliff_event.start.date.str : "";
        const end_date = cliff_event.end.date.str ? " - " + cliff_event.end.date.str : "";
        const start_time = cliff_event.start.time.str ? cliff_event.start.time.str : "";
        const end_time = cliff_event.end.time.str ? " - " + cliff_event.start.time.str : "";
        if(cliff_event.title) CliffFormFn.els().container.querySelector("#parent-event").innerHTML = 
            `<span class="badge bg-primary">${title} ${start_date}${end_date} ${start_time}${end_time}</span>`;
    }
}