function ckeditor(name, showMenu) {
    //if (name == 'txtBuildingPostsContent' || name == 'txtUserActivityPostsContent' || name == 'txtBuildingArticlesContent') {
    if (showMenu == false) {
        var editor = CKEDITOR.replace(name, {
            uiColor: '#9AB8F3',
            language: 'vi',
            filebrowserImageBrowseUrl: baseURL + '/public/main/js/ckfinder/ckfinder.html?BuildingServiceType=Images',
            filebrowserFlashBrowseUrl: baseURL + '/public/main/js/ckfinder/ckfinder.html?BuildingServiceType=Flash',
            filebrowserImageUploadUrl: baseURL + '/public/main/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
            filebrowserFlashUploadUrl: baseURL + '/public/main/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
            removePlugins: 'toolbar'
        });
    } else {
        var editor = CKEDITOR.replace(name, {
            uiColor: '#9AB8F3',
            language: 'vi',
            filebrowserImageBrowseUrl: baseURL + '/public/main/js/ckfinder/ckfinder.html?BuildingServiceType=Images',
            filebrowserFlashBrowseUrl: baseURL + '/public/main/js/ckfinder/ckfinder.html?BuildingServiceType=Flash',
            filebrowserImageUploadUrl: baseURL + '/public/main/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
            filebrowserFlashUploadUrl: baseURL + '/public/main/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
            toolbar: [
                ['Source', '-', 'Save', 'NewPage', 'Preview', '-', 'Templates'],
                //['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print'],
                //['Undo', 'Redo', '-', 'Find', 'Replace', '-', 'SelectAll', 'RemoveFormat'],
                ['Undo', 'Redo', '-'],
                //['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'HiddenField'],
                ['Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript'],
                ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', 'Blockquote', 'CreateDiv'],
                ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
                ['Link', 'Unlink', 'Anchor'],
                ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak'],
                //['Styles','Format','Font','FontSize'],
                ['FontSize'],
                ['TextColor', 'BGColor'],
                //['Maximize', 'ShowBlocks','-','About']
            ]
        });
    }

}