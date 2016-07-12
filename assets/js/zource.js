function updateWidgets(container) {
    var data = {
        'layout': String(container.attr("data-zource-container-layout"))
    };

    $.ajax({
        'type': 'post',
        'url': container.closest("[data-zource-container-update-url]").attr("data-zource-container-update-url"),
        'data': data
    });
}

$(function() {
    $("#zource-dialog-add-gadget li button").on("click", function() {
        var gadgetKey = $(this).data('zui-gadget'), emptyColumns, emptyColumn, gadget;

        zui.Dialog.close(this);

        gadget = $("<div>").addClass("zui-gadget").html('<p>test</p>');

        emptyColumns = $(".zui-gadget-empty");

        // When there are no empty columns, we add the widget to the last column, else we pick the
        // first empty column to add the widget to.
        if (emptyColumns.length === 0) {
            $(".zui-gadget-column:last").append(gadget);
        } else {
            emptyColumn = $(emptyColumns.get(0)).parent();
            emptyColumn.append(gadget);

            $(".zui-gadget-empty", emptyColumn).remove();
        }
    });

    $(".zource-dialog-set-layout-item").on("click", function() {
        var dialog = $(this).closest(".zui-dialog"),
            container = $(".zui-gadgets"),
            oldLayout = String(container.attr("data-zource-container-layout")),
            newLayout = String($(this).attr("data-zource-container-layout")),
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

            var targetColumn = oldColumns.get(oldColumns.length - 2);

            $(".zui-gadget", columnToMove).appendTo(targetColumn);

            columnToMove.remove();

            oldColumns.length--;
        }

        while (oldColumns.length < columnsWidths.length) {
            var emptyContainer = $("<div>").addClass("zui-gadget zui-gadget-empty").text(container.data("zource-empty-msg"));

            $("<div>").addClass("zui-gadget-column").append(emptyContainer.show()).appendTo(container);

            oldColumns.length++;
        }

        newColumns = container.find(".zui-gadget-column");

        for (var i = 0; i < columnsWidths.length; ++i) {
            $(newColumns[i]).css('width', parseInt(columnsWidths[i]) + '%');
        }

        updateWidgets(container);
    });
});
