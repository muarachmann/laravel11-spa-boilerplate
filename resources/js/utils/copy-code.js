import $ from "cash-dom";
window.$ = $
$(function () {
    "use strict";
    // Copy original code
    $("body").on("click", ".copy-code", function() {
        let elementId = $(this).data("target");
        $(elementId)
            .find("input")[0]
            .select();
        $(elementId)
            .find("input")[0]
            .setSelectionRange(0, 99999);
        document.execCommand("copy");
    });
});
