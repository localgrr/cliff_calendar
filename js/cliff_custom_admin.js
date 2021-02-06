
let cliff_event = {};

document.addEventListener("DOMContentLoaded",function(){

    if(document.querySelectorAll(".cliff-calendar-admin-wrapper").length>0) {

        cliff_event = new CliffEvent();
        console.log("es6", cliff_event);

        const els = CliffFormFn.els().container.querySelectorAll("input, select");

        for(const el of els) {

            el.addEventListener('change', (event) => {

                CliffFormFn.change(event.srcElement);

            });

            //trigger
            CliffFormFn.change(el);

        }
    }

});

