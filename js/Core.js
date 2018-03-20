function Core (controller) {
    this.controller = controller;
    this.apiURL = '/player-test/';
}

$.extend(Core.prototype, {
    /**
     * Execute a call to the api & pass returned data to a callback
     * @param action the action to execute on the api
     * @param data an optional object of key => value pairs to pass to the api as POST data
     * @param callback an optional function to execute when the API call returns
     * @example
     * this.execute('summary', function(result) {
     *  console.log('api GET returned: ', result);
     * });
     * this.execute('save', {name: 'Peter'}, function(result) {
     *  console.log('api POST returned: ', result);
     * });
     * this.execute('delete', {name: 'Peter'});
     */
    execute: function (action, data, callback) {
        if (!this.controller) {
            throw new Error ('No controller set');
        }

        // allow data to be optional - if only 2 parameters are passed
        // assume the last parameter is always a callback
        if (typeof callback == 'undefined') {
            callback = data;
            data = {};
        }

        // build route URL
        var routeURL = this.apiURL + this.controller + '/' + action + '/';

        // execute the call & pass returned data to the specified callback
        $.ajax({
            url: routeURL,
            method: data ? 'GET' : 'POST',
            data: data,
        }).done((data) => {
            if (!callback) {
                return;
            }
            data = $.parseJSON(data);
            callback(data);
        });
    }
});

