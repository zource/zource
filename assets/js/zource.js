$(function() {
    $(".zource-dialog-set-layout-item").on("click", function() {
        var dialog = $(this).closest(".zui-dialog"),
            container = $(".zui-gadgets"),
            oldLayout = String(container.data("zource-container-layout")),
            newLayout = String($(this).data("zource-container-layout")),
            oldColumns,
            newColumns,
            columnsWidths;

        zui.Dialog.close(this);

        if (oldLayout === newLayout) {
            return;
        }

        container.attr("data-zource-container-layout", newLayout);

        oldColumns = container.find(".zui-gadget-column");
        columnsWidths = newLayout.split('-');

        while (oldColumns.length > columnsWidths.length) {
            var columnToMove = oldColumns.get(oldColumns.length - 1);

            $(".zui-gadget-empty", columnToMove).remove();

            var gadgetsToMove = $(".zui-gadget", columnToMove);
            var targetColumn = oldColumns.get(oldColumns.length - 2);

            columnToMove.remove();

            oldColumns.length--;
        }

        while (oldColumns.length < columnsWidths.length) {
            var emptyContainer = $(".zui-gadget-empty-template").clone().removeClass("zui-gadget-empty-template");

            $("<div>").addClass("zui-gadget-column").append(emptyContainer.show()).appendTo(container);
            //<div class="zui-gadget-column" style="width: 100%;"><div class="zui-gadget zui-gadget-empty">No widgets added yet.</div></div>

            oldColumns.length++;
        }

        newColumns = container.find(".zui-gadget-column");

        for (var i = 0; i < columnsWidths.length; ++i) {
            $(newColumns[i]).css('width', parseInt(columnsWidths[i]) + '%');
        }
    });
});
