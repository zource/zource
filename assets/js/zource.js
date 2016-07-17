function addEmptyGadgetContainer(column) {
    var emptyContainer = $("<div>")
        .addClass("zui-gadget-empty")
        .text($(column).parent().data("zource-empty-msg"));

    $(column).append(emptyContainer.show())
}

function updateColumnsAfterSorting() {
    $(".zui-gadget-empty").remove();

    $(".zui-gadget-column").each(function() {
        if ($(".zui-gadget", this).length === 0) {
            addEmptyGadgetContainer(this);
        }
    });
}

function updateGadgets(container, callback) {
    var data, gadget, gadgets = [];

    console.log('updateGadgets');

    data = {
        'layout': String(container.attr("data-zource-container-layout")),
        'gadgets': []
    };

    $(".zui-gadget:not(.zui-gadget-empty)", container).each(function(index, element) {
        gadget = $(this);

        data.gadgets.push({
            'id': gadget.attr("data-zource-gadget-id") || null,
            'type': gadget.attr("data-zource-gadget-type"),
            'column': gadget.parent().prevAll(".zui-gadget-column").length,
            'position': gadget.prevAll(".zui-gadget").length
        });

        gadgets.push(gadget);
    });

    $.ajax({
        'type': 'post',
        'url': container.attr("data-zource-container-update-container-url"),
        'data': data,
        'dataType': 'json',
        'success': function(response) {
            for (var i = 0; i < response.length; ++i) {
                gadgets[i].attr("data-zource-gadget-id", response[i]);
            }

            if (callback) {
                callback();
            }
        }
    });
}

function loadGadget(gadget) {
    gadget = $(gadget);

    var loadUrl = gadget.closest(".zui-gadgets").attr("data-zource-container-load-url") + '?id=';
    loadUrl += gadget.attr("data-zource-gadget-id");

    $.ajax({
        'url': loadUrl,
        'data': {},
        'dataType': 'html',
        'success': function(response) {
            gadget.replaceWith(response);
        }
    });
}

$(function() {
    $(".zui-gadget").each(function() {
        loadGadget(this);
    });

    $(".zui-gadget-column").sortable({
        connectWith: ".zui-gadget-column",
        containment: ".zui-gadgets",
        handle: ".zui-gadget-header",
        helper: "clone",
        placeholder: "zui-gadget-highlight"
    }).disableSelection();

    $(".zui-gadget-column").on("sortupdate", function() {
        updateColumnsAfterSorting();
    });

    $(".zui-gadget-column").on("sortstop", function() {
        updateGadgets($(this).parent());
    });

    $("#zource-dialog-add-gadget li button").on("click", function() {
        var gadgetKey = $(this).data('zui-gadget'),
            container = $(".zui-gadgets"),
            emptyColumns,
            targetColumn,
            gadget;

        // The gadget to add.
        gadget = $("<div>").addClass("zui-gadget").attr("data-zource-gadget-type", gadgetKey);

        // When there are no empty columns, we add the widget to the last column, else we pick the
        // first empty column to add the widget to.
        emptyColumns = $(".zui-gadget-empty");

        if (emptyColumns.length === 0) {
            targetColumn = $(".zui-gadget-column:last");
        } else {
            targetColumn = $(emptyColumns.get(0)).parent();
        }

        targetColumn.append(gadget);

        $(".zui-gadget-empty", targetColumn).remove();

        updateGadgets(container, function() {
            console.log("callback");
            loadGadget(gadget);
        });

        zui.Dialog.close(this);
    });

    $(".zource-dialog-set-layout-item").on("click", function() {
        var dialog = $(this).closest(".zui-dialog"),
            container = $(".zui-gadgets"),
            oldLayout = String(container.attr("data-zource-container-layout")),
            newLayout = String($(this).attr("data-zource-container-layout")),
            oldColumns,
            newColumns,
            columnsWidths,
            newColumn;

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
            newColumn = $("<div>").addClass("zui-gadget-column").appendTo(container);

            addEmptyGadgetContainer(newColumn);

            oldColumns.length++;
        }

        newColumns = container.find(".zui-gadget-column");

        for (var i = 0; i < columnsWidths.length; ++i) {
            $(newColumns[i]).css('width', parseInt(columnsWidths[i]) + '%');
        }

        updateGadgets(container);
    });
});
