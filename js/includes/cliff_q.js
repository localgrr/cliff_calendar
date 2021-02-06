class CliffQ {

    static set_attrs = (_els, _name, _value) => {

        const els = this.force_array(_els);
        for(const el of els) if(el) el.setAttribute(_name, _value);

    }

    static remove_attrs = (_els, _name) => {

        const els = this.force_array(_els);

        for(const el of els) {

            if(el) el.removeAttribute(_name);
        }

    }

    static next_sibling = function (_el, _selector) {

        // Get the next sibling element
        let sibling = _el.nextElementSibling;

        // If there's no selector, return the first sibling
        if (!_selector) return sibling;

        // If the sibling matches our selector, use it
        // If not, jump to the next sibling and continue the loop
        while (sibling) {
            if (sibling.matches(_selector)) return sibling;
            sibling = sibling.nextElementSibling
        }

    };

    static show(_els) {

        const els = this.force_array(_els);

        for(const el of els) {
            if(el.classList) {
                el.classList.add("d-block");
                el.classList.remove("d-none");
            }
        }

    }

    static hide(_els) {

        const els = this.force_array(_els);

        for(const el of els) {
            if(el.classList) {
                el.classList.add("d-none");
                el.classList.remove("d-block");
            }
        }

    }

    static force_array = _var => {
        if(!_var) return [];
        return _var.length ? _var : [_var];
    }
}