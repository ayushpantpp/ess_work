/*!
 * bootstrap-tokenfield 0.12.1
 * https://github.com/sliptree/bootstrap-tokenfield
 * Copyright 2013-2014 Sliptree and other contributors; Licensed MIT
 */

jQuery(function() {
    $("#download-master").click(function() {
        _trackEvent("Downloads", "master")
    })
}), jQuery(document).ready(function(a) {
    a("body").scrollspy({target: ".bs-sidebar", offset: 0}), a(window).on("load", function() {
        a("body").scrollspy("refresh")
    }), setTimeout(function() {
        var b = a(".bs-sidebar");
        b.affix({offset: {top: function() {
                    var a = b.offset().top, c = parseInt(b.children(0).css("margin-top"), 10);
                    return this.top = a - c
                }, bottom: function() {
                    return this.bottom = a(".bs-footer").outerHeight(!0)
                }}})
    }, 100), a(".token-example-field").tokenfield(), a("#tokenfield-1").tokenfield({autocomplete: {source: ["Anand Saurabh", "Ankush Aggarwal", "Anup Kumar", "Ashish Sharma", "Ashutosh Singh", "Bhupender Rawat", "Devasis Roy", "Dhirendra Singh", "Dhruv Sharma"], delay: 100}, showAutocompleteOnFocus: !0, delimiter: [",", " ", "-", "_"]});
    var b = new Bloodhound({local: [{value: "Anand Saurabh"}, {value: "Ankush Aggarwal"}, {value: "Anup Kumar"}, {value: "Ashish Sharma"}, {value: "Ashutosh Singh"}, {value: "Bhupender Rawat"}, {value: "Devasis Roy"}, {value: "Dhirendra Singh"}, {value: "Dhruv Sharma"}], datumTokenizer: function(a) {
            return Bloodhound.tokenizers.whitespace(a.value)
        }, queryTokenizer: Bloodhound.tokenizers.whitespace});
    b.initialize(), a("#tokenfield-typeahead").tokenfield({typeahead: [null, {source: b.ttAdapter()}]}), a("#tokenfield-2").on("tokenfield:createtoken", function(a) {
        var b = a.attrs.value.split("|");
        a.attrs.value = b[1] || b[0], a.attrs.label = b[1] ? b[0] + " (" + b[1] + ")" : b[0]
    }).on("tokenfield:createdtoken", function(b) {
        var c = /\S+@\S+\.\S+/, d = c.test(b.attrs.value);
        d || a(b.relatedTarget).addClass("invalid")
    }).on("tokenfield:edittoken", function(a) {
        if (a.attrs.label !== a.attrs.value) {
            var b = a.attrs.label.split(" (");
            a.attrs.value = b[0] + "|" + a.attrs.value
        }
    }).on("tokenfield:removedtoken", function(b) {
        if (b.attrs.length > 1) {
            var c = a.map(b.attrs, function(a) {
                return a.value
            });
            alert(b.attrs.length + " tokens removed! Token values were: " + c.join(", "))
        } else
            alert("Token removed! Token value was: " + b.attrs.value)
    }).tokenfield()
});




