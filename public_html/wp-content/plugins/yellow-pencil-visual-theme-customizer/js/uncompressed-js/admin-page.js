;(function($) {
 
    "use strict";

    window.define = window.define || ace.define;
    ace.config.set("basePath",window.aceEditorBase);
    ace.require("ace/ext/language_tools");

    $(".yp-code-group li").click(function(e){

        if($(e.target)[0].tagName == "LI" || $(e.target).hasClass("yp-edited-page-title")){

            var tab = $(this);

            // Can't open anymore
            if(tab.hasClass("yp-data-deleted")){
                return false;
            }

            var editorDiv = tab.next(".yp-inline-css");
            tab.toggleClass("active");
            editorDiv.toggleClass("active");

            // Set ace editor on first open
            if(editorDiv.hasClass("ace_editor") == false){

                // Set editor
                var editor = ace.edit(editorDiv.attr("id"));
                editor.setTheme("ace/theme/dawn");
                editor.getSession().setMode("ace/mode/css");
                editor.getSession().setUseWorker(false);

                // enable autocompletion and snippets
                editor.setOptions({
                    enableBasicAutocompletion: true,
                    enableSnippets: false,
                    enableLiveAutocompletion: true
                });

                // Set font size to editor
                editor.setOptions({
                    fontSize: "14px"
                });

                // Options
                editor.$blockScrolling = Infinity;
                editor.setShowPrintMargin(false);

                // No editable.
                editor.setReadOnly(true);

            }

        }

    });
    
    
    $(".yp-button-reset").click(function(){

        var el = $(this);

        if(confirm("Are you sure to want to reset defined CSS comments and all plugin options? (This process does not delete any changes)")){

            $.post(ajaxurl, {
                action: "yp_delete_stylesheet_live",
                yp_reset_options: true,
                _wpnonce: window.yp_live_styles_delete_nonce
            }).complete(function(){
                $("#yp-reset-form").submit();
            });

        }

    });


    $(".yp-delete-page-edits").click(function(){

        var text;
        var value;

        var li = $(this).parent("li");

        var deleteValue = $(this).parent("li").attr("data-delete-value");
        
        // Animation
        if(deleteValue.indexOf("|") == -1){
            text = "Are you sure you want to delete this animation?";
            var value = deleteValue;
        }else{
            text = "Are you sure you want to reset the changes?";
            var value = deleteValue.split("|")[1];
        }

        // Specific single types
        if(value == "lostpassword" || value == "register" || value == "login" || value == "home"){
            deleteValue = "TYPE|"+value;
        }

        // confirm delete
        if(confirm(text)){

            li.addClass("yp-data-deleted");

            // global delete
            if(deleteValue.indexOf("GLOBAL|") != -1){

                $.post(ajaxurl, {
                    action: "yp_delete_stylesheet_live",
                    yp_reset_global: value,
                    _wpnonce: window.yp_live_styles_delete_nonce
                }).complete(function(){

                    if($(".yp-global-group li:not(.yp-data-deleted)").length == 0){
                        $(".yp-global-group").fadeOut("slow");
                    }

                    li.css("background", "#ff7474").css("border-color", "#ff7474").fadeOut("slow");
                    li.next().css("background", "#ff7474").css("border-color", "#ff7474").fadeOut("slow");
                });

            // type delete
            }else if(deleteValue.indexOf("TYPE|") != -1){

                $.post(ajaxurl, {
                    action: "yp_delete_stylesheet_live",
                    yp_reset_type: value,
                    _wpnonce: window.yp_live_styles_delete_nonce
                }).complete(function(){

                    if($(".yp-template-group li:not(.yp-data-deleted)").length == 0){
                        $(".yp-template-group").fadeOut("slow");
                    }

                    li.css("background", "#ff7474").css("border-color", "#ff7474").fadeOut("slow");
                    li.next().css("background", "#ff7474").css("border-color", "#ff7474").fadeOut("slow");
                });

            // ID delete
            }else if(deleteValue.indexOf("ID|") != -1){

                $.post(ajaxurl, {
                    action: "yp_delete_stylesheet_live",
                    yp_reset_id: value,
                    _wpnonce: window.yp_live_styles_delete_nonce
                }).complete(function(){

                    if($(".yp-single-group li:not(.yp-data-deleted)").length == 0){
                        $(".yp-single-group").fadeOut("slow");
                    }

                    li.css("background", "#ff7474").css("border-color", "#ff7474").fadeOut("slow");
                    li.next().css("background", "#ff7474").css("border-color", "#ff7474").fadeOut("slow");
                });

            // Custom Animate Delete
            }else{

                $.post(ajaxurl, {
                    action: "yp_delete_stylesheet_live",
                    yp_delete_animate: value,
                    _wpnonce: window.yp_live_styles_delete_nonce
                }).complete(function(){
                    li.css("background", "#ff7474").css("border-color", "#ff7474").fadeOut("slow");
                    li.next().css("background", "#ff7474").css("border-color", "#ff7474").fadeOut("slow");
                });

            }


            // hide all
            if($(".yp-code-group ul li:not(.yp-data-deleted)").length == 0){
                $(".yp-tab-section").hide();
                $(".yp-no-code,.yp-no-animation").fadeIn(300);
            }

        }

    });

}(jQuery));