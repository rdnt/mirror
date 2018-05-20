var pending = false;
var pass = false;
var response = {"response": "FORM_DATA_EMPTY"};
function asyncFormSubmission(form_id, target_url = null, init, callback, min_delay = 0, error_delay = 0, rapid_error = false) {
    $(form_id).submit(function(e) {
        e.preventDefault();
        if (!pending) {
            var url = "";
            if (target_url instanceof Function) {
                url = target_url();
            }
            else {
                url = target_url;
            }
            init();
            pending = true;
            if (!pass) {
                setTimeout(function(){
                    pending = false;
                    callback(response);
                }, error_delay);
                return;
            }
            var start = new Date();
            $.ajax({
                method: "POST",
                url: url,
                data: $(this).serialize(),
                success: function(data) {
                    data = $.trim(data);
                    var duration = new Date() - start;
                    try {
                        data = JSON.parse(data);
                    }
                    catch(e) {
                        data = {"response": "JSON_PARSE_FAILED"};
                    }
                    if (data['response'] === "SUCCESS" || rapid_error === false) {
                        setTimeout(function(){
                            pending = false;
                            callback(data);
                        }, min_delay - duration);
                    }
                    else if (rapid_error === true) {
                        callback(data);
                        setTimeout(function(){
                            pending = false;
                        }, error_delay);
                    }
                    else {
                        setTimeout(function(){
                            callback(data);
                            pending = false;
                        }, error_delay);
                    }
                },
                error: function(){
                    data = {"response": "RESPONSE_TIMEOUT"};
                    callback(data);
                    pending = false;
                },
                timeout: 3000
            });
        }
    });
}
