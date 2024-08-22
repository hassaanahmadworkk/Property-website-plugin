
 $(document).ready(function() {
    $(".sd-CustomSelect").multipleSelect({
      selectAll: false,
      onOptgroupClick: function(view) {
        $(view).parents("label").addClass("selected-optgroup");
      }
    });
  });
