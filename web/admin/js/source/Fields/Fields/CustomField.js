import Field from "admin-config/lib/Field/Field";

class CustomField extends Field
{
    constructor(name) {
        super(name);
        this._type = "custom";
        this._flattenable = false;
        this._config = null;
    }

    config(config){
        if(arguments.length){
            this._config = config;
            return this;
        }

        return this._config;
    }
}

export default CustomField;
