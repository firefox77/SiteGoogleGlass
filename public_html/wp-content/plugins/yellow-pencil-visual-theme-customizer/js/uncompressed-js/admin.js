! function(t) {
    "use strict"; 
    t(document).ready(function(){
        t(document).on("click", ".yp-btn", function() {
            if ("pending" == t("#hidden_post_status").val() || "private" == t("#hidden_post_status").val() || "draft" == t("#hidden_post_status").val() || "publish" == t("#hidden_post_status").val() || undefined == t("#hidden_post_status").val()) {
                var n = t("#sample-permalink").find("a").attr("href"),
                    e = t("#post_ID").val();
                    if(n == 'undefined' || n === undefined){
                        n = t("#sample-permalink").text();
                    }
                    if(n.indexOf("://") != -1){
                        n = n.split("://")[1];
                    }
                n = "admin.php?page=yellow-pencil-editor&href=" + encodeURIComponent(n) + "&yp_page_id=" + e + "&yp_page_type=" + typenow + "&yp_mode=single", window.open(n, "_blank")
            } else alert("Please save this post as draft or publish.")
        }), 0 == t("body").hasClass("post-type-attachment") && t("#postbox-container-1").length > 0 && (t("#postbox-container-1").prepend("<a class='yp-btn'><span class='dashicons dashicons-admin-appearance'></span>Edit Page - Yellow Pencil</a>"))
    })
}(jQuery);